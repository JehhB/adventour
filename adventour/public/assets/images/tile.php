<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';

validOrFail($_GET, [
  'x' => [\vld\is_defined(), \vld\is_numeric()],
  'y' => [\vld\is_defined(), \vld\is_numeric()],
  'z' => [\vld\is_defined(), \vld\is_numeric()],
]);


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
