<?php
include $_SERVER['DOCUMENT_ROOT'] . "/lib/index.php";
protect_route();

unset($_SESSION['user']);

header('Location: /');
exit();
