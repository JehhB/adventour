<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/lib/index.php';
include $_SERVER['DOCUMENT_ROOT'] . '/lib/search.php';
include $_SERVER['DOCUMENT_ROOT'] . '/lib/search-page.php';
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

        <div class="mt-6 flex items-start gap-6">
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
            <div class="mb-4 hidden space-y-1 lg:block">
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
            <div class="mb-2 inline-block w-full px-2 sm:mb-4 sm:px-0">
              <?php 
              foreach($results as $result) { 
                insert(match($result->type) {
                  'hotel' => 'search-hotel',
                  'event' => 'search-event',
                  'place' => 'search-place',
                }, $result, true);
              }
              ?>
            </div>

            <?php if (gt($pages, 1)) : ?>
            <div class="flex w-full items-center justify-center gap-1">
              <?php if ($page === 1) : ?>
              <div
                class="grid h-6 w-6 place-items-center text-center font-medium leading-6 text-gray-400"
              >
                <b-icon-chevron-left></b-icon-chevron-left>
              </div>
              <?php else : ?>
              <a
                href="<?= url('/search.php', ['page' => $page - 1], $carryovers) ?>"
                class="grid h-6 w-6 place-items-center text-center font-medium leading-6 text-green-900"
              >
                <span class="sr-only">Previous result page</span>
                <b-icon-chevron-left></b-icon-chevron-left>
              </a>
              <?php endif; ?>

              <?php if ($min_page !== 1) :  ?>
              <a
                href="<?= url('/search.php', ['page' => 1], $carryovers) ?>"
                class="mr-3 w-6 rounded border border-gray-300 bg-gray-100 text-center font-medium leading-6 text-gray-400"
              >
                <span class="sr-only">Goto result page</span> 1
              </a>
              <?php endif; ?>

              <?php for ($i = $min_page; $i <= $max_page; ++$i) : ?>
              <?php if ($i === $page) : ?>
              <div
                class="w-6 rounded border border-green-900 bg-[#C0D1A9] text-center font-medium leading-6 text-green-900"
              >
                <?= $i ?>
              </div>
              <?php else : ?>
              <a
                href="<?= url('/search.php', ['page' => $i], $carryovers) ?>"
                class="w-6 rounded border border-gray-300 bg-gray-100 text-center font-medium leading-6 text-gray-400"
              >
                <span class="sr-only">Goto result page</span>
                <?= $i ?>
              </a>
              <?php endif; ?>
              <?php endfor; ?>

              <?php if ($max_page !== $pages) :  ?>
              <a
                href="<?= url('/search.php', ['page' => $pages], $carryovers) ?>"
                class="ml-3 w-6 rounded border border-gray-300 bg-gray-100 text-center font-medium leading-6 text-gray-400"
              >
                <span class="sr-only">Goto result page</span>
                <?= $pages ?>
              </a>
              <?php endif; ?>

              <?php if ($page === $pages) : ?>
              <div
                class="grid h-6 w-6 place-items-center text-center font-medium leading-6 text-gray-400"
              >
                <b-icon-chevron-right></b-icon-chevron-right>
              </div>
              <?php else : ?>
              <a
                href="<?= url('/search.php', ['page' => $page + 1], $carryovers) ?>"
                class="grid h-6 w-6 place-items-center text-center font-medium leading-6 text-green-900"
              >
                <span class="sr-only">Next result page</span>
                <b-icon-chevron-right></b-icon-chevron-right>
              </a>
              <?php endif; ?>
            </div>
            <?php endif; ?>
          </main>
        </div>
      </div>
      <modal-container name="sort" class="!max-w-xs">
        <?php insert('search-sort'); ?>
      </modal-container>
      <modal-container name="filter" class="!max-w-xs">
        <?php insert('search-filter'); ?>
      </modal-container>
    </div>
  </body>
</html>
