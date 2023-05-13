<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';

validOrFail(
  [
   'hotel_image_id' => $_GET['hotel_image_id'], 
  ], [
   'hotel_image_id' => [\vld\is_defined()],
  ]
);

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
