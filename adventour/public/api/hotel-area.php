<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';

validOrFail($_GET, [
  'lat0' => [\vld\is_defined(), \vld\is_numeric()],
  'lat1' => [\vld\is_defined(), \vld\is_numeric()],
  'lng0' => [\vld\is_defined(), \vld\is_numeric()],
  'lng1' => [\vld\is_defined(), \vld\is_numeric()],
]);

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
    ST_X(coordinate) AS lat,
    ST_Y(coordinate) AS lng
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
LIMIT 8
SQL;
$stmt = execute($sql, [
  ':bbox' => $bbox,
  'exclude' => $_GET['exclude'] ?? 0,
]);

header("Content-Type: application/json");
$output = [];
while ($result = $stmt->fetch()) {
  array_push($output, [
    'hotel_id' => $result['hotel_id'],
    'lat' => $result['lat'],
    'lng' => $result['lng'],
    'link' => "/hotel.php?hotel_id={$result['hotel_id']}",
    'image' => "/assets/images/hotelImage.php?hotel_image_id={$result['image_id']}",
    'alt' => $result['caption'],
    'name' => $result['name'],
    'address' => $result['address'],
  ]);
}
echo json_encode($output);
