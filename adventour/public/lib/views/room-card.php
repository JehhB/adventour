<?php
use Illuminate\Database\Capsule\Manager as DB;

$image = DB::table('RoomImages')
  ->where('room_id', $room_id)
  ->value('image');

$highlights = DB::table('Highlights')
  ->select('highlight')
  ->join('RoomHighlights', 'RoomHighlights.highlight_id', 'Highlights.highlight_id')
  ->where('room_id', $room_id)
  ->get();
?>
<div class="overflow-hidden rounded-lg border border-gray-400">
  <div class="aspect-h-12 aspect-w-16">
    <?php if (!isset($image)) : ?>
    <img
      src="/assets/images/no_image.svg"
      alt="No images for <?= $room_type ?>"
    />
    <?php else : ?>
    <img
      src="/storage/room/<?= $image ?>"
      alt="Image for <?= $room_type ?>"
    />
    <?php endif; ?>
  </div>
  <div class="p-2">
    <h3 class="font-semibold sm:text-lg"><?= $room_type ?></h3>
    <ul
      class="flex w-full list-none flex-wrap gap-x-8 gap-y-3 border-b border-solid border-black py-2 text-sm leading-none text-gray-800 sm:text-base"
    >
      <?php if ($room_size != 0) : ?>
      <li class="list-size">
        <?= $room_size ?>
        m<sup>2</sup>
      </li>
      <?php endif; ?>
      <?php foreach ($highlights as $highlight) :  ?>
      <li class="list-check">
        <?= $highlight->highlight ?>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
