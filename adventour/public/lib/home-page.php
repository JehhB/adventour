<?php

use Illuminate\Database\Capsule\Manager as DB;

safe_start_session();

$upcoming_events = DB::table('Events')
  ->select(['event_id', 'name', 'address'])
  ->orderByRaw('end_date >= CURRENT_DATE() DESC')
  ->orderBy('start_date')
  ->limit(4)
  ->get();
