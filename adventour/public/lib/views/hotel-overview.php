<?php
$sql = <<<SQL
SELECT feature
FROM Features
JOIN HotelFeatures ON HotelFeatures.feature_id = Features.feature_id
WHERE hotel_id = ?
SQL;
$stmt = execute($sql, [$hotel_id]);
?>
<section class="mt-3 space-y-2">
  <div class="flex items-center gap-2 px-2 sm:px-0">
    <h1 class="font-semibold text-neutral-800"><?= $name ?></h1>
    <div class="ml-auto flex gap-2">
      <b-icon-heart-fill class="stroke-2 text-zinc-600"></b-icon-heart-fill>
      <b-icon-share-fill class="stroke-2 text-zinc-600"></b-icon-share-fill>
    </div>
  </div>
  <gallery-container>
    <?php foreach ($images as $image) : ?>
    <gallery-item
      src="<?= $image['src'] ?>"
      alt="<?= $image['alt'] ?>"
    ></gallery-item>
    <?php endforeach; ?>
  </gallery-container>

  <div class="px-2">
    <h3 class="text-base font-semibold leading-none text-gray-800">
      Facilities
    </h3>
    <ul class="mt-4 flex list-none flex-wrap gap-x-8 gap-y-3 text-gray-700">
      <?php while ($facility = $stmt->fetch()) : ?>
      <li class="list-check text-base leading-none">
        <?= e($facility['feature']) ?>
      </li>
      <?php endwhile; ?>
    </ul>
  </div>

  <div class="px-2">
    <toggle-container>
      <open-button class="font-bold text-green-900">Learn more</open-button>
      <template v-slot:toggled>
        <modal-container> test </modal-container>
      </template>
    </toggle-container>
  </div>
</section>
