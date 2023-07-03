<?php
safe_start_session();

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Query\Builder;

define('MS_IN_DAY', 1000 * 60 * 60 * 24);

function getHotels($q = '', $sort_by = 'recommendation', $checkin = null, $checkout = null, $price_range = null, $n_persons = null)
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

  if (
    $checkin !== null and $checkout !== null
    or $price_range !== null
    or $n_persons !== null
    or $sort_by === 'hotels by price'
  ) {
    $query
      ->join('Rooms', 'Rooms.hotel_id', '=', 'Hotels.hotel_id')
      ->join('Offerings', 'Offerings.room_id', '=', 'Rooms.room_id')
      ->where('offering_id', '=', function (Builder $query) use (
        $price_range,
        $n_persons,
        $checkin,
        $checkout
      ) {
        $query->select('offering_id')
          ->from('Offerings')
          ->join('Rooms', 'Rooms.room_id', '=', 'Offerings.room_id')
          ->whereColumn('Rooms.hotel_id', '=', 'Hotels.hotel_id')
          ->orderBy('price')
          ->limit('1');

        if ($price_range === 0) {
          $query->where('price', '<', 2000);
        } else if ($price_range === 1) {
          $query->where('price', '>=', 2000)
            ->where('price', '<', 3000);
        } else if ($price_range === 2) {
          $query->where('price', '>=', 3000)
            ->where('price', '<', 4000);
        } else if ($price_range === 3) {
          $query->where('price', '>=', 4000);
        }

        if ($n_persons !== null) {
          $query->where('max_person', '>=', $n_persons);
        }

        if ($checkin !== null and $checkout !== null) {
          $days = ($checkout - $checkin) / MS_IN_DAY;
          $query->where('stays', '>=', $days);
        }
      });
  }

  if ($sort_by === 'popularity') {
    $query->addSelect('views AS key')
      ->joinSub(function (Builder $query) {
        $query->selectRaw('hotel_id, COUNT(*) as views')
          ->from('HotelViews')
          ->groupBy('hotel_id');
      }, 'V', 'V.hotel_id', '=', 'Hotels.hotel_id');
  } else if ($sort_by === 'hotels by price') {
    $query->addSelect('price AS key');
  } else {
    $query->addSelect('Hotels.hotel_id AS key');
  }

  return $query;
}

function getEvents($q = '', $sort_by='recommendation')
{
  $query = DB::table('Events')->select([
    DB::raw('"event" as type'),
    DB::raw("CONCAT('/event.php?event_id=', Events.event_id) AS link"),
    DB::raw("'/assets/images/no_image.svg' AS image"),
    'name AS title',
    'address AS subtitle',
    'Events.event_id AS id',
    'description',
    DB::raw('ST_X(coordinate) AS lat'),
    DB::raw('ST_Y(coordinate) AS lng'),
  ])->where(function (Builder $query) use ($q) {
      $metaphone = metaphone($q);
      $query->where('metaphone', 'LIKE', "%$metaphone%")
        ->orWhereRaw('LOWER(address) LIKE LOWER(?)', ["%$q%"]);
    });

  $query->addSelect('Events.event_id AS key');
  return $query;
}

function getPlaces($q = '', $sort_by='recommendation')
{
  $query = DB::table('Places')->select([
    DB::raw('"place" as type'),
    DB::raw("CONCAT('/place.php?place_id=', Places.place_id) AS link"),
    DB::raw("'/assets/images/no_image.svg' AS image"),
    'name AS title',
    'address AS subtitle',
    'Places.place_id AS id',
    'description',
    DB::raw('ST_X(coordinate) AS lat'),
    DB::raw('ST_Y(coordinate) AS lng'),
  ])->where(function (Builder $query) use ($q) {
      $metaphone = metaphone($q);
      $query->where('metaphone', 'LIKE', "%$metaphone%")
        ->orWhereRaw('LOWER(address) LIKE LOWER(?)', ["%$q%"]);
    });

  $query->addSelect('Places.place_id AS key');
  return $query;
}

function getAll($q = '', $sort_by = 'recommendation', $checkin = null, $checkout = null, $price_range = null, $n_persons = null) {
  $hotel = getHotels($q, $sort_by, $checkin, $checkout, $price_range, $n_persons);
  $events = getEvents($q, $sort_by);
  $places = getPlaces($q, $sort_by);

  return $hotel->union($events)->union($places);
}
