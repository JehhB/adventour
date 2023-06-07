<?php include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home | Adventour</title>
  </head>

  <body>
    <div id="app" v-cloak>
      <?php insert('header'); ?>

      <main class="container mx-auto">
        <section class="grid grid-cols-12 gap-4">
          <h2
            class="col-span-full hidden font-heading text-2xl font-semibold leading-none text-green-900 sm:block"
          >
            Upcoming Events
          </h2>
          <carousel-container
            class="col-span-full lg:col-span-8 lg:row-span-2 xl:col-span-7"
          >
            <?php for ($i = 1; $i <= 4; $i++) :  ?>
            <carousel-item
              link="#"
              image="/assets/images/hotelImage.php?hotel_image_id=<?= $i ?>"
              title="Test <?= $i ?>"
              subtitle="Address test <?= $i ?>"
            ></carousel-item>
            <?php endfor; ?>
          </carousel-container>
          <?php for ($i = 1; $i <= 2; $i++) :  ?>
          <div
            class="hidden flex-col overflow-hidden rounded-lg lg:col-span-4 lg:flex xl:col-span-5"
          >
            <a href="#" class="relative h-full w-full">
              <img
                src="/assets/images/hotelImage.php?hotel_image_id=<?= $i?>"
                class="absolute inset-0 h-full w-full object-cover"
              />
            </a>
          </div>
          <?php endfor; ?>
        </section>
      </main>
    </div>
  </body>
</html>
