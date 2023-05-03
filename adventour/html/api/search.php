<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';
global $conn;

$sql = <<<SQL
SELECT 
  MIN(Hotels.hotel_id) AS hotel_id,
  MIN(hotel_image_id) AS image_id,
  MIN(name) AS name, 
  MIN(address) AS address,
  MIN(description) as description
FROM Hotels LEFT JOIN HotelImages
ON HotelImages.hotel_id = Hotels.hotel_id
WHERE caption != ''
SQL;

if (isset($_GET['q']) && !empty($_GET['q'])) {
  $sql .= " AND metaphone LIKE :q";
}
$sql .= <<<SQL

GROUP BY Hotels.hotel_id
LIMIT 4
SQL;

$stmt = $conn->prepare($sql);
if (isset($_GET['q']) && !empty($_GET['q'])) {
  $metaphone = metaphone($_GET['q']);
  $param = "%$metaphone%";
  $stmt->bindParam(':q', $param);
}
$stmt->execute();

foreach ($stmt->fetchAll() as $result) {
  insert('search-summary', [
    'isLoading' => false,
    'link' => "/hotels.php?hotel_id={$result['hotel_id']}",
    'image' => "/assets/hotelImage.php?hotel_image_id={$result['image_id']}",
    'alt' => "Image of {$result['name']}",
    'name' => $result['name'],
    'address' => $result['address'],
  ]);
}
