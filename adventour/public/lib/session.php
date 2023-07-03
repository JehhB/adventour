<?php

use Illuminate\Database\Capsule\Manager as DB;

/**
 * A function to safely start session
 *
 * @return int returns sessions id
 */
function safe_start_session()
{
  static $started = false;

  if (!$started) {
    $started = true;
    session_start();
  }

  if (!isset($_SESSION['session_id'])) {
    $_SESSION['session_id'] = DB::table('Sessions')->insertGetId([]);
  }

  return $_SESSION['session_id'];
}


/**
 * Return a string if error is set
 *
 * @param string $prop    property to check
 * @param string|array $return  string to return if invalid
 *
 * @return string return string specified if invalid otherwise return empty string
 */
function isInvalid($prop, $return = "invalid")
{
  safe_start_session();
  if (!isset($_SESSION['error'])) return '';
  if (!isset($_SESSION['error'][$prop])) return '';

  return is_array($return) ? join(' ', $return) : $return;
}

/**
 * Return the error message for a specified property
 *
 * @param string $prop    property to check
 *
 * @return string return error message if invalid otherwise return empty string
 */
function getError($prop)
{
  safe_start_session();
  if (!isset($_SESSION['error'])) return '';
  if (!isset($_SESSION['error'][$prop])) return '';

  return $_SESSION['error'][$prop];
}

/**
 * Removed current errors
 */
function clearError()
{
  safe_start_session();
  if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
  }
}
