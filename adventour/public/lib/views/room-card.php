<?php
global $has_offers;

use Illuminate\Database\Capsule\Manager as DB;

$offering_query = DB::table('Offerings')
  ->where('room_id', $room_id)
  ->select(['offering_id', 'room_id', 'max_person', 'stays', 'price', 'original_price', 'meal_plan']);

if (isset($_GET['checkin']) and isset($_GET['checkout'])) {
  $days = ($_GET['checkout'] - $_GET['checkin']) / MS_IN_DAY;
  $offering_query->where('stays', '>=', $days);
}

$persons = ($_GET['n_adult'] ?? 1) + ($_GET['n_child'] ?? 0);
$offering_query->where('max_person', '>=', $persons);

if ($offering_query->count() < 1) return;

$has_offers = true;
$offerings = $offering_query->get();

$image = DB::table('RoomImages')
  ->where('room_id', $room_id)
  ->value('image');
$highlights = DB::table('Highlights')->select('highlight')->join(
    'RoomHighlights',
    'RoomHighlights.highlight_id',
    'Highlights.highlight_id'
  )->where(
    'room_id',
    $room_id
  )
  ->get();

$carryovers = ['checkin', 'checkout', 'n_adult', 'n_room', 'n_child'];
?>
<div class="grid gap-2 overflow-hidden rounded-lg border border-gray-400 sm:grid-cols-2">
  <div class="aspect-h-12 aspect-w-16">
    <div>
      <?php if (!isset($image)) : ?>
        <img src="/assets/images/no_image.svg" alt="No images for <?= $room_type ?>" class="h-full w-full object-cover" />
      <?php else : ?>
        <img src="/storage/room/<?= $image ?>" alt="Image for <?= $room_type ?>" class="h-full w-full object-cover" />
      <?php endif; ?>
    </div>
  </div>
  <div class="flex flex-col p-2">
    <h3 class="font-semibold sm:text-lg"><?= $room_type ?></h3>
    <ul class="flex w-full list-none flex-wrap gap-x-8 gap-y-3 border-b border-solid border-gray-500 py-2 text-sm leading-none text-gray-800 sm:gap-x-4 sm:gap-y-2">
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
      <?php foreach ($offerings as $offering) : ?>
      <offering-option
        :offering-id="<?= $offering->offering_id ?>"
        :max-person="<?= $offering->max_person ?>"
        :stays="<?= $offering->stays ?>"
        meal-plan="<?= $offering->meal_plan ?>"
        :price="<?= $offering->price ?>"
        :original-price="<?= $offering->original_price ?>"
        link="<?= url('/checkout.php', ['offering_id' => $offering->offering_id], $carryovers) ?>"
      ></offering-option>
      <?php endforeach; ?>
    </offering-select>
  </div>
</div>
