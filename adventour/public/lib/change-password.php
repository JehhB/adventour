<?php
include $_SERVER['DOCUMENT_ROOT'] . "/lib/index.php";
protect_route();
safe_start_session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $errors = validate($_POST, [
    'old' => [\vld\is_not_empty()],
    'password' => [\vld\is_not_empty(), \vld\is_long_enough()],
    'confirm' => [\vld\is_not_empty(), \vld\is_long_enough(), \vld\is_equal($_POST['password'], "Password does not match")],
  ]);

  if ($errors) {
    $_SESSION['error'] = $errors;
    header('Location: /change-password.php');
    exit();
  }

  $error = change_password($_POST['old'], $_POST['password']);

  if ($error) {
    $_SESSION['error'] = $error;
    header('Location: /change-password.php');
    exit();
  }

  if (isset($_POST['referer'])) {
    header("Location: {$_POST['referer']}");
  } else {
    header('Location: /');
  }
  exit();
}
