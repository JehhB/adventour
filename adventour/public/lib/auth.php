<?php
include $_SERVER['DOCUMENT_ROOT'] . "/lib/index.php";

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

  return false;
}
