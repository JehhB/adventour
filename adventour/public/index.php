<?php include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | Adventour</title>
</head>

<body>
  <div id="app">
    <?php insert('header'); ?>

    <main class="container mx-auto">
      <carousel-container>
        <?php for ($i = 1; $i <= 4; $i++) :  ?>
          <carousel-item link="#" image="/assets/images/hotelImage.php?hotel_image_id=<?= $i ?>" title="Test <?= $i ?>" subtitle="Address test <?= $i ?>"></carousel-item>
        <?php endfor; ?>
      </carousel-container>
    </main>
  </div>
</body>

</html>
