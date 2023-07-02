<?php
safe_start_session();

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Query\Builder;


function getHotels($q = '', $sort_by = 'recommendation')
{
  $query = DB::table('Hotels')->select([
    DB::raw('"hotel" as type'),
    DB::raw("CONCAT('/hotel.php?hotel_id=', Hotels.hotel_id) AS link"),
    DB::raw("CONCAT('/storage/hotel/', image) AS image"),
    'name AS title',
    'address AS subtitle',
    'Hotels.hotel_id AS id',
    'description',
    DB::raw('ST_X(coordinate) AS lat'),
    DB::raw('ST_Y(coordinate) AS lng'),
  ])->leftJoin('HotelImages', 'HotelImages.hotel_id', '=', 'Hotels.hotel_id')
    ->where('hotel_image_id', '=', function (Builder $query) {
      $query->select('hotel_image_id')
        ->from('HotelImages')
        ->whereColumn('HotelImages.hotel_id', '=', 'Hotels.hotel_id')
        ->limit(1);
    })->where(function (Builder $query) use ($q) {
      $metaphone = metaphone($q);
      $query->where('metaphone', 'LIKE', "%$metaphone%")
        ->orWhereRaw('LOWER(address) LIKE LOWER(?)', ["%$q%"]);
    });


  if ($sort_by === 'recommendation') {
    $query->addSelect('Hotels.hotel_id AS key');
  } elseif ($sort_by === 'popularity') {
    $query->addSelect('views')
      ->joinSub(function (Builder $query) {
        $query->selectRaw('Hotels.hotel_id as hotel_id, COUNT(*) as views')
          ->from('HotelViews')
          ->whereColumn('HotelViews.hotel_id', 'Hotel.hotel_id');
      }, 'V', 'V.hotel_id', '=', 'Hotels.hotel_id');
  }

  return $query;
}
