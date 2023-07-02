<?php

use Illuminate\Database\Capsule\Manager as DB;

$capsule = new DB();
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => $_ENV['MYSQL_HOST'] ?? 'localhost',
    'database' => $_ENV['MYSQL_DATABASE'] ?? 'database',
    'username' => $_ENV['MYSQL_USER'] ?? 'root',
    'password' => $_ENV['MYSQL_PASSWORD'] ?? '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
