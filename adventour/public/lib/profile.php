<?php

use Ulid\Ulid;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Query\Builder;

$user = protect_route();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_FILES['pic']) && $_FILES['pic']['error'] === UPLOAD_ERR_OK) {
    $ulid = (string) Ulid::generate();
    $ext = pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION);
    $filename = "$ulid.$ext";

    move_uploaded_file($_FILES['pic']['tmp_name'], "storage/user/$filename");
    DB::table('Profiles')
      ->where('user_id', $user)
      ->update(['profile_pic' => $filename]);
  }

  if (isset($_POST['username']) && trim($_POST['username']) != '') {
    DB::table('Profiles')
      ->where('user_id', $user)
      ->update(['username' => $_POST['username']]);
  }

  header("Location: /profile.php");
  exit();
}

$n_bookings = DB::table('Bookings')
  ->where('user_id', $user)
  ->count();

$events = DB::table('EventAttend')
  ->where('user_id', $user)
  ->count();


$likedHotels = DB::table('HotelLikes')->select([
    DB::raw('"hotel" as type'),
    DB::raw("CONCAT('/hotel.php?hotel_id=', Hotels.hotel_id) AS link"),
    DB::raw("CONCAT('/storage/hotel/', image) AS image"),
    'name AS title',
    'address AS subtitle',
    'Hotels.hotel_id AS id',
    'liked_at',
  ])->join('Hotels', 'Hotels.hotel_id', '=', 'HotelLikes.hotel_id')
    ->leftJoin('HotelImages', 'HotelImages.hotel_id', '=', 'Hotels.hotel_id')
    ->where('user_id', $user)
    ->where('hotel_image_id', '=', function (Builder $query) {
      $query->select('hotel_image_id')
        ->from('HotelImages')
        ->whereColumn('HotelImages.hotel_id', '=', 'Hotels.hotel_id')
        ->limit(1);
    });

$likedEvents = DB::table('EventLikes')->select([
    DB::raw('"event" as type'),
    DB::raw("CONCAT('/event.php?event_id=', Events.event_id) AS link"),
    DB::raw("CONCAT('/storage/event/', image) AS image"),
    'name AS title',
    'address AS subtitle',
    'Events.event_id AS id',
    'liked_at',
  ])->join('Events', 'Events.event_id', '=', 'EventLikes.event_id')
    ->leftJoin('EventImages', 'EventImages.event_id', '=', 'Events.event_id')
    ->where('user_id', $user)
    ->where('event_image_id', '=', function (Builder $query) {
      $query->select('event_image_id')
        ->from('EventImages')
        ->whereColumn('EventImages.event_id', '=', 'Events.event_id')
        ->limit(1);
    });

$likedPlaces = DB::table('PlaceLikes')->select([
    DB::raw('"place" as type'),
    DB::raw("CONCAT('/place.php?place_id=', Places.place_id) AS link"),
    DB::raw("CONCAT('/storage/place/', image) AS image"),
    'name AS title',
    'address AS subtitle',
    'Places.place_id AS id',
    'liked_at',
  ])->join('Places', 'Places.place_id', '=', 'PlaceLikes.place_id')
    ->leftJoin('PlaceImages', 'PlaceImages.place_id', '=', 'Places.place_id')
    ->where('user_id', $user)
    ->where('place_image_id', '=', function (Builder $query) {
      $query->select('place_image_id')
        ->from('PlaceImages')
        ->whereColumn('PlaceImages.place_id', '=', 'Places.place_id')
        ->limit(1);
    });

$liked = $likedHotels
  ->union($likedEvents)
  ->union($likedPlaces)
  ->orderBy('liked_at', 'desc');

$likes = $liked->count();

$query = DB::table('Bookings')
  ->select([
  DB::raw('DATE_FORMAT(placed_at, "%Y/%m/%d") as placed_at'),
  DB::raw('n_room * price * stay AS total_price'),
  'booking_id',
  'status',
  'name as hotel',
  'room_type',
  'fullname',
  'checkin',
  'stay',
  'n_persons',
  'n_room'
])
  ->join('Offerings', 'Offerings.offering_id', '=', 'Bookings.offering_id')
  ->join('Rooms', 'Rooms.room_id', '=', 'Offerings.room_id')
  ->join('Hotels', 'Hotels.hotel_id', '=', 'Rooms.hotel_id')
  ->orderBy('status')
  ->where('user_id', $_SESSION['user'])
  ->limit(8);

$count = $query->count();
$bookings = $query->get();

