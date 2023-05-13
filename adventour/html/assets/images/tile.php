<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';

validOrFail(
  [
   'x' => $_GET['x'], 
   'y' => $_GET['y'],
   'z' => $_GET['z'],
  ], [
   'x' => [\vld\is_defined()],
   'y' => [\vld\is_defined()],
   'z' => [\vld\is_defined()],
  ]
);


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
