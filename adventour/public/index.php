<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';
include $_SERVER['DOCUMENT_ROOT'] . '/lib/home-page.php';
?>
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
            <?php foreach ($upcoming_events as $event) :  ?>
            <carousel-item
              link="/event.php?event_id=<?= $event->event_id ?>"
              image="<?= $event->image ?>"
              title="<?= sanitize($event->name) ?>"
              subtitle="<?= sanitize($event->address) ?> (<?= $event->start_date ?>)"
            ></carousel-item>
            <?php endforeach; ?>
          </carousel-container>
          <?php foreach ($next_event_images as $image) :  ?>
          <div
            class="hidden flex-col overflow-hidden rounded-lg lg:col-span-4 lg:flex xl:col-span-5"
          >
            <a
              href="/event.php?event_id=<?= $upcoming_events[0]->event_id ?>"
              class="relative h-full w-full"
            >
              <img
                src="<?= $image->image ?>"
                alt="Image of <?= $upcoming_events[0]->name ?>"
                class="absolute inset-0 h-full w-full object-cover"
              />
            </a>
          </div>
          <?php endforeach; ?>
        </section>
      </main>
    </div>
  </body>
</html>
