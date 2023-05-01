<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/../include.php';

sleep(1);
for ($i = 0; $i < 4; ++$i) {
  insert('search-summary', [
    'isLoading' => false,
    'link' => '#',
    'image' => 'https://via.placeholder.com/72',
    'name' => "{$_GET['q']} $i",
    'address' => $_GET['filter'],
  ]);
}
?>
