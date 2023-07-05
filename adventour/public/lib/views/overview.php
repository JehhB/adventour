<?php

use Illuminate\Database\Capsule\Manager as DB;

$features = null;
if ($type === 'hotel') {
  $features = DB::table('Features')
    ->select(['feature'])
    ->join('HotelFeatures', 'HotelFeatures.feature_id', 'Features.feature_id')
    ->where('hotel_id', $id)
    ->get();
} else if ($type === 'event') {
  $features = DB::table('EventsFeaturesIM')
    ->select(['events_feature as feature'])
    ->join('EventsFeatures', 'EventsFeatures.events_feature_id', 'EventsFeaturesIM.events_feature_id')
    ->where('event_id', $id)
    ->get();
} else if ($type === 'place') {
  $features = DB::table('PlacesFeaturesIM')
    ->select(['places_feature as feature'])
    ->join('PlacesFeatures', 'PlacesFeatures.places_feature_id', 'PlacesFeaturesIM.places_feature_id')
    ->where('place_id', $id)
    ->get();
}
if (!isset($features)) return;
?>
<section class="md:grid-rows-overview mt-3 space-y-2 md:grid md:grid-cols-2 md:gap-x-4 md:space-y-0 xl:gap-x-16 2xl:gap-x-20" id="overview">
  <div class="flex h-6 items-center gap-2 px-2 sm:px-0 md:col-start-2">
    <h1 class="font-semibold leading-none text-neutral-800 lg:text-lg lg:leading-none">
      <?= $name ?>
    </h1>
    <div class="ml-auto flex gap-2">
      <like-button id="<?= $id ?>" type="<?= $type ?>"></like-button>
      <share-button class="text-zinc-600"></share-button>
    </div>
  </div>

  <h2 class="sr-only">Hotel overview</h2>

  <gallery-container class="md:col-start-1 md:row-span-4 md:row-start-1 md:self-center">
    <?php foreach ($images as $image) : ?>
      <gallery-item src="<?= $image['src'] ?>" alt="<?= $image['alt'] ?>"></gallery-item>
    <?php endforeach; ?>
  </gallery-container>

  <address class="hidden text-sm leading-none text-gray-800 md:block">
    <?= $address ?>
  </address>

  <div class="hidden justify-around gap-3 py-2 md:flex flex-col">
    <p class="text-sm leading-none text-gray-800 lg:text-sm">
      <?= $description ?>
    </p>
    <?php if ($type === 'event') : ?>
      <div class="hidden md:flex">
        <attend-button event_id="<?= $id ?>" class="w-full py-3 max-w-xs ml-auto"></attend-button>
      </div>
    <?php endif; ?>
  </div>

  <div class="px-2 md:flex md:items-center md:border-t md:border-green-900 md:px-0 md:py-4">
    <h3 class="text-base font-semibold leading-none text-gray-800 md:hidden">
      Facilities
    </h3>
    <ul class="mt-4 flex list-none flex-wrap gap-x-8 gap-y-3 text-gray-700 md:mt-0">
      <?php foreach ($features as $feature) : ?>
        <li class="list-check text-sm leading-none">
          <?= sanitize($feature->feature) ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>

  <div class="px-2 md:hidden">
    <open-button target="description" class="font-bold text-green-900 text-sm">
      Learn more
    </open-button>
  </div>

  <?php if ($type === 'event') : ?>
    <div class="px-2 md:hidden">
      <attend-button event_id="<?= $id ?>" class="w-full py-3"></attend-button>
    </div>
  <?php endif; ?>
</section>
<modal-container name="description" class="overflow-y-auto p-4">
  <h1 class="mr-8 font-semibold text-neutral-800">
    <?= $name ?>
  </h1>
  <address class="mr-8 text-sm leading-none"><?= $address ?></address>
  <p class="mt-4 text-sm text-gray-800"><?= $description ?></p>
</modal-container>
