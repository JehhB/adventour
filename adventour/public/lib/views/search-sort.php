<?php
global $carryovers, $sort_categories, $sort_by;
?>
<nav class="rounded-lg bg-white p-3 pt-4">
  <div class="mb-3 font-medium leading-none text-gray-400">Sort by:</div>

  <div>
    <?php foreach ($sort_categories as $sort) : ?>
    <a
      href="<?= url('/search.php', ['sort_by' => $sort], $carryovers) ?>"
      class="mt-2 flex gap-2"
    >
      <?php if ($sort === $sort_by) : ?>
      <div class="flex rounded border border-green-900 bg-[#C0D1A9]">
        <b-icon-check
          class="inline h-4 w-4 text-center text-green-900"
        ></b-icon-check>
      </div>
      <?php else : ?>
      <div class="h-4 w-4 rounded border border-gray-300 bg-gray-100"></div>
      <?php endif; ?>

      <span class="capitalize leading-none">
        <?= $sort ?>
      </span>
    </a>
    <?php endforeach; ?>
  </div>
</nav>
