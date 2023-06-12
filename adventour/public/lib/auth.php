<?php
include $_SERVER['DOCUMENT_ROOT'] . "/lib/index.php";

/**
 * Register a new user
 *
 * @param string $email     New unique email to register
 * @param string $password  Password for the new user
 */
function register($email, $password)
{
  $sql = <<<SQL
INSERT INTO Users (email, password_hash)
VALUES (:email, :password_hash)
SQL;
  execute($sql, [
    ':email' => $email,
    ':password_hash' => password_hash($password, PASSWORD_DEFAULT)
  ]);

  safe_start_session();
  $_SESSION['user'] = intval(getDB()->lastInsertId());
}

/**
 * Authenticate user
 *
 * @param string $email     New unique email to register
 * @param string $password  Password for the new user
 *
 * @param array|false return false if authenticated successfully, otherwise return error
 */
function auth($email, $password)
{
  $sql = "SELECT user_id, password_hash FROM Users WHERE email = :email";
  $stmt = execute($sql, [':email' => $email]);

  $user = $stmt->fetch();
  if (!$user) {
    return ['email' => "Email is not linked to an account"];
  }

  if (!password_verify($password, $user['password_hash'])) {
    return ['password' => "Incorrect password"];
  }
  
  safe_start_session();
  $_SESSION['user'] = $user['user_id'];

  return false;
}

/**
 * check if currently authenticated
 *
 * @param int|false return id of authenticated, otherwise return false
 */
function isAuth() {
  safe_start_session();
  return isset($_SESSION['user']) ? $_SESSION['user'] : false;
}
