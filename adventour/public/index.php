<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';
include $_SERVER['DOCUMENT_ROOT'] . '/lib/home-page.php';

function grid_class($i) {
  $class = '';
  
  if ($i >= 2) $class .= ' hidden '; 

  if ($i >= 2 && $i < 4) $class .= ' sm:block ';
  if ($i >= 4 && $i < 6) $class .= ' lg:block ';
  if ($i >= 5 && $i < 8) $class .= ' 2xl:block ';

  return $class;
}
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
      <section class="grid grid-cols-12 gap-4 gap-y-2 sm:gap-y-4">
        <a href="<?= url('/search.php', ['sort_by' => 'events by date']) ?>" class="justify-self-start col-span-full hidden font-heading text-2xl font-semibold leading-none text-green-900 hover:underline sm:block">
          Upcoming Events
        </a>
        <carousel-container class="col-span-full lg:col-span-8 lg:row-span-2 xl:col-span-7">
          <?php foreach ($upcoming_events as $event) :  ?>
            <carousel-item link="/event.php?event_id=<?= $event->event_id ?>" image="<?= $event->image ?>" title="<?= sanitize($event->name) ?>" subtitle="<?= sanitize($event->address) ?> (<?= $event->start_date ?>)"></carousel-item>
          <?php endforeach; ?>
        </carousel-container>
        <?php foreach ($next_event_images as $image) :  ?>
          <div class="hidden flex-col overflow-hidden rounded-lg lg:col-span-4 lg:flex xl:col-span-5">
            <a href="/event.php?event_id=<?= $upcoming_events[0]->event_id ?>" class="relative h-full w-full">
              <img src="<?= $image->image ?>" alt="Image of <?= $upcoming_events[0]->name ?>" class="absolute inset-0 h-full w-full object-cover" />
            </a>
          </div>
        <?php endforeach; ?>
        <a href="<?= url('/search.php', ['sort_by' => 'events by date']) ?>" class="px-2 font-bold text-green-900 text-sm justify-self-end col-span-full sm:hidden">More upcoming event</a>
      </section>

      <section class="grid mt-4 gap-2 sm:gap-4 px-2 sm:px-0 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4">
        <a href="<?= url('/search.php', ['filter' => 'places', 'sort_by' => 'popularity']) ?>" class="justify-self-start col-span-full font-heading text-lg font-semibold leading-none text-green-900 hover:underline sm:text-2xl">
          Popular Places
        </a>
        <?php foreach ($popular_places as $i => $place) : ?>
          <a href="<?= url('/place.php', ['place_id' => $place->place_id]) ?>" class="relative h-32 rounded-lg overflow-hidden <?= grid_class($i) ?>">
            <div class="w-full h-full absolute bg-mask p-2 text-white">
              <?= $place->name ?>
            </div>
            <img src="<?= $place->image ?>" alt="Image for <?= $place->name ?>" class="w-full h-full object-cover ">
          </a>
        <?php endforeach; ?>
      </section>

      <section class="grid mt-4 gap-4 px-2 sm:px-0 min-[500px]:grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-6">
        <a href="<?= url('/search.php', ['filter' => 'hotels']) ?>" class="justify-self-start col-span-full font-heading text-lg font-semibold leading-none text-green-900 hover:underline sm:text-2xl">
          Recommended hotels
        </a>
        <?php
        foreach ($recommended_hotels as $i => $hotel) {
          insert('hotel-card', $hotel);
        }
        ?>
      </section>
    </main>
    <?php insert('footer'); ?>
    <?php insert('auth-toast'); ?>
  </div>
</body>

</html>
