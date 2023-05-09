<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';
global $conn;

$sql = <<<SQL
SELECT 
  MIN(Hotels.hotel_id) AS hotel_id,
  MIN(hotel_image_id) AS image_id,
  MIN(name) AS name, 
  MIN(address) AS address,
  MIN(description) as description
FROM Hotels LEFT JOIN HotelImages
ON HotelImages.hotel_id = Hotels.hotel_id
WHERE caption != ''
SQL;

if (isset($_GET['q']) && !empty($_GET['q'])) {
  $sql .= " AND metaphone LIKE :q";
}
$sql .= <<<SQL

GROUP BY Hotels.hotel_id
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
        'link' => "/hotels.php?hotel_id={$result['hotel_id']}",
        'image' => "/assets/hotelImage.php?hotel_image_id={$result['image_id']}",
        'alt' => "Image of {$result['name']}",
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
