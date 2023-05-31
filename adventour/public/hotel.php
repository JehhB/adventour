<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';

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

$sql = <<<SQL
SELECT hotel_image_id, caption
FROM HotelImages
WHERE hotel_id = ?
ORDER BY caption = '', hotel_image_id
SQL;
$stmt = execute($sql, [$result['hotel_id']]);

$result['images'] = array_map(fn ($e) => [
  "src" => "/assets/images/hotelImage.php?hotel_image_id={$e['hotel_image_id']}",
  "alt" => $e['caption'] === '' ? 'Gallery image for hotel' : e($e['caption']),
], $stmt->fetchAll());

extract($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel | <?= $result['name'] ?></title>
</head>

<body>
  <div id="app">
    <?php insert('header'); ?>
    <main class="container mx-auto space-y-4">
      <?php insert('hotel-overview', $result) ?>
      <hotel-map lat="<?= $lat ?>" lng="<?= $lng ?>" hotel-id="<?= $hotel_id ?>">
        <hotel-summary link="/hotel.php?hotel_id=<?= $hotel_id ?>" image="<?= $images[0]['src'] ?>" caption="<?= $images[0]['alt'] ?>" title="<?= e($name) ?>" subtitle="<?= e($address) ?>"></hotel-summary>
      </hotel-map>
    </main>
  </div>
</body>

</html>
