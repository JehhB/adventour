<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../includes/template.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Listing | Adventour</title>
  <link rel="shortcut icon" href="/assets/logo.png" type="image/x-icon" />

  <script defer src="./scripts/script.php"></script>
  <script defer src="./scripts/alpine-collapse.js"></script>
  <script defer src="./scripts/alpine-swipe.js"></script>
  <script defer src="./scripts/alpine.js"></script>

  <link rel="stylesheet" href="./assets/style.php">
</head>

<body>
  <?php insert('header'); ?>

  <main>
    <?php insert('listing-details'); ?>
  </main>
</body>

</html>
