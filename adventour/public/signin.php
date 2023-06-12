<?php
include $_SERVER['DOCUMENT_ROOT'] . "/lib/index.php";
safe_start_session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $errors = validate($_POST, [
    'password' => \vld\is_defined(),
    'email' => \vld\is_defined(),
  ]);

  if ($errors) {
    $_SESSION['error'] = $error;

    header('Location: /signin.php');
    exit();
  }

  $error = register($_POST['email'], $_POST['password']);

  if ($error) {
    $_SESSION['error'] = $error;

    header('Location: /signin.php');
    exit();
  }

  header('Location: /');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
</head>

<body>
  <form method="POST">
    <input type="email" name="email">
    <input type="password" name="password">
    <input type="submit" value="Submit">
  </form>
</body>

</html>
