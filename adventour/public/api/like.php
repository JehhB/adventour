<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';

use Illuminate\Database\Capsule\Manager as DB;

$params = params();
$auth = is_auth();

$table = match ($params['type']) {
  'hotel' => 'HotelLikes',
  'event' => 'EventLikes',
  'place' => 'PlaceLikes',
};
$id = match ($params['type']) {
  'hotel' => 'hotel_id',
  'event' => 'event_id',
  'place' => 'place_id',
};

$likes = !$auth ? 0 : DB::table($table)
  ->where($id, $params['id'])
  ->count();
$liked = !$auth ? false : DB::table($table)
  ->where($id, $params['id'])
  ->where('user_id', $auth)
  ->first() !== null;

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  if (!$auth) {
    http_response_code(403);
    exit();
  }
  if ($liked) return;

  DB::table($table)->insert([
    $id => $params['id'],
    'user_id' => $auth,
  ]);
  $liked = true;
  ++$likes;
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  if (!$auth) {
    http_response_code(403);
    exit();
  }
  if (!$liked) return;

  DB::table($table)
    ->where($id, $params['id'])
    ->where('user_id', $auth)
    ->delete();

  $liked = false;
  --$likes;
}

header('Content-Type: application/json');
echo json_encode([
  'authenticated' => !!$auth,
  'liked' => $liked,
  'likes' => $likes,
]);


