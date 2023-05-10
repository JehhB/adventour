<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';
global $conn;

if (!isset($_GET['x']) || !isset($_GET['y']) || !isset($_GET['z'])) {
  echo "Malformed request: missing x, y, and/or z";
  http_response_code(400);
  exit();
}

$sql = <<<SQL
SELECT image
FROM Tiles
WHERE x=:x AND y=:y AND z=:z
SQL;

$stmt = $conn->prepare($sql);
$stmt->bindParam(':x', $_GET['x'], PDO::PARAM_INT);
$stmt->bindParam(':y', $_GET['y'], PDO::PARAM_INT);
$stmt->bindParam(':z', $_GET['z'], PDO::PARAM_INT);
$stmt->execute();

$result = $stmt->fetch();
if (!$result) {
  echo "Tile not found";
  http_response_code(404);
  exit();
}

header("Content-Type: image/webp");
header("Cache-Control: public, max-age=604800");
echo $result['image'];
