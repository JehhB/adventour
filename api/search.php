<?php

echo json_encode(array(
  'search' => $_GET['q'],
  `filter` => $_GET['filter'],
  'data' => array(
    array('name' => 'Test 1', 'address' => 'Tuguegarao, Cagayan', 'image' => 'https://via.placeholder.com/72/red', 'link' => '#'),
    array('name' => 'Test 2', 'address' => 'Tuguegarao, Cagayan', 'image' => 'https://via.placeholder.com/72/blue', 'link' => '#'),
    array('name' => 'Test 3', 'address' => 'Tuguegarao, Cagayan', 'image' => 'https://via.placeholder.com/72/green', 'link' => '#'),
    array('name' => 'Test 4', 'address' => 'Tuguegarao, Cagayan', 'image' => 'https://via.placeholder.com/72/blue', 'link' => '#'),
  )
));
