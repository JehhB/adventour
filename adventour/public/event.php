<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';

use Illuminate\Database\Capsule\Manager as DB;

safe_start_session();

$event = DB::table('Events')
  ->select([
    'event_id',
    'event_id AS id',
    'name',
    'address',
    'description',
    DB::raw('ST_X(coordinate) AS lat'),
    DB::raw('ST_Y(coordinate) AS lng')
  ])->selectRaw('"event" as type')
  ->where('event_id', $_GET['event_id'] ?? 0)
  ->first();
if (!isset($event)) {
  echo "<strong>Hotel corresponding id is not found</strong>";
  http_response_code(404);
  exit();
}
extract(sanitize((array) $event));

$view_query = DB::table('EventViews')
  ->where('session_id', $_SESSION['session_id'])
  ->where('event_id', $event_id);
$view = $view_query->value('event_view_id');
if (isset($view)) {
  $view_query->update(['viewed_at' => DB::raw('CURRENT_TIMESTAMP')]);
} else {
  $view = DB::table('EventViews')
    ->insertGetId([
      'session_id' => $_SESSION['session_id'],
      'event_id' => $event_id,
    ]);
}

$images = DB::table('EventImages')
  ->select('image')
  ->where('event_id', $event_id)
  ->get()
  ->all();

$event->images = array_map(
  fn ($e) => ["src" => "/storage/event/{$e->image}", "alt" => "Gallery image for {$name}"],
  $images
);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Event | <?= $name ?></title>
</head>

<body>
  <div id="app">
    <?php insert("header"); ?>
    <main class="container mx-auto">
      <?php insert('overview', $event); ?>
    </main>
    <?php insert("footer"); ?>
    <?php insert("auth-toast"); ?>
  </div>
</body>

</html>
