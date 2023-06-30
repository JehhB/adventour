<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';
safe_start_session();

$filters = ['hotels', 'events', 'places'];

$carryovers = ['filter', 'q', 'checkin', 'checkout', 'n_adult', 'n_child', 'n_room', 'price', 'rating'];
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
  $rating = intval($_GET['rating']);
}

$price_range = null;
if (isset($_GET['price']) && $_GET['price'] >= 0 && $_GET['price'] < 4) {
  $price_range = intval($_GET['price']);
}
?>
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

        <aside class="hidden w-1/4 lg:block">
          <?php insert('search-filter'); ?>
        </aside>
      </div>
      <modal-container name="filter" class="!max-w-xs">
        <?php insert('search-filter'); ?>
      </modal-container>
    </div>
  </body>
</html>
