<?php
include $_SERVER['DOCUMENT_ROOT'] . "/lib/index.php";
use Illuminate\Database\Capsule\Manager as DB;

/**
 * Register a new user
 *
 * @param string $email     New unique email to register
 * @param string $username  Username of the new user
 * @param string $password  Password for the new user
 */
function register($email, $password, $username)
{
  $user_id = DB::table('Users')
    ->insertGetId([
    'email' => $email,
    'password_hash' => password_hash($password, PASSWORD_DEFAULT)
  ]);

  DB::table('Profiles')
    ->insert(['user_id' => $user_id, 'username' => $username]);

  safe_start_session();
  $_SESSION['user'] = $user_id;
  $_SESSION['account_type'] = 'user';
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
      ->select(['user_id', 'password_hash', 'account_type'])
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
  $_SESSION['account_type'] = $user->account_type;

  return false;
}

function change_password($old, $password)  {
  $user_id = is_auth();
  if (!$user_id) return ['user' => 'Not logged in'];

  $user = DB::table('Users')
    ->select(['user_id', 'password_hash'])
    ->where('user_id', $user_id)
    ->first();

  if (!password_verify($old, $user->password_hash)) {
    return ['old' => "Incorrect password"];
  }

  DB::table('Users')
    ->where('user_id', $user_id)
    ->update(['password_hash' => password_hash($password, PASSWORD_DEFAULT)]);

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
