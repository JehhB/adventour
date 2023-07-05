<?php
define('ITEMS_PER_PAGE', 5);
$filters = ['hotels', 'events', 'places'];
$carryovers = [
  'filter',
  'q',
  'checkin',
  'checkout',
  'n_adult',
  'n_child',
  'n_room',
  'price',
  'rating',
  'sort_by',
  'event_start',
  'place_open'
];
$active_filter = '';

if (!isset($_GET['filter']) or array_search($_GET['filter'], $filters) === false) {
  $active_filter = 'all';
} else {
  $active_filter = $_GET['filter'];
  $index = array_search($_GET['filter'], $filters);
  unset($filters[$index]);
}

$sort_categories = [
  'recommendation',
  'popularity',
  'trending',
  'hotels by rating',
  'hotels by price',
  'events by date',
];

$sort_by = $sort_categories[0];
if (isset($_GET['sort_by']) and array_search($_GET['sort_by'], $sort_categories)) {
  $sort_by = $_GET['sort_by'];
}

$rating = null;
if (isset($_GET['rating']) and $_GET['rating'] >= 0 and $_GET['rating'] <= 5) {
  $rating = intval($_GET['rating']);
}
$price_range = null;
if (isset($_GET['price']) and $_GET['price'] >= 0 and $_GET['price'] < 4) {
  $price_range = intval($_GET['price']);
}

$n_persons = ($_GET['n_adult'] ?? 1) + ($_GET['n_child'] ?? 0);

$event_filter = ['upcoming events', 'concluded events'];
$event_start = null;
if (isset($_GET['event_start']) and array_search($_GET['event_start'], $event_filter) !== false) {
  $event_start = $_GET['event_start'];
}

$place_filter = ['always open'];
$place_open = null;
if (isset($_GET['place_open']) and array_search($_GET['place_open'], $place_filter) !== false) {
  $place_open = $_GET['place_open'];
}

if ($sort_by === 'hotels by rating' or $sort_by === 'hotels by price') {
  $active_filter = 'hotels';
  $filters = ['events', 'places'];
} else if ($sort_by === 'events by date') {
  $active_filter = 'events';
  $filters = ['hotels', 'places'];
}

/** @var Builder */
$query = null;
if ($active_filter === 'events') {
  $query = getEvents(
    $_GET['q'] ?? '',
    $sort_by,
    $event_start
  );
} else if ($active_filter === 'places') {
  $query = getPlaces(
    $_GET['q'] ?? '',
    $sort_by,
    $place_open
  );
} else if ($active_filter === 'hotels') {
  $query = getHotels(
    $_GET['q'] ?? '',
    $sort_by,
    $_GET['checkin'] ?? null,
    $_GET['checkout'] ?? null,
    $price_range,
    $n_persons,
  );
} else {
  $query = getAll(
    $_GET['q'] ?? '',
    $sort_by,
    $_GET['checkin'] ?? null,
    $_GET['checkout'] ?? null,
    $price_range,
    $n_persons,
    $event_start,
    $place_open
  );
}


if (
  $sort_by === 'popularity'
  or $sort_by === 'trending'
) {
  $query->orderBy('key', 'desc');
} else {
  $query->orderBy('key', 'asc');
}

$count = $query->count();
$pages = intval(ceil($count  / ITEMS_PER_PAGE));
$page = 1;
if (isset($_GET['page']) and $_GET['page'] >= 1 and $_GET['page'] <= $pages) {
  $page = intval($_GET['page']);
}
$min_page = max(min($page - 2, $pages - 3), 1);
$max_page = min(max($page + 2, $min_page + 3), $pages);

$results = $query
  ->orderBy('id')
  ->limit(ITEMS_PER_PAGE)
  ->offset(($page - 1) * ITEMS_PER_PAGE)
  ->get();
