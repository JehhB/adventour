<?php

/** @var \PDO Connection to database */
$conn = call_user_func(function () {
  $host = isset($_ENV['MYSQL_HOST']) ? $_ENV['MYSQL_HOST'] : 'localhost';
  $database = isset($_ENV['MYSQL_DATABASE']) ? $_ENV['MYSQL_DATABASE'] : 'database';
  $username = isset($_ENV['MYSQL_USER']) ? $_ENV['MYSQL_USER'] : 'root';
  $password = isset($_ENV['MYSQL_PASSWORD']) ? $_ENV['MYSQL_PASSWORD'] : '';

  try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
  } catch (PDOException $e) {
    exit("Connection Failed: {$e->getMessage()}");
  }

  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

  return $conn;
});
