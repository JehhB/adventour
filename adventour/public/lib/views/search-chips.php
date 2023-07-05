<?php
global $active_filter, $filters, $carryovers, $price_range, $rating, $event_start, $place_open;
$prices_short = [
  '&lt;&#8369;2K',
  '&#8369;2K-3K',
  '&#8369;3K-4K',
  '&gt;&#8369;4K',
]
?>
<div class="flex overflow-x-scroll border-y border-gray-300 py-2 lg:hidden">
  <?php if ($active_filter === 'all') : ?>
  <a
    href="#"
    class="ml-2 flex shrink-0 gap-1 rounded-full border border-green-900 bg-[#C0D1A9] px-3 py-1 text-sm font-medium leading-none text-green-900"
  >
    <span>All</span>
  </a>
  <?php else : ?>
  <a
    href="<?= url('/search.php', ['filter' => 'all'] , $carryovers) ?>"
    class="ml-2 flex shrink-0 gap-1 rounded-full border border-green-900 bg-[#C0D1A9] px-3 py-1 text-sm font-medium capitalize leading-none text-green-900"
  >
    <span><?= $active_filter ?></span>
    <b-icon-x-lg></b-icon-x-lg>
  </a>
  <?php endif; ?>

  <?php if ($price_range !== null) : ?>
  <a
    href="<?= url('/search.php', ['price' => null] , $carryovers) ?>"
    class="ml-2 flex shrink-0 gap-1 rounded-full border border-green-900 bg-[#C0D1A9] px-3 py-1 text-sm font-medium capitalize leading-none text-green-900"
  >
    <span><?= $prices_short[$price_range] ?></span>
    <b-icon-x-lg></b-icon-x-lg>
  </a>
  <?php endif; ?>

  <?php if ($rating !== null) : ?>
  <a
    href="<?= url('/search.php', ['rating' => null] , $carryovers) ?>"
    class="ml-2 flex shrink-0 gap-1 rounded-full border border-green-900 bg-[#C0D1A9] px-3 py-1 text-sm font-medium capitalize leading-none text-green-900"
  >
    <span><?= $rating ?></span>
    <b-icon-star-fill></b-icon-star-fill>
    <b-icon-x-lg></b-icon-x-lg>
  </a>
  <?php endif; ?>

  <?php if ($event_start !== null) : ?>
  <a
    href="<?= url('/search.php', ['event_start' => null] , $carryovers) ?>"
    class="ml-2 flex shrink-0 gap-1 rounded-full border border-green-900 bg-[#C0D1A9] px-3 py-1 text-sm font-medium capitalize leading-none text-green-900"
  >
    <span><?= $event_start ?></span>
    <b-icon-x-lg></b-icon-x-lg>
  </a>
  <?php endif ?>

  <?php if ($place_open !== null) : ?>
  <a
    href="<?= url('/search.php', ['place_open' => null] , $carryovers) ?>"
    class="ml-2 flex shrink-0 gap-1 rounded-full border border-green-900 bg-[#C0D1A9] px-3 py-1 text-sm font-medium capitalize leading-none text-green-900"
  >
    <span><?= $place_open ?></span>
    <b-icon-x-lg></b-icon-x-lg>
  </a>
  <?php endif ?>

  <?php if ($active_filter !== 'all' || $price_range !== null || $rating !== null || $place_open !== null || $event_start !== null): ?>
  <a
    href="<?= url('/search.php', ['filter' => null, 'rating' => null, 'price' => null], $carryovers) ?>"
    class="ml-2 flex shrink-0 gap-1 rounded-full border border-gray-300 bg-gray-100 px-3 py-1 text-sm font-medium capitalize leading-none text-gray-400"
  >
    <span>clear filter</span>
    <b-icon-x-lg></b-icon-x-lg>
  </a>
  <?php endif; ?>

  <?php foreach ($filters as $filter ) : ?>
  <a
    href="<?= url('/search.php', ['filter' => $filter] , $carryovers) ?>"
    class="ml-2 flex shrink-0 gap-1 rounded-full border border-gray-300 bg-gray-100 px-3 py-1 text-sm font-medium capitalize leading-none text-gray-400"
  >
    <span><?= $filter ?></span>
  </a>
  <?php endforeach; ?>
</div>
