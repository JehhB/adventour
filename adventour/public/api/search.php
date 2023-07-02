<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';
use Illuminate\Database\Capsule\Manager as DB;

$metaphone = metaphone($_GET['search'] ?? '');

$results = DB::table('Hotels')
  ->select(
    DB::raw('"hotel" as type'),
    DB::raw("CONCAT('/hotel.php?hotel_id=', Hotels.hotel_id) AS link"),
    DB::raw("CONCAT('/storage/hotel/', image) AS image"),
    'name AS title',
    'address AS subtitle'
  )->leftJoin('HotelImages', 'HotelImages.hotel_id', '=', 'Hotels.hotel_id')
  ->where('hotel_image_id', '=', function ($query) {
    $query->select('hotel_image_id')
      ->from('HotelImages')
      ->whereColumn('HotelImages.hotel_id', '=', 'Hotels.hotel_id')
      ->limit(1);
  })
  ->where('metaphone', 'LIKE', '%' . $metaphone . '%')
  ->limit(8)
  ->get();

header('Content-Type: application/json');
echo json_encode($results);
