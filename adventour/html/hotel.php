<?php
  include $_SERVER['DOCUMENT_ROOT'] . '/../include.php'; 
  global $conn;

  if (!isset($_GET['hotel_id'])) {
    header('Location: /');
    http_response_code(303);
    exit();
  }

  $sql = <<<SQL
SELECT hotel_id, name, address, description 
FROM Hotels 
WHERE hotel_id = :hotel_id
SQL;
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':hotel_id', $_GET['hotel_id'], PDO::PARAM_INT);
  $stmt->execute();

  $result = $stmt->fetch();
  if (!$result) {
    echo "Hotel corresponding id is not found";
    http_response_code(404);
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel | <?= $result['name'] ?></title>

  <script defer src="/scripts/script.php"></script>
  <script defer src="/scripts/alpine-collapse.js"></script>
  <script defer src="/scripts/alpine-load.js"></script>
  <script defer src="/scripts/alpine.js"></script>

  <link rel="stylesheet" href="/assets/style.php">
  <link rel="stylesheet" href="/assets/page.css">
</head>

<body>
  <?php insert('header'); ?>
  <main>
    <?php insert('hotel-overview', $result); ?>
  </main>
</body>

</html>
