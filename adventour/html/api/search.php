<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';
global $conn;

$sql = <<<SQL
SELECT
    Hotels.hotel_id hotel_id,
    hotel_image_id AS image_id,
    caption,
    name,
    address,
    description
FROM
    Hotels
LEFT JOIN HotelImages ON HotelImages.hotel_id = Hotels.hotel_id
WHERE hotel_image_id = (
    SELECT MIN(hotel_image_id)
    FROM HotelImages
    WHERE caption != '' AND HotelImages.hotel_id = Hotels.hotel_id
  )
SQL;

if (isset($_GET['q']) && !empty($_GET['q'])) {
  $sql .= " AND metaphone LIKE :q";
}
$sql .= <<<SQL
  LIMIT 8
SQL;

$stmt = $conn->prepare($sql);
if (isset($_GET['q']) && !empty($_GET['q'])) {
  $metaphone = metaphone($_GET['q']);
  $param = "%$metaphone%";
  $stmt->bindParam(':q', $param);
}
$stmt->execute();

$results = $stmt->fetchAll();
?>


<ul class="search-suggestion__list">
  <?php 
  foreach ($results as $result) {
      insert('search-summary', [
        'isLoading' => false,
        'link' => "/hotel.php?hotel_id={$result['hotel_id']}",
        'image' => "/assets/images/hotelImage.php?hotel_image_id={$result['image_id']}",
        'alt' => $result['caption'],
        'name' => $result['name'],
        'address' => $result['address'],
      ]); 
    } 
  ?>
</ul>

<?php if (count($results) === 0): ?>
  <p class="search-suggestion__message">
    No match for '<?= e($_GET['q']) ?>'
  </p>
<?php elseif (count($results) === 8): ?>
  <a class="search-suggestion__message" href="/search.php?q=<?= urlencode($_GET['q']) ?>">
    Show more...
  </a>
<?php endif ?>
