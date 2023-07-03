<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';
use Illuminate\Database\Capsule\Manager as DB;
safe_start_session();

$hotel = DB::table('Hotels')
  ->select([
    'hotel_id',
    'name',
    'address',
    'description',
    DB::raw('ST_X(coordinate) AS lat'),
    DB::raw('ST_Y(coordinate) AS lng')
  ])->where('hotel_id', $_GET['hotel_id'] ?? 0)
  ->first();
if (!isset($hotel)) {
  echo "<strong>Hotel corresponding id is not found</strong>";
  http_response_code(404);
  exit();
}
extract(sanitize((array) $hotel));

$view_query = DB::table('HotelViews')
  ->where('session_id', $_SESSION['session_id'])
  ->where('hotel_id', $hotel_id);
$view = $view_query->value('hotel_view_id');
if (isset($view)) {
  $view_query->update(['viewed_at' => DB::raw('CURRENT_TIMESTAMP')]);
} else {
  $view = DB::table('HotelViews')
    ->insertGetId([
      'session_id' => $_SESSION['session_id'],
      'hotel_id' => $hotel_id,
    ]);
}

$images = DB::table('HotelImages')
  ->select('image')
  ->where('hotel_id', $_GET['hotel_id'])
  ->get()
  ->all();

$hotel->images = array_map(
  fn ($e) => ["src" => "/storage/hotel/{$e->image}", "alt" => "Gallery image for {$name}"],
  $images
);

$rooms = DB::table('Rooms')
  ->select(['room_id', 'room_type', 'room_size'])
  ->where('hotel_id', $hotel_id)
  ->get();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hotel | <?= $name ?></title>
</head>

<body>
  <div id="app" v-cloak>
    <?php insert('header'); ?>
    <main class="container mx-auto space-y-4">
      <?php insert('hotel-overview', $hotel) ?>
      <scroll-spy></scroll-spy>

      <section class="px-2 sm:px-0 space-y-2" id="rooms">
        <h2 class="font-medium">Rooms</h2>
        <stay-setting></stay-setting>
        <?php
        foreach ($rooms as $room) {
          insert('room-card', $room);
        }
        ?>
      </section>

      <section id="location">
        <hotel-map lat="<?= $lat ?>" lng="<?= $lng ?>" hotel-id="<?= $hotel_id ?>">
          <hotel-summary link="#" image="<?= $images[0]['src'] ?>" caption="<?= $images[0]['alt'] ?>" title="<?= e($name) ?>" subtitle="<?= e($address) ?>"></hotel-summary>
        </hotel-map>
      </section>
    </main>
  </div>
</body>

</html>
