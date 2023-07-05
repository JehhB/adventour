<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Query\Builder;

$event = DB::table('Events')
  ->select([
    DB::raw("DATE_FORMAT(start_date, '%m/%d') AS start_date"),
    DB::raw("DATE_FORMAT(end_date, '%m/%d') AS end_date")
  ])->addSelect('attendees')
  ->leftJoinSub(function (Builder $query) {
    $query->selectRaw('event_id, COUNT(*) as attendees')
      ->from('EventAttend')
      ->groupBy('event_id');
  }, 'V', 'V.event_id', '=', 'Events.event_id')
  ->where('Events.event_id', $id)
  ->first();
?>
<div class="grid grid-cols-1 overflow-hidden rounded-lg border border-gray-400 bg-white sm:grid-cols-[300px_1fr] xl:grid-cols-[300px_1fr_240px]">
  <div class="aspect-h-2 aspect-w-4 w-full sm:aspect-h-3 sm:row-span-2 xl:row-span-1">
    <div>
      <img src="<?= $image ?>" alt="Image of <?= $title ?>" class="h-full w-full object-cover" />
      <like-button id="<?= $id ?>" type="event" class="absolute right-2 top-2"></like-button>
    </div>
  </div>
  <div class="mt-2 flex flex-col px-2">
    <div class="flex items-center gap-2">
      <div>
        <h2 class="flex items-center gap-2">
          <b-icon-calendar-event-fill class="h-[14px] w-[14px] shrink-0 text-green-900 md:h-[18px] md:w-[18px]"></b-icon-calendar-event-fill>
          <span class="text-sm font-semibold leading-none md:text-lg md:leading-none">
            <?= $title ?>
          </span>
        </h2>
        <address class="mt-1 text-xs not-italic leading-none text-gray-600 md:text-base md:leading-none">
          <?= $subtitle ?>
        </address>
      </div>
      <div class="ml-auto grid h-8 w-8 shrink-0 place-items-center self-start rounded-lg bg-green-900 xl:hidden">
        <span class="font-semibold text-white">
          <b-icon-calendar-event-fill></b-icon-calendar-event-fill>
        </span>
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
        <div class="text-sm leading-none text-gray-700"><?= $event->attendees > 0 ? 'Very popular' : 'No attendees' ?></div>
        <div class="text-xs leading-none text-gray-600"><?= $event->attendees ?? 0 ?> going</div>
      </div>
      <div class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-green-900">
        <span class="font-semibold text-white">
          <b-icon-calendar-event-fill></b-icon-calendar-event-fill>
        </span>
      </div>
    </div>
    <div class="mt-4">
      <div class="text-xs font-bold leading-none">Event period</div>
      <div class="ml-8 mt-1 flex items-start gap-2">
        <span class="text-2xl leading-none text-green-900"><?= $event->start_date ?> - <?= $event->end_date ?></span>
      </div>
      <a href="<?= $link ?>" class="mt-2 grid h-9 place-items-center rounded-lg bg-green-900">
        <span class="text-xs font-semibold leading-none text-white">
          Go to event
        </span>
      </a>
    </div>
  </div>
</div>
