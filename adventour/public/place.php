<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';

use Illuminate\Database\Capsule\Manager as DB;

safe_start_session();

$place = DB::table('Places')
  ->select([
    'place_id',
    'place_id AS id',
    'name',
    'address',
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Place | <?= $name ?></title>
</head>

<body>
  <div id="app">
    <?php insert("header"); ?>
    <main class="container mx-auto">
      <?php insert('overview', $place); ?>
    </main>
    <?php insert("footer"); ?>
    <?php insert("auth-toast"); ?>
  </div>
</body>

</html>
