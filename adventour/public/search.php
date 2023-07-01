<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';
safe_start_session();

$sort_categories = [
  'recommendation',
  'popularity',
  'price',
  'rating',
];
$sort_by = $sort_categories[0];
if (isset($_GET['sort_by']) and array_search($_GET['sort_by'], $sort_categories)) {
  $sort_by = $_GET['sort_by'];
}


$filters = ['hotels', 'events', 'places'];

$carryovers = ['filter', 'q', 'checkin', 'checkout', 'n_adult', 'n_child', 'n_room', 'price', 'rating', 'sort_by'];
$active_filter = '';

if (!isset($_GET['filter']) or array_search($_GET['filter'], $filters) === false) {
  $active_filter = 'all';
} else {
  $active_filter = $_GET['filter'];
  $index = array_search($_GET['filter'], $filters);
  unset($filters[$index]);
}

$rating = null;
if (isset($_GET['rating']) && $_GET['rating'] >= 0 && $_GET['rating'] <= 5) {
$rating = intval($_GET['rating']); } $price_range = null; if
(isset($_GET['price']) && $_GET['price'] >= 0 && $_GET['price'] < 4) {
$price_range = intval($_GET['price']); } ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
  </head>
  <body>
    <div id="app" v-cloak>
      <?php insert('header'); ?>
      <div class="container mx-auto">
        <div class="mt-2 px-2 sm:px-0">
          <stay-setting search></stay-setting>
        </div>

        <div class="my-1 flex w-full justify-around lg:hidden">
          <open-button
            target="sort"
            class="flex items-center gap-1 p-1 sm:gap-2"
          >
            <b-icon-sort-down
              class="h-3 w-3 text-green-900 sm:h-4 sm:w-4"
            ></b-icon-sort-down>
            <span
              class="text-sm font-semibold leading-none text-green-900 sm:text-base sm:leading-none"
            >
              Sort
            </span>
          </open-button>
          <open-button
            target="filter"
            class="flex items-center gap-1 p-1 sm:gap-2"
          >
            <b-icon-funnel-fill
              class="h-3 w-3 text-green-900 sm:h-4 sm:w-4"
            ></b-icon-funnel-fill>
            <span
              class="text-sm font-semibold leading-none text-green-900 sm:text-base sm:leading-none"
            >
              Filter
            </span>
          </open-button>
          <open-button
            target="map"
            class="flex items-center gap-1 p-1 sm:gap-2"
          >
            <b-icon-map-fill
              class="h-3 w-3 text-green-900 sm:h-4 sm:w-4"
            ></b-icon-map-fill>
            <span
              class="text-sm font-semibold leading-none text-green-900 sm:text-base sm:leading-none"
            >
              Map
            </span>
          </open-button>
        </div>
        <?php insert('search-chips'); ?>

        <div class="mt-6 flex gap-6">
          <aside class="hidden w-1/4 shrink-0 lg:block">
            <open-button
              target="map"
              class="aspect-h-1 aspect-w-2 mb-4 block w-full"
            >
              <div
                class="grid place-items-center overflow-hidden rounded-lg bg-cover bg-center bg-no-repeat"
                style="background: url('/assets/images/map.jpg')"
              >
                <div class="rounded-lg bg-green-900 p-3 font-medium text-white">
                  View in map
                </div>
              </div>
            </open-button>
            <?php insert('search-filter'); ?>
          </aside>

          <main class="w-0 flex-1">
            <div class="space-y-1">
              <?php if (!isset($_GET['q']) or $_GET['q'] === ''): ?>
              <h1 class="text-xl font-medium leading-none text-gray-900">
                Find your next destination
              </h1>
              <?php else : ?>
              <h1 class="text-xl font-medium leading-none text-gray-900">
                Results for "<?= $_GET['q'] ?>"
              </h1>
              <?php endif; ?>
              <open-button
                target="sort"
                class="flex items-center text-xs text-gray-600"
              >
                <b-icon-sort-down class="h-3 w-3"></b-icon-sort-down>
                <span class="ml-1 leading-none">
                  Sort by:
                  <?= $sort_by ?>
                </span>
              </open-button>
            </div>
          </main>
        </div>
      </div>
      <modal-container name="filter" class="!max-w-xs">
        <?php insert('search-filter'); ?>
      </modal-container>
    </div>
  </body>
</html>
