<?php
include $_SERVER['DOCUMENT_ROOT'] . "/lib/index.php";
safe_start_session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $errors = validate($_POST, [
    'email' => [\vld\is_not_empty(), \vld\is_email(), \vld\is_unique('Users', 'email', "Email is already in use")],
    'username' => [\vld\is_not_empty(), \vld\max_length()],
    'password' => [\vld\is_not_empty(), \vld\is_long_enough()],
    'confirm' => [\vld\is_not_empty(), \vld\is_long_enough(), \vld\is_equal($_POST['password'], "Password does not match")],
  ]);

  if ($errors) {
    $_SESSION['error'] = $errors;

    header('Location: /signin.php');
    exit();
  }

  register($_POST['email'], $_POST['password'], $_POST['username']);

  if (isset($_POST['referer'])) {
    header("Location: {$_POST['referer']}");
  } else {
    header('Location: /');
  }
  exit();
}
