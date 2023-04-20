<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/style.css">
  <link rel="shortcut icon" href="/assets/logo.png" type="image/x-icon">
  <title><?= $title ?></title>

  <?php insert_section('head') ?>
  <?php insert_section('embed') ?>

  <script src="/scripts/alpine.js" defer></script>
</head>
<body>
  <?= $children ?>
</body>
</html>
