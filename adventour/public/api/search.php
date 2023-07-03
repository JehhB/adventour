<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';
include $_SERVER['DOCUMENT_ROOT'] . '/lib/search.php';

$search = $_GET['q'] ?? '';
$query = match ($_GET['filter'] ?? 'all') {
  'hotels' => getHotels($search),
  'events' => getEvents($search),
  'places' => getPlaces($search),
  default => getAll($search),
};

$results = $query
  ->orderBy('key')
  ->limit(8)
  ->get();

header('Content-Type: application/json');
echo json_encode($results);
