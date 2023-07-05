<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';

use Illuminate\Database\Capsule\Manager as DB;

$params = params();
$auth = is_auth();

$goers = DB::table('EventAttend')
  ->where('event_id', $params['event_id'])
  ->count();

$going = !$auth ? false : DB::table('EventAttend')
  ->where('event_id', $params['event_id'])
  ->where('user_id', $auth)
  ->first() !== null;

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  if (!$auth) {
    http_response_code(403);
    exit();
  }
  if ($going) return;

  DB::table('EventAttend')->insert([
    'event_id' => $params['event_id'],
    'user_id' => $auth,
  ]);
  $going = true;
  ++$goers;
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  if (!$auth) {
    http_response_code(403);
    exit();
  }
  if (!$going) return;

  DB::table('EventAttend')
    ->where('event_id', $params['event_id'])
    ->where('user_id', $auth)
    ->delete();

  $going = false;
  --$goers;
}

header('Content-Type: application/json');
echo json_encode([
  'authenticated' => !!$auth,
  'going' => $going,
  'goers' => $goers,
]);


