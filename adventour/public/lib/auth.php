<?php
include $_SERVER['DOCUMENT_ROOT'] . "/lib/index.php";

/**
 * A function to safely start session
 *
 * @return bool returns true if session is started
 */
function safe_start_session()
{
  static $started = false;

  if (!$started) {
    $started = true;
    session_start();
    return true;
  }

  return false;
}

/**
 * Register a new user
 *
 * @param string $email     New unique email to register
 * @param string $password  Password for the new user
 *
 * @return false|array  return false if there is succesfully registered, otherwise return cause of error
 */
function register($email, $password)
{
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return array("email" => 'Not a valid email');
  if (strlen($password) < 8)  return array("password" => 'Should be at least 8 characters');

  $sql = <<<SQL
SELECT user_id FROM Users WHERE email = :email
SQL;

  $stmt = execute($sql, array(':email' => $email));
  if ($stmt->rowCount() > 0) return array("email" => "Email is already in used");

  $sql = <<<SQL
INSERT INTO Users (email, password_hash)
VALUES (:email, :password_hash)
SQL;

  $stmt = execute($sql, [
    ':email' => $email,
    ':password_hash' => password_hash($password, PASSWORD_DEFAULT)
  ]);

  safe_start_session();
  $_SESSION['user'] = intval(getDB()->lastInsertId());

  return false;
}
