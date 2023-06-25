<?php
$sql = <<<SQL
SELECT image
FROM RoomImages
WHERE room_id = ?
SQL;
$images = execute($sql, [$room_id])->fetchAll();

$sql = <<<SQL
SELECT highlight 
FROM Highlights
JOIN RoomHighlights ON RoomHighlights.highlight_id = Highlights.highlight_id
WHERE room_id = ?
SQL;

$highlights = execute($sql, [$room_id]);
?>
<div class="overflow-hidden rounded-lg border border-gray-400">
  <div class="aspect-h-12 aspect-w-16">
    <?php if (count($images) === 0) : ?>
    <img
      src="/assets/images/no_image.svg"
      alt="No images for <?= $room_type ?>"
    />
    <?php else : ?>
    <img
      src="/storage/room/<?= $images[0]['image'] ?>"
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
      <?php while ($row = $highlights->fetch()) : ?>
      <li class="list-check">
        <?= $row['highlight'] ?>
      </li>
      <?php endwhile; ?>
    </ul>
  </div>
</div>
