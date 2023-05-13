<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';

validOrFail(
  [
   'lat0' => $_GET['lat0'], 
   'lat1' => $_GET['lat1'],
   'lng0' => $_GET['lng0'],
   'lng1' => $_GET['lng1'],
  ], [
   'lat0' => [\vld\is_defined()],
   'lat1' => [\vld\is_defined()],
   'lng0' => [\vld\is_defined()],
   'lng1' => [\vld\is_defined()],
  ]
);

$lat0 = floatval($_GET['lat0']);
$lat1 = floatval($_GET['lat1']);
$lng0 = floatval($_GET['lng0']);
$lng1 = floatval($_GET['lng1']);
$bbox = "Polygon(($lat0 $lng0,$lat0 $lng1,$lat1 $lng1,$lat1 $lng0,$lat0 $lng0))";

$sql = <<<SQL
SELECT
    Hotels.hotel_id hotel_id,
    hotel_image_id AS image_id,
    caption,
    name,
    address,
    description
FROM
    Hotels
LEFT JOIN HotelImages ON HotelImages.hotel_id = Hotels.hotel_id
WHERE 
  MBRWithin(coordinate, ST_GeomFromText(:bbox)) AND
  hotel_image_id = (
    SELECT MIN(hotel_image_id)
    FROM HotelImages
    WHERE caption != '' AND HotelImages.hotel_id = Hotels.hotel_id
  ) AND
  Hotels.hotel_id != :exclude
LIMIT 12
SQL;
$stmt = execute($sql, [
  ':bbox' => $bbox,
  'exclude' => $_GET['exclude'] ?? 0,
]);

$results = $stmt->fetchAll();
header("Content-Type: application/json");
echo json_encode($results);
