<?php
include $_SERVER['DOCUMENT_ROOT'] . "/lib/index.php";
protect_route();

unset($_SESSION['user']);
unset($_SESSION['account_type']);

header('Location: /');
exit();
