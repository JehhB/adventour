<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Query\Builder;

$user_id = protect_route();

date_default_timezone_set('Asia/Manila');
$today = date('Y-m-d');

$offering = DB::table('Offerings')
  ->select([
    'stays',
    'max_person',
    'meal_plan',
    'price',
    'original_price',
    'room_type',
    'name',
    'image',
  ])
  ->join('Rooms', 'Rooms.room_id', '=', 'Offerings.room_id')
  ->join('Hotels', 'Hotels.hotel_id', '=', 'Rooms.hotel_id')
  ->leftJoin('RoomImages', function ($join) {
    $join->on('RoomImages.room_id', '=', 'Rooms.room_id')
      ->whereColumn('RoomImages.room_id', '=', 'Rooms.room_id')
      ->limit(1);
  })
  ->where('offering_id', $_REQUEST['offering_id'] ?? 0)
  ->first();

if ($offering === null) {
  echo "<strong>Offering corresponding id is not found</strong>";
  http_response_code(404);
  exit();
}

$checkin = null;
$stay = null;

if (isset($_GET['checkin'])) {
  $checkin = date('Y-m-d', $_GET['checkin'] / 1000);

  if (isset($_GET['checkout']) && $_GET['checkout'] > $_GET['checkin']) {
    $stay = (int) ceil(($_GET['checkout'] - $_GET['checkin']) / MS_IN_DAY);
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $errors = validate($_POST, [
    'checkin' => [\vld\is_not_empty(), \vld\greater_than($today, true, "Invalid date entered")],
    'stay' => [\vld\is_not_empty(), \vld\between(1, $offering->stays, true, "Must be between 1 and {$offering->stays}")],
    'n_adult' => [\vld\is_not_empty(), \vld\greater_than(1, $offering->stays, true, "The must be 1 adult"), \vld\less_than($offering->max_person - ($_POST['n_child'] ?? 0), true, "Number of person exceeds {$offering->max_person}")],
    'n_child' => [\vld\is_not_empty(), \vld\greater_than(0, $offering->stays, true, "Invalid number entered"), \vld\less_than($offering->max_person - ($_POST['n_adult'] ?? 0), true, "Number of person exceeds {$offering->max_person}")],
    'n_room' => [\vld\is_not_empty(), \vld\greater_than(1, $offering->stays, true, "Invalid number entered")],
    'fullname' => [\vld\is_not_empty(), \vld\max_length()],
    'phone' => [\vld\is_not_empty(), \vld\max_length(13, "Invalid contact detail")],
  ]);

  if ($errors) {
    $_SESSION['error'] = $errors;
    header("Location: {$_SERVER['REQUEST_URI']}");
    exit();
  }

  DB::table('Bookings')
    ->insert([
      'offering_id' => $_POST['offering_id'],
      'user_id' => $user_id,
      'checkin' => $_POST['checkin'],
      'stay' => $_POST['stay'],
      'n_persons' => ($_POST['n_adult'] ?? 1) + ($_POST['n_child'] ?? 0),
      'n_room' => $_POST['n_room'],
      'fullname' => $_POST['fullname'],
      'phone' => $_POST['phone'],
      'notes' => substr($_POST['notes'] ?? '', 0, 255),
    ]);

  header('Location: /');
  exit();
}
