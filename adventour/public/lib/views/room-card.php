<?php
use Illuminate\Database\Capsule\Manager as DB;

$image = DB::table('RoomImages')
  ->where('room_id', $room_id) ->value('image'); $highlights =
DB::table('Highlights') ->select('highlight') ->join( 'RoomHighlights',
'RoomHighlights.highlight_id', 'Highlights.highlight_id' )->where('room_id',
$room_id) ->get(); ?>
<div
  class="grid gap-2 overflow-hidden rounded-lg border border-gray-400 sm:grid-cols-2"
>
  <div class="aspect-h-12 aspect-w-16">
    <div>
      <?php if (!isset($image)) : ?>
      <img
        src="/assets/images/no_image.svg"
        alt="No images for <?= $room_type ?>"
        class="h-full w-full object-cover"
      />
      <?php else : ?>
      <img
        src="/storage/room/<?= $image ?>"
        alt="Image for <?= $room_type ?>"
        class="h-full w-full object-cover"
      />
      <?php endif; ?>
    </div>
  </div>
  <div class="flex flex-col p-2">
    <h3 class="font-semibold sm:text-lg"><?= $room_type ?></h3>
    <ul
      class="flex w-full list-none flex-wrap gap-x-8 gap-y-3 border-b border-solid border-gray-500 py-2 text-sm leading-none text-gray-800 sm:gap-x-4 sm:gap-y-2"
    >
      <?php if ($room_size != 0) : ?>
      <li class="list-size">
        <?= $room_size ?>
        m<sup>2</sup>
      </li>
      <?php endif; ?>
      <?php foreach ($highlights as $highlight) :  ?>
      <li class="list-check"><?= $highlight->highlight ?></li>
      <?php endforeach; ?>
    </ul>
    <div class="h-0 flex-1"></div>
    <offering-select class="mt-2">
      <offering-option :offering-id="1" :max-person="1" :stays="1" meal-plan="none" :price="5000" :original-price="5000"></offering-option>
      <offering-option :offering-id="3" :max-person="2" :stays="1" meal-plan="breakfast" :price="5000" :original-price="5000"></offering-option>
    </offering-select>
  </div>
</div>
