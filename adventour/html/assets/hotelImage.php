<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';
global $conn;

if (!isset($_GET['hotel_image_id'])) {
  echo "Malformed request: missing hotel_image_id";
  http_response_code(400);
}

$sql = <<<SQL
SELECT image, content_type
FROM HotelImages
WHERE hotel_image_id = :id
SQL;

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $_GET['hotel_image_id']);
$stmt->execute();

$result = $stmt->fetch();
if (!$result) {
  echo "Hotel image corresponding id not found";
  http_response_code(404);
}

header("Content-Type: {$result['content_type']}");
echo $result['image'];
