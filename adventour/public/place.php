<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Query\Builder;

safe_start_session();

$place = DB::table('Places')
  ->select([
    'place_id',
    'place_id AS id',
    'name',
    'address',
    'coordinate',
    'description',
    DB::raw('ST_X(coordinate) AS lat'),
    DB::raw('ST_Y(coordinate) AS lng')
  ])->selectRaw('"place" as type')
  ->where('place_id', $_GET['place_id'] ?? 0)
  ->first();
if (!isset($place)) {
  echo "<strong>Hotel corresponding id is not found</strong>";
  http_response_code(404);
  exit();
}
extract(sanitize((array) $place));

$view_query = DB::table('PlaceViews')
  ->where('session_id', $_SESSION['session_id'])
  ->where('place_id', $place_id);
$view = $view_query->value('place_view_id');
if (isset($view)) {
  $view_query->update(['viewed_at' => DB::raw('CURRENT_TIMESTAMP')]);
} else {
  $view = DB::table('PlaceViews')
    ->insertGetId([
      'session_id' => $_SESSION['session_id'],
      'place_id' => $place_id,
    ]);
}

$images = DB::table('PlaceImages')
  ->select('image')
  ->where('place_id', $place_id)
  ->get()
  ->all();

$place->images = array_map(
  fn ($e) => ["src" => "/storage/place/{$e->image}", "alt" => "Gallery image for {$name}"],
  $images
);

$hotels = DB::table('Hotels')
  ->select([
    'Hotels.hotel_id as id',
    'name AS title',
    'address AS subtitle',
    DB::raw('"hotel" AS type'),
  ])
  ->selectRaw("CONCAT('/hotel.php?hotel_id=', Hotels.hotel_id) AS link")
  ->selectRaw("CONCAT('/storage/hotel/', image) AS image")
  ->leftJoin('HotelImages', 'HotelImages.hotel_id', '=', 'Hotels.hotel_id')
  ->where('hotel_image_id', '=', function (Builder $query) {
    $query->select('hotel_image_id')
      ->from('HotelImages')
      ->whereColumn('HotelImages.hotel_id', '=', 'Hotels.hotel_id')
      ->limit(1);
  })->orderByRaw("ST_Distance(coordinate, ?)", [$place->coordinate])
  ->limit('12')
  ->get();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Place | <?= $name ?></title>
</head>

<body>
  <div id="app" v-cloak>
    <?php insert("header"); ?>
    <main class="container mx-auto">
      <?php insert('overview', $place); ?>

      <section id="hotels" class="grid mt-4 gap-4 px-2 sm:px-0 min-[500px]:grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-6">
        <h2 class="col-span-full font-heading text-lg font-semibold leading-none text-green-900 sm:text-2xl px-2 sm:px-0">
          Nearby hotels
        </h2>
        <?php
        foreach ($hotels as $hotel) {
          insert('hotel-card', $hotel);
        }
        ?>
      </section>

      <section id="location">
        <h2 class="col-span-full font-heading text-lg font-semibold leading-none text-green-900 sm:text-2xl px-2 sm:px-0">
          Location
        </h2>
        <hotel-map lat="<?= $lat ?>" lng="<?= $lng ?>" place-id="<?= $place_id ?>" class="mt-2">
          <search-summary icon="b-icon-pin-map-fill" link="#" image="<?= $place->images[0]['src'] ?>" caption="<?= $place->images[0]['alt'] ?>" title="<?= e($name) ?>" subtitle="<?= e($address) ?>"></search-summary>
        </hotel-map>
      </section>

    </main>
    <?php insert("footer"); ?>
    <?php insert("auth-toast"); ?>
  </div>
</body>

</html>
