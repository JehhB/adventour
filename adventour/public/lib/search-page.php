<?php
define('ITEMS_PER_PAGE', 4);
$filters = ['hotels', 'events', 'places'];
$carryovers = ['filter', 'q', 'checkin', 'checkout', 'n_adult', 'n_child', 'n_room', 'price', 'rating', 'sort_by'];
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
];

$sort_by = $sort_categories[0];
if (isset($_GET['sort_by']) and array_search($_GET['sort_by'], $sort_categories)) {
  $sort_by = $_GET['sort_by'];
}

if ($sort_by === 'hotels by rating' or $sort_by === 'hotels by price') {
  $active_filter = 'hotels';
  $filters = ['events', 'places'];
}

$rating = null;
if (isset($_GET['rating']) && $_GET['rating'] >= 0 && $_GET['rating'] <= 5) {
  $rating = intval($_GET['rating']);
}
$price_range = null;
if (isset($_GET['price']) && $_GET['price'] >= 0 && $_GET['price'] < 4) {
  $price_range = intval($_GET['price']);
}

$n_persons = ($_GET['n_adult'] ?? 0) + ($_GET['n_child'] ?? 0);

/** @var Builder */
$query = null;
if ($active_filter === 'events') {
  $query = getEvents(
    $_GET['q'] ?? '',
    $sort_by
  );
} else if ($active_filter === 'places') {
  $query = getPlaces(
    $_GET['q'] ?? '',
    $sort_by
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
if (isset($_GET['page']) && $_GET['page'] >= 1 && $_GET['page'] <= $pages) {
  $page = intval($_GET['page']);
}
$min_page = max(min($page - 2, $pages - 3), 1);
$max_page = min(max($page + 2, $min_page + 3), $pages);

$results = $query
  ->orderBy('id')
  ->limit(ITEMS_PER_PAGE)
  ->offset(($page - 1) * ITEMS_PER_PAGE)
  ->get();
