<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Query\Builder;
use Ulid\Ulid;

safe_start_session();

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

  if (isset($_POST['booking_id'])) {
    DB::table('Bookings')
      ->where('booking_id', $_POST['booking_id'])
      ->update(['status' => $_POST['status']]);
  }

  header("Location: /admin.php");
  exit();
}

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
  ->where('admin_id', $_SESSION['user']);

if (isset($_GET['search'])) {

  $query->where(function (Builder $query) {
    $q = $_GET['search'];
    $query
        ->whereRaw('LOWER(name) LIKE LOWER(?)', ["%$q%"])
        ->orWhereRaw('LOWER(room_type) LIKE LOWER(?)', ["%$q%"])
        ->orWhereRaw('LOWER(fullname) LIKE LOWER(?)', ["%$q%"]);
  });
}

$count = $query->count();
$bookings = $query->get();

$avg_daily_rates = $query->avg('price');
$avg_length_of_stay = $query->avg('stay');
$avg_price_per_stay = $query->avg(DB::raw('n_room * stay * price'));

$hotel_likes = DB::table('HotelLikes')
  ->join('Hotels', 'Hotels.hotel_id', '=', 'HotelLikes.hotel_id')
  ->where('admin_id', $_SESSION['user'])
  ->count();
$event_likes = DB::table('EventLikes')
  ->join('Events', 'Events.event_id', '=', 'EventLikes.event_id')
  ->where('admin_id', $_SESSION['user'])
  ->count();
$place_likes = DB::table('PlaceLikes')
  ->join('Places', 'Places.place_id', '=', 'PlaceLikes.place_id')
  ->where('admin_id', $_SESSION['user'])
  ->count();

$hotel_views = DB::table('HotelViews')
  ->join('Hotels', 'Hotels.hotel_id', '=', 'HotelViews.hotel_id')
  ->where('admin_id', $_SESSION['user'])
  ->count();
$event_views = DB::table('EventViews')
  ->join('Events', 'Events.event_id', '=', 'EventViews.event_id')
  ->where('admin_id', $_SESSION['user'])
  ->count();
$place_views = DB::table('PlaceViews')
  ->join('Places', 'Places.place_id', '=', 'PlaceViews.place_id')
  ->where('admin_id', $_SESSION['user'])
  ->count();

$total_revenue = $query
  ->where('status', 'stayed')
  ->sum(DB::raw('n_room * stay * price'));
