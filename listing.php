<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Listing | Adventour</title>
  <link rel="shortcut icon" href="/assets/logo.png" type="image/x-icon" />

  <script src="/scripts/alpine-collapse.js" defer></script>
  <script src="/scripts/alpine-swipe.js"></script>
  <script src="/scripts/alpine.js" defer></script>

  <link rel="stylesheet" href="./style.css">
</head>

<body>
  <?php insert('header'); ?>

  <main>
    <?php insert('listing-details'); ?>
  </main>

  <?php insert_section('embed'); ?>
</body>

</html>
