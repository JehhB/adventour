<?php
safe_start_session();

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Query\Builder;

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

  if ($sort_by === 'trending') {
    $query->addSelect('views AS key')
      ->leftJoinSub(function (Builder $query) {
        $query->selectRaw('hotel_id, COUNT(*) as views')
          ->from('HotelViews')
          ->whereRaw('viewed_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)')
          ->groupBy('hotel_id');
      }, 'V', 'V.hotel_id', '=', 'Hotels.hotel_id');
  } else if ($sort_by === 'popularity') {
    $query->addSelect('likes AS key')
      ->leftJoinSub(function (Builder $query) {
        $query->selectRaw('hotel_id, COUNT(*) as likes')
          ->from('HotelLikes')
          ->groupBy('hotel_id');
      }, 'V', 'V.hotel_id', '=', 'Hotels.hotel_id');
  } else if ($sort_by === 'hotels by price') {
    $query->addSelect('price AS key');
  } else {
    $query->addSelect('Hotels.hotel_id AS key');
  }

  return $query;
}

function getEvents($q = '', $sort_by = 'recommendation', $event_start = null)
{
  $query = DB::table('Events')->select([
    DB::raw('"event" as type'),
    DB::raw("CONCAT('/event.php?event_id=', Events.event_id) AS link"),
    DB::raw("CONCAT('/storage/event/', image) AS image"),
    'name AS title',
    'address AS subtitle',
    'Events.event_id AS id',
    'description',
    DB::raw('ST_X(coordinate) AS lat'),
    DB::raw('ST_Y(coordinate) AS lng'),
  ])->leftJoin('EventImages', 'EventImages.event_id', '=', 'Events.event_id')
    ->where('event_image_id', '=', function (Builder $query) {
      $query->select('event_image_id')
        ->from('EventImages')
        ->whereColumn('EventImages.event_id', '=', 'Events.event_id')
        ->limit(1);
    })->where(function (Builder $query) use ($q) {
      $metaphone = metaphone($q);
      $query->where('metaphone', 'LIKE', "%$metaphone%")
        ->orWhereRaw('LOWER(address) LIKE LOWER(?)', ["%$q%"]);
    });

  if ($event_start === 'upcoming events') {
    $query->whereRaw('end_date >= CURRENT_DATE()');
  } else if ($event_start === 'concluded events') {
    $query->whereRaw('end_date < CURRENT_DATE()');
  }

  if ($sort_by === 'trending') {
    $query->addSelect('views AS key')
      ->leftJoinSub(function (Builder $query) {
        $query->selectRaw('event_id, COUNT(*) as views')
          ->from('EventViews')
          ->whereRaw('viewed_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)')
          ->groupBy('event_id');
      }, 'V', 'V.event_id', '=', 'Events.event_id');
  } else if ($sort_by === 'popularity') {
    $query->addSelect('likes AS key')
      ->leftJoinSub(function (Builder $query) {
        $query->selectRaw('event_id, COUNT(*) as likes')
          ->from('EventLikes')
          ->groupBy('event_id');
      }, 'V', 'V.event_id', '=', 'Events.event_id');
  } else if ($sort_by === 'events by date') {
    $query->selectRaw("
        CASE WHEN end_date > CURRENT_DATE() THEN
        end_date ELSE DATE_ADD(start_date, INTERVAL 10 YEAR) END AS `key`
      ");
  } else if ($sort_by === 'events by attendees') {
    $query->addSelect('attendees AS key')
      ->leftJoinSub(function (Builder $query) {
        $query->selectRaw('event_id, COUNT(*) as attendees')
          ->from('EventAttend')
          ->groupBy('event_id');
      }, 'V', 'V.event_id', '=', 'Events.event_id');
  } else {
    $query->addSelect('Events.event_id AS key');
  }

  return $query;
}

function getPlaces($q = '', $sort_by = 'recommendation', $place_open = null)
{
  $query = DB::table('Places')->select([
    DB::raw('"place" as type'),
    DB::raw("CONCAT('/place.php?place_id=', Places.place_id) AS link"),
    DB::raw("CONCAT('/storage/place/', image) AS image"),
    'name AS title',
    'address AS subtitle',
    'Places.place_id AS id',
    'description',
    DB::raw('ST_X(coordinate) AS lat'),
    DB::raw('ST_Y(coordinate) AS lng'),
  ])->leftJoin('PlaceImages', 'PlaceImages.place_id', '=', 'Places.place_id')
    ->where('place_image_id', '=', function (Builder $query) {
      $query->select('place_image_id')
        ->from('PlaceImages')
        ->whereColumn('PlaceImages.place_id', '=', 'Places.place_id')
        ->limit(1);
    })->where(function (Builder $query) use ($q) {
      $metaphone = metaphone($q);
      $query->where('metaphone', 'LIKE', "%$metaphone%")
        ->orWhereRaw('LOWER(address) LIKE LOWER(?)', ["%$q%"]);
    });

  if ($place_open === 'always open') {
    $query->whereNull('open_time')
      ->whereNull('close_time');
  }

  if ($sort_by === 'trending') {
    $query->addSelect('views AS key')
      ->leftJoinSub(function (Builder $query) {
        $query->selectRaw('place_id, COUNT(*) as views')
          ->from('PlaceViews')
          ->whereRaw('viewed_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)')
          ->groupBy('place_id');
      }, 'V', 'V.place_id', '=', 'Places.place_id');
  } else if ($sort_by === 'popularity') {
    $query->addSelect('likes AS key')
      ->leftJoinSub(function (Builder $query) {
        $query->selectRaw('place_id, COUNT(*) as likes')
          ->from('PlaceLikes')
          ->groupBy('place_id');
      }, 'V', 'V.place_id', '=', 'Places.place_id');
  } else {
    $query->addSelect('Places.place_id AS key');
  }

  return $query;
}

function getAll(
  $q = '',
  $sort_by = 'recommendation',
  $checkin = null,
  $checkout = null,
  $price_range = null,
  $n_persons = null,
  $event_start = null,
  $open_time = null,
) {
  $hotel = getHotels($q, $sort_by, $checkin, $checkout, $price_range, $n_persons);
  $events = getEvents($q, $sort_by, $event_start);
  $places = getPlaces($q, $sort_by, $open_time);

  return $hotel->union($events)->union($places);
}
