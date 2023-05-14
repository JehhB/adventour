<?php include $_SERVER['DOCUMENT_ROOT'] . '/../include.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | Adventour</title>

  <script defer src="/scripts/script.php"></script>
  <script defer src="/scripts/alpine-collapse.js"></script>
  <script defer src="/scripts/alpine-swipe.js"></script>
  <script defer src="/scripts/alpine-load.js"></script>
  <script defer src="/scripts/alpine.js"></script>

  <link rel="stylesheet" href="/assets/style.php">
  <link rel="stylesheet" href="/assets/page.css">
</head>

<body>
  <?php insert('header'); ?>
  <main>
    <section class="container">
      <?php insert('carousel'); ?>
    </section>
  </main>
</body>

</html>
