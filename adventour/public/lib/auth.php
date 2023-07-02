<?php
include $_SERVER['DOCUMENT_ROOT'] . "/lib/index.php";
use Illuminate\Database\Capsule\Manager as DB;

/**
 * Register a new user
 *
 * @param string $email     New unique email to register
 * @param string $password  Password for the new user
 */
function register($email, $password)
{
  $user_id = DB::table('Users')
    ->insertGetId([
    'email' => $email,
    'password_hash' => password_hash($password, PASSWORD_DEFAULT)
  ]);

  safe_start_session();
  $_SESSION['user'] = $user_id;
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
  $user = DB::table('Users')
      ->select(['user_id', 'password_hash'])
      ->where('email', $email)
      ->first();

  if (!isset($user)) {
    return ['email' => "Email is not linked to an account"];
  }

  if (!password_verify($password, $user->password_hash)) {
    return ['password' => "Incorrect password"];
  }

  safe_start_session();
  $_SESSION['user'] = $user->user_id;

  return false;
}

/**
 * check if currently authenticated
 *
 * @param int|false return id of authenticated, otherwise return false
 */
function is_auth()
{
  safe_start_session();
  return isset($_SESSION['user']) ? $_SESSION['user'] : false;
}

/**
 * Ensure user is authenticated to access route
 *
 * @param int return id of authenticated user
 */
function protect_route()
{
  $user = is_auth();
  if ($user) return $user;

  http_response_code(403);

  echo "<strong>Error 403: Unauthorized access</strong>";

  exit();
}
