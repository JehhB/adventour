<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';

if (!isset($_GET['hotel_image_id'])) {
  echo "Malformed request: missing hotel_image_id";
  http_response_code(400);
  exit();
}

$sql = <<<SQL
SELECT image, content_type
FROM HotelImages
WHERE hotel_image_id = :id
SQL;
$stmt = execute($sql, [':id' => $_GET['hotel_image_id']]);
$result = fetchOrFail($stmt, "Hotel image corresponding id not found");

header("Content-Type: {$result['content_type']}");
header("Cache-Control: public, max-age=604800");
echo $result['image'];
