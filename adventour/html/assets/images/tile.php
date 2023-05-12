<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';

if (!isset($_GET['x']) || !isset($_GET['y']) || !isset($_GET['z'])) {
  echo "Malformed request: missing x, y, and/or z";
  http_response_code(400);
  exit();
}

$sql = <<<SQL
SELECT image
FROM Tiles
WHERE x=? AND y=? AND z=?
SQL;
$stmt = execute($sql, [
  [$_GET['x'], PDO::PARAM_INT],
  [$_GET['y'], PDO::PARAM_INT],
  [$_GET['z'], PDO::PARAM_INT],
]);

$result = fetchOrFail($stmt, "Tile not found");

header("Content-Type: image/webp");
header("Cache-Control: public, max-age=604800");
echo $result['image'];
