<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';

use Illuminate\Database\Capsule\Manager as DB;

validOrFail($_GET, [
  'lat0' => [\vld\is_defined(), \vld\is_numeric()],
  'lat1' => [\vld\is_defined(), \vld\is_numeric()],
  'lng0' => [\vld\is_defined(), \vld\is_numeric()],
  'lng1' => [\vld\is_defined(), \vld\is_numeric()],
]);

$lat0 = floatval($_GET['lat0']);
$lat1 = floatval($_GET['lat1']);
$lng0 = floatval($_GET['lng0']);
$lng1 = floatval($_GET['lng1']);
$bbox = "Polygon(($lat0 $lng0,$lat0 $lng1,$lat1 $lng1,$lat1 $lng0,$lat0 $lng0))";

function getHotels()
{
  global $bbox;

  return DB::table('Hotels')
    ->select([
      'Hotels.hotel_id AS id',
      'name', 'address', 
      DB::raw('"hotel" AS type'),
      DB::raw("CONCAT('/storage/hotel/', image) AS image"),
      DB::raw('ST_X(coordinate) AS lat'),
      DB::raw('ST_Y(coordinate) AS lng'),
    ])->leftJoin('HotelImages', 'HotelImages.hotel_id', '=', 'Hotels.hotel_id')
    ->whereRaw('MBRWithin(coordinate, ST_GeomFromText(?))', [$bbox])
    ->where('hotel_image_id', function ($query) {
      $query->select('hotel_image_id')
        ->from('HotelImages')
        ->whereColumn('HotelImages.hotel_id', '=', 'Hotels.hotel_id')
        ->limit(1);
    })->where('Hotels.hotel_id', '!=', $_GET['hotel_id'] ?? 0)
    ->limit(8);
}

function getEvents()
{
  global $bbox;

  return DB::table('Events')
    ->select([
      'Events.event_id AS id',
      'name', 'address', 
      DB::raw('"event" AS type'),
      DB::raw("CONCAT('/storage/event/', image) AS image"),
      DB::raw('ST_X(coordinate) AS lat'),
      DB::raw('ST_Y(coordinate) AS lng'),
    ])->leftJoin('EventImages', 'EventImages.event_id', '=', 'Events.event_id')
    ->whereRaw('MBRWithin(coordinate, ST_GeomFromText(?))', [$bbox])
    ->where('event_image_id', function ($query) {
      $query->select('event_image_id')
        ->from('EventImages')
        ->whereColumn('EventImages.event_id', '=', 'Events.event_id')
        ->limit(1);
    })->where('Events.event_id', '!=', $_GET['event_id'] ?? 0);
}

function getPlaces()
{
  global $bbox;

  return DB::table('Places')
    ->select([
      'Places.place_id AS id',
      'name', 'address', 
      DB::raw('"place" AS type'),
      DB::raw("CONCAT('/storage/place/', image) AS image"),
      DB::raw('ST_X(coordinate) AS lat'),
      DB::raw('ST_Y(coordinate) AS lng'),
    ])->leftJoin('PlaceImages', 'PlaceImages.place_id', '=', 'Places.place_id')
    ->whereRaw('MBRWithin(coordinate, ST_GeomFromText(?))', [$bbox])
    ->where('place_image_id', function ($query) {
      $query->select('place_image_id')
        ->from('PlaceImages')
        ->whereColumn('PlaceImages.place_id', '=', 'Places.place_id')
        ->limit(1);
    })->where('Places.place_id', '!=', $_GET['place_id'] ?? 0);
}

$hotels = getHotels();
$events = getEvents();
$places = getPlaces();

$result = $hotels
  ->union($events)
  ->union($places)
  ->orderBy('id')
  ->limit(12)
  ->get();

header("Content-Type: application/json");
$output = [];
foreach ($result as $data) {
  array_push($output, [
    'type' => $data->type,
    'id' => $data->id,
    'lat' => $data->lat,
    'lng' => $data->lng,
    'link' => match ($data->type) {
      'hotel' => url(
        '/hotel.php',
        ['hotel_id' => $data->id],
        ['checkin', 'checkout', 'n_adult', 'n_child', 'n_room']
      ),
      'event' => url(
        'event.php',
        ['event_id' => $data->id],
      ),
      'place' => url(
        'place.php',
        ['place_id' => $data->id],
      )
    },
    'image' => $data->image,
    'alt' => "Thumbnail image for {$data->name}",
    'name' => $data->name,
    'address' => $data->address,
  ]);
}
echo json_encode($output);
