<?php
if (
  !isset($_GET['lat0']) ||
  !isset($_GET['lat1']) ||
  !isset($_GET['lng0']) ||
  !isset($_GET['lng1'])
) {
  echo "Malformed request: missing lat0, lat1, lng0, and/or lng1";
  http_response_code(400);
  exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';
global $conn;

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
  )
SQL;

if (isset($_GET['exclude']) && !empty($_GET['exclude'])) {
  $sql .= " AND Hotels.hotel_id != :exclude";
}
$sql .= <<<SQL
  LIMIT 12
SQL;

$stmt = $conn->prepare($sql);
if (isset($_GET['exclude']) && !empty($_GET['exclude'])) {
  $stmt->bindParam(':exclude', $_GET['exclude'], PDO::PARAM_INT);
}

$lat0 = floatval($_GET['lat0']);
$lat1 = floatval($_GET['lat1']);
$lng0 = floatval($_GET['lng0']);
$lng1 = floatval($_GET['lng1']);
$bbox = "Polygon(($lat0 $lng0,$lat0 $lng1,$lat1 $lng1,$lat1 $lng0,$lat0 $lng0))";
$stmt->bindParam(':bbox', $bbox);

$stmt->execute();

$results = $stmt->fetchAll();
header("Content-Type: application/json");
echo json_encode($results);
