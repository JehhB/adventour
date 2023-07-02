<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';
include $_SERVER['DOCUMENT_ROOT'] . '/lib/search.php';

$results = getHotels($_GET['q'] ?? '')
  ->limit(8)
  ->get();

header('Content-Type: application/json');
echo json_encode($results);
