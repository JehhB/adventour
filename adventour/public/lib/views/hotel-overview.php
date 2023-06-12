<?php
$sql = <<<SQL
SELECT feature
FROM Features
JOIN HotelFeatures ON HotelFeatures.feature_id = Features.feature_id
WHERE hotel_id = ?
SQL;
$stmt = execute($sql, [$hotel_id]);
?>
<section class="md:grid-rows-overview mt-3 space-y-2 md:grid md:grid-cols-2 md:gap-x-4 md:space-y-0 xl:gap-x-16 2xl:gap-x-20">
  <div class="flex h-6 items-center gap-2 px-2 sm:px-0 md:col-start-2">
    <h1 class="font-semibold leading-none text-neutral-800"><?= $name ?></h1>
    <div class="ml-auto flex gap-2">
      <open-button target="not authenticated toast">
        <b-icon-heart-fill class="stroke-2 text-zinc-600"></b-icon-heart-fill>
      </open-button>
      <b-icon-share-fill class="stroke-2 text-zinc-600"></b-icon-share-fill>
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

  <div class="hidden items-center py-2 md:flex">
    <p class="text-sm leading-none text-gray-800">
      <?= $description ?>
    </p>
  </div>

  <div class="px-2 md:flex md:items-center md:border-t md:border-green-900 md:px-0 md:py-4">
    <h3 class="text-base font-semibold leading-none text-gray-800 md:hidden">
      Facilities
    </h3>
    <ul class="mt-4 flex list-none flex-wrap gap-x-8 gap-y-3 text-gray-700 md:mt-0">
      <?php while ($facility = $stmt->fetch()) : ?>
        <li class="list-check text-sm leading-none">
          <?= e($facility['feature']) ?>
        </li>
      <?php endwhile; ?>
    </ul>
  </div>

  <div class="px-2 md:hidden">
    <open-button target="hotel description" class="font-bold text-green-900">Learn more</open-button>
    <modal-container name="hotel description" class="overflow-y-auto p-4">
      <h1 class="mr-8 font-semibold text-neutral-800">
        <?= $name ?>
      </h1>
      <address class="mr-8 text-sm leading-none"><?= $address ?></address>
      <p class="mt-4 text-sm text-gray-800"><?= $description ?></p>
    </modal-container>
  </div>
</section>
<toast-container name="not authenticated toast">
test
</toast-container>
