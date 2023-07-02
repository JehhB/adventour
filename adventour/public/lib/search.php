<?php
safe_start_session();

define('ITEMS_PER_PAGE', 4);

$sort_categories = [
  'recommendation',
  'popularity',
  'price',
  'rating',
];
$sort_by = $sort_categories[0];
if (isset($_GET['sort_by']) and array_search($_GET['sort_by'], $sort_categories)) {
  $sort_by = $_GET['sort_by'];
}

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

$rating = null;
if (isset($_GET['rating']) && $_GET['rating'] >= 0 && $_GET['rating'] <= 5) {
  $rating = intval($_GET['rating']);
}
$price_range = null;
if (isset($_GET['price']) && $_GET['price'] >= 0 && $_GET['price'] < 4) {
  $price_range = intval($_GET['price']);
}

function hotels($count = false, $sort_by = 'recommendation', $price_range = NULL) {
  $select = $count ? 'SELECT COUNT(hotel_id)' : "SELECT hotel_id as id, name, address, description, ST_X(coordinate) AS lat, ST_Y(coordinate) AS lng";
  if (isset($price_range) or $sort_by === 'recommendation') {
    $select
  }

  $where = "WHERE metaphone LIKE :metaphone";
  $from =  "FROM Hotels";
}
