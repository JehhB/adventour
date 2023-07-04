<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Query\Builder;

safe_start_session();

$upcoming_events = DB::table('Events')
  ->select([
    'Events.event_id AS event_id',
    'name',
    'address',
    DB::raw("DATE_FORMAT(start_date, '%m/%d') AS start_date"),
    DB::raw("CONCAT('/storage/event/', image) AS image")
  ])->leftJoin('EventImages', 'EventImages.event_id', '=', 'Events.event_id')
  ->where('event_image_id', '=', function (Builder $query) {
    $query->select('event_image_id')
      ->from('EventImages')
      ->whereColumn('EventImages.event_id', '=', 'Events.event_id')
      ->limit(1);
  })->orderByRaw('end_date >= CURRENT_DATE() DESC')
  ->orderBy('start_date')
  ->limit(4)
  ->get();

$next_event_images = DB::table('EventImages')
  ->selectRaw("CONCAT('/storage/event/', image) AS image")
  ->where('event_id', $upcoming_events[0]->event_id)
  ->limit(2)
  ->offset(1)
  ->get();
