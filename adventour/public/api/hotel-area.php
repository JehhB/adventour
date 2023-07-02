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

$result = $query = DB::table('Hotels')
  ->select([
    'Hotels.hotel_id AS hotel_id',
    'hotel_image_id AS image_id',
    'name', 'address', 'image',
    DB::raw('ST_X(coordinate) AS lat'),
    DB::raw('ST_Y(coordinate) AS lng'),
  ])
  ->leftJoin('HotelImages', 'HotelImages.hotel_id', '=', 'Hotels.hotel_id')
  ->whereRaw('MBRWithin(coordinate, ST_GeomFromText(?))', [$bbox])
  ->where('hotel_image_id', function ($query) {
    $query->select('hotel_image_id')
      ->from('HotelImages')
      ->whereColumn('HotelImages.hotel_id', '=', 'Hotels.hotel_id')
      ->limit(1);
  })
  ->where('Hotels.hotel_id', '!=', $_GET['exclude'] ?? 0)
  ->limit(8)
  ->get();

header("Content-Type: application/json");
$output = [];
foreach($result as $data) {
  array_push($output, [
    'hotel_id' => $data->hotel_id,
    'lat' => $data->lat,
    'lng' => $data->lng,
    'link' => url(
      '/hotel.php',
      ['hotel_id' => $data->hotel_id],
      ['checkin', 'checkout', 'n_adult', 'n_child', 'n_room']
    ),
    'image' => "/storage/hotel/{$data->image}",
    'alt' => "Thumbnail image for {$data->name}",
    'name' => $data->name,
    'address' => $data->address,
  ]);
}
echo json_encode($output);
