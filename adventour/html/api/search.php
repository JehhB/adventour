<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';

$sql = <<<SQL
SELECT
    Hotels.hotel_id hotel_id,
    hotel_image_id AS image_id,
    caption,
    name,
    address
FROM Hotels
LEFT JOIN HotelImages ON HotelImages.hotel_id = Hotels.hotel_id
WHERE 
  hotel_image_id = (
    SELECT MIN(hotel_image_id)
    FROM HotelImages
    WHERE caption != '' AND HotelImages.hotel_id = Hotels.hotel_id
  ) AND 
  metaphone LIKE :q
LIMIT 8
SQL;
$metaphone = metaphone($_GET['q'] ?? '');
$stmt = execute($sql, [':q' => "%$metaphone%"]);
?>
<ul class="search-suggestion__list">
  <?php while ($result = $stmt->fetch()) : ?>
    <li>
      <?php insert('search-summary', [
        'link' => "/hotel.php?hotel_id={$result['hotel_id']}",
        'image' => "/assets/images/hotelImage.php?hotel_image_id={$result['image_id']}",
        'alt' => $result['caption'],
        'name' => $result['name'],
        'address' => $result['address'],
      ]);
      ?>
    </li>
  <?php endwhile; ?>
</ul>

<?php if ($stmt->rowCount() === 0) : ?>
  <p class="search-suggestion__message">
    No match for '<?= e($_GET['q']) ?>'
  </p>
<?php elseif ($stmt->rowCount() === 8) : ?>
  <a class="search-suggestion__message" href="/search.php?q=<?= urlencode($_GET['q']) ?>">
    Show more...
  </a>
<?php endif ?>
