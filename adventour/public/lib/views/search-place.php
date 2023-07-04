<?php

use Illuminate\Database\Capsule\Manager as DB;

$place = DB::table('Places')
  ->select([
    DB::raw("DATE_FORMAT(open_time, '%l%p') AS open_time"),
    DB::raw("DATE_FORMAT(close_time, '%l%p') AS close_time")
  ])->where('place_id', $id)
  ->first();
?>
<div class="grid grid-cols-1 overflow-hidden rounded-lg border border-gray-400 bg-white sm:grid-cols-[300px_1fr] xl:grid-cols-[300px_1fr_240px]">
  <div class="aspect-h-2 aspect-w-4 w-full sm:aspect-h-3 sm:row-span-2 xl:row-span-1">
    <div>
      <img src="<?= $image ?>" alt="Image of <?= $title ?>" class="h-full w-full object-cover" />
      <like-button id="<?= $id ?>" type="place" class="absolute right-2 top-2"></like-button>
    </div>
  </div>
  <div class="mt-2 flex flex-col px-2">
    <div class="flex items-center gap-2">
      <div>
        <h2 class="flex items-center gap-2">
          <b-icon-building-fill class="h-[14px] w-[14px] shrink-0 text-green-900 md:h-[18px] md:w-[18px]"></b-icon-building-fill>
          <span class="text-sm font-semibold leading-none md:text-lg md:leading-none">
            <?= $title ?>
          </span>
        </h2>
        <address class="mt-1 text-xs not-italic leading-none text-gray-600 md:text-base md:leading-none">
          <?= $subtitle ?>
        </address>
      </div>
      <div class="ml-auto grid h-8 w-8 shrink-0 place-items-center self-start rounded-lg bg-green-900 xl:hidden">
        <span class="font-semibold text-white">0.0</span>
      </div>
    </div>
    <div class="sr-only grid flex-1 place-items-center xl:not-sr-only">
      <div class="relative h-32 overflow-hidden">
        <div class="bg-overflow absolute inset-0"></div>
        <p class="text-xs text-gray-600">
          <?= $description ?>
        </p>
      </div>
    </div>
  </div>
  <div class="my-2 flex flex-col justify-end px-2 xl:justify-between">
    <div class="hidden items-start justify-end gap-2 xl:flex">
      <div class="flex flex-col items-end gap-1 self-end">
        <div class="text-sm leading-none text-gray-700">Very good</div>
        <div class="text-xs leading-none text-gray-600">12 reviews</div>
      </div>
      <div class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-green-900">
        <span class="font-semibold text-white">0.0</span>
      </div>
    </div>
    <div class="mt-4">
      <div class="text-xs font-bold leading-none">Open</div>
      <div class="ml-8 mt-1 flex items-start gap-2">
        <?php if (isset($place->open_time) && isset($place->close_time)) : ?>
          <span class="text-2xl leading-none text-green-900"><?= $place->open_time ?> - <?= $place->close_time ?></span>
        <?php else : ?>
          <span class="text-2xl leading-none text-green-900">Always open</span>
        <?php endif; ?>
      </div>
      <a href="<?= $link ?>" class="mt-2 grid h-9 place-items-center rounded-lg bg-green-900">
        <span class="text-xs font-semibold leading-none text-white">
          Learn more
        </span>
      </a>
    </div>
  </div>
</div>
