<?php
include $_SERVER['DOCUMENT_ROOT'] . "/lib/index.php";
safe_start_session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $errors = validate($_POST, [
    'email' => [\vld\is_not_empty(), \vld\is_email()],
    'password' => [\vld\is_not_empty()],
  ]);

  if ($errors) {
    $_SESSION['error'] = $errors;
    header('Location: /login.php');
    exit();
  }

  $error = auth($_POST['email'], $_POST['password']);

  if ($error) {
    $_SESSION['error'] = $error;
    header('Location: /login.php');
    exit();
  }

  if (isset($_POST['referer'])) {
    header("Location: {$_POST['referer']}");
  } else {
    header('Location: /');
  }
  exit();
}
