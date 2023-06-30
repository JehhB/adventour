<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';

$sql = <<<SQL
SELECT
    'hotel' AS type,
    CONCAT('/hotel.php?hotel_id=', Hotels.hotel_id) AS link,
    image,
    name AS title,
    address AS subtitle
FROM Hotels
LEFT JOIN HotelImages ON HotelImages.hotel_id = Hotels.hotel_id
WHERE 
  hotel_image_id = (
    SELECT MIN(hotel_image_id)
    FROM HotelImages
    WHERE HotelImages.hotel_id = Hotels.hotel_id
  ) AND 
  metaphone LIKE :search
LIMIT 8
SQL;
$metaphone = metaphone($_GET['search'] ?? '');
$stmt = execute($sql, [':search' => "%$metaphone%"]);

header('Content-Type: application/json');
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
