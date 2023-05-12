<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';

if (!isset($_GET['hotel_id'])) {
  header('Location: /');
  http_response_code(303);
  exit();
}

$sql = <<<SQL
SELECT 
  hotel_id, 
  name, 
  address, 
  description, 
  ST_X(coordinate) AS lat, 
  ST_Y(coordinate) AS lng
FROM Hotels 
WHERE hotel_id = ?
SQL;
$stmt = execute($sql, [
  [$_GET['hotel_id'], PDO::PARAM_INT],
]);
$result = fetchOrFail($stmt, "Hotel corresponding id is not found");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel | <?= $result['name'] ?></title>

  <script src="/scripts/leaflet.js"></script>
  <script defer src="/scripts/script.php"></script>
  <script defer src="/scripts/alpine-collapse.js"></script>
  <script defer src="/scripts/alpine-load.js"></script>
  <script defer src="/scripts/alpine.js"></script>

  <link rel="stylesheet" href="/assets/leaflet.css">
  <link rel="stylesheet" href="/assets/page.css">
  <link rel="stylesheet" href="/assets/style.php">
</head>

<body>
  <?php insert('header'); ?>
  <main>
    <?php insert('hotel-overview', $result); ?>
    <?php insert('hotel-location', $result); ?>
  </main>
</body>

</html>
