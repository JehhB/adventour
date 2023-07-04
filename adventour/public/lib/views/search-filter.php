<?php
global $event_filter, $active_filter, $price_range, $carryovers, $rating, $event_start;
$prices = [
  '&lt; &#8369;2000',
  '&#8369;2000 - &#8369;2999',
  '&#8369;3000 - &#8369;3999',
  '&gt; &#8369;4000',
];

$ratings = [
  'No rating',
  '1 Star',
  '2 Stars',
  '3 Stars',
  '4 Stars',
  '5 Stars',
];
?>
<nav class="rounded-lg border-gray-400 bg-white p-2 pt-4 lg:border lg:pt-2">
  <div class="mb-2 font-medium leading-none text-gray-400">Filter by:</div>

  <div class="mb-4 border-t border-gray-400">
    <span class="font-medium leading-none text-gray-800">Type</span>
    <a
      href="<?= url('/search.php', ['filter' => 'all'], $carryovers) ?>"
      class="mt-2 flex items-center gap-2"
    >
      <?php if ($active_filter === 'all') : ?>
      <div class="flex rounded border border-green-900 bg-[#C0D1A9]">
        <b-icon-check
          class="inline h-4 w-4 text-center text-green-900"
        ></b-icon-check>
      </div>
      <?php else : ?>
      <div class="h-4 w-4 rounded border border-gray-300 bg-gray-100"></div>
      <?php endif; ?>
      <span class="capitalize leading-none">All</span>
    </a>

    <?php 
    foreach (['hotels', 'events', 'places'] as $type) : 
      if ($type === $active_filter) :
    ?>
    <a
      href="<?= url('/search.php', ['filter' => 'all'], $carryovers) ?>"
      class="mt-2 flex items-center gap-2"
    >
      <div class="flex rounded border border-green-900 bg-[#C0D1A9]">
        <b-icon-check
          class="inline h-4 w-4 text-center text-green-900"
        ></b-icon-check>
      </div>
      <span class="capitalize leading-none">
        <?= $type ?>
      </span>
    </a>
    <?php else : ?>
    <a
      href="<?= url('/search.php', ['filter' => $type], $carryovers) ?>"
      class="mt-2 flex items-center gap-2"
    >
      <div class="h-4 w-4 rounded border border-gray-300 bg-gray-100"></div>
      <span class="capitalize leading-none">
        <?= $type ?>
      </span>
    </a>
    <?php 
      endif;
    endforeach; 
    ?>
  </div>

  <div class="mb-4 border-t border-gray-400">
    <span class="font-medium leading-none text-gray-800">Price</span>
    <?php 
    for ($i = 0; $i < count($prices); $i++) :
      if ($i === $price_range) :
    ?>
    <a
      href="<?= url('/search.php', ['price' => null], $carryovers) ?>"
      class="mt-2 flex items-center gap-2"
    >
      <div class="flex rounded border border-green-900 bg-[#C0D1A9]">
        <b-icon-check
          class="inline h-4 w-4 text-center text-green-900"
        ></b-icon-check>
      </div>
      <span class="capitalize leading-none">
        <?= $prices[$i] ?>
      </span>
    </a>
    <?php else : ?>
    <a
      href="<?= url('/search.php', ['price' => $i], $carryovers) ?>"
      class="mt-2 flex items-center gap-2"
    >
      <div class="h-4 w-4 rounded border border-gray-300 bg-gray-100"></div>
      <span class="capitalize leading-none">
        <?= $prices[$i] ?>
      </span>
    </a>
    <?php 
      endif;
    endfor; 
    ?>
  </div>

  <div class="mb-4 border-t border-gray-400">
    <span class="font-medium leading-none text-gray-800">Rating</span>
    <?php 
    for ($i = count($ratings) - 1; gte($i, 0); $i--) :
      if ($i === $rating) :
    ?>
    <a
      href="<?= url('/search.php', ['rating' => null], $carryovers) ?>"
      class="mt-2 flex items-center gap-2"
    >
      <div class="flex rounded border border-green-900 bg-[#C0D1A9]">
        <b-icon-check
          class="inline h-4 w-4 text-center text-green-900"
        ></b-icon-check>
      </div>
      <span class="capitalize leading-none">
        <?= $ratings[$i] ?>
      </span>
    </a>
    <?php else : ?>
    <a
      href="<?= url('/search.php', ['rating' => $i], $carryovers) ?>"
      class="mt-2 flex items-center gap-2"
    >
      <div class="h-4 w-4 rounded border border-gray-300 bg-gray-100"></div>
      <span class="capitalize leading-none">
        <?= $ratings[$i] ?>
      </span>
    </a>
    <?php 
      endif;
    endfor; 
    ?>
  </div>

  <div class="mb-4 border-t border-gray-400">
    <span class="font-medium leading-none text-gray-800">Events</span>
    <?php 
    foreach ($event_filter as $type) : 
      if ($type === $event_start) :
    ?>
    <a
      href="<?= url('/search.php', ['event_start' => null], $carryovers) ?>"
      class="mt-2 flex items-center gap-2"
    >
      <div class="flex rounded border border-green-900 bg-[#C0D1A9]">
        <b-icon-check
          class="inline h-4 w-4 text-center text-green-900"
        ></b-icon-check>
      </div>
      <span class="capitalize leading-none">
        <?= $type ?>
      </span>
    </a>
    <?php else : ?>
    <a
      href="<?= url('/search.php', ['event_start' => $type], $carryovers) ?>"
      class="mt-2 flex items-center gap-2"
    >
      <div class="h-4 w-4 rounded border border-gray-300 bg-gray-100"></div>
      <span class="capitalize leading-none">
        <?= $type ?>
      </span>
    </a>
    <?php 
      endif;
    endforeach; 
    ?>
  </div>

  <a
    href="<?= url('/search.php', ['filter' => null, 'rating' => null, 'price' => null], $carryovers) ?>"
    class="block rounded-lg bg-green-900 py-1 text-center font-medium text-white"
  >
    Clear filters
  </a>
</nav>
