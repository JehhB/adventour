<?php

namespace vld {

  use Illuminate\Database\Capsule\Manager as DB;

  /** 
   * Validate if data pass predicate
   *
   * @param function  $predicate  predicate to test data
   * @param string    $msg        error message
   */
  function ensure($predicate, $msg = "Is not valid")
  {
    return function ($x) use ($predicate, $msg) {
      if ($predicate($x)) return true;
      else return $msg;
    };
  }

  /** 
   * Validate if data is defined 
   *
   * @param string $msg error message
   */
  function is_defined($msg = "Not defined")
  {
    return ensure(fn ($x) => isset($x), $msg);
  }

  /** 
   * Validate if data is not empty 
   *
   * @param string $msg error message
   */
  function is_not_empty($msg = "Required field")
  {
    return ensure(fn ($x) => isset($x) && strcmp($x, '') !== 0, $msg);
  }

  /**
   * Validate if data is a number
   *
   * @param string $msg error message
   */
  function is_numeric($msg = "Is not numeric")
  {
    return ensure('\is_numeric', $msg);
  }

  /**
   * Validate if data is a valid email address
   *
   * @param string $msg error message
   */
  function is_email($msg = "Must be a valid email")
  {
    return ensure(fn ($x) => filter_var($x, FILTER_VALIDATE_EMAIL), $msg);
  }

  /**
   * Validate if data is long enough
   *
   * @param int    $len minimum length
   * @param string $msg error message
   */
  function is_long_enough($len = 8, $msg = "Must be be atleast 8 character")
  {
    return ensure(fn ($x) => strlen($x) >= $len, $msg);
  }

  /**
   * Validate if data is long enough
   *
   * @param int    $len minimum length
   * @param string $msg error message
   */
  function max_length($len = 127, $msg = "Must be be atmost 127 characters")
  {
    return ensure(fn ($x) => strlen($x) <= $len, $msg);
  }

  /**
   * Validate if string match a value
   *
   * @param string  $val value to compare with
   * @param string $msg error message
   */
  function is_equal($val, $msg = "Values doesn't match")
  {
    return ensure(fn ($x) => strcmp($x, $val) === 0, $msg);
  }

  function between($low, $high, $inclusive, $msg = null)
  {
    return ensure(fn ($x) => $x > $low and $x < $high or ($inclusive and ($x == $low or $x == $high)), $msg);
  }

  function greater_than($val, $inclusive, $msg = "Value is too small")
  {
    return ensure(fn ($x) => $x > $val or ($inclusive and $x == $val), $msg);
  }

  function less_than($val, $inclusive, $msg = "Value is too big")
  {
    return ensure(fn ($x) => $x < $val or ($inclusive and $x == $val), $msg);
  }

  /**
   * Validate if data is unique in the database
   *
   * @param string $table Table to find data
   * @param string $field Field to match data
   * @param string $msg   error message
   */
  function is_unique($table, $field, $msg = "Value is not unique in database")
  {
    return ensure(function ($x) use ($table, $field) {
      $value = DB::table($table)
        ->selectRaw('1 AS data')
        ->where($field, $x)
        ->value('data');
      return !isset($value);
    }, $msg);
  }
}


namespace {
  /**
   * Validate values of data using predicates
   *
   * @param array $data Array to validate
   * @param array $data Array of predicates
   *
   * @return array|false false if there is no errors,
   *                   otherwise return the errors
   */
  function validate($data, $validator)
  {
    $errors = array();

    foreach ($validator as $key => $values) {
      $predicates = is_array($values) ? $values : array($values);
      foreach ($predicates as $predicate) {
        $pass = $predicate($data[$key] ?? null);
        if ($pass !== true) {
          $errors[$key] = $pass;
          break;
        }
      }
    }

    if (empty($errors)) return false;
    else return $errors;
  }

  /**
   * Validate values otherwise throw a malformed request
   *
   * @param array $data Array to validate
   * @param array $data Array of predicates
   */
  function validOrFail($data, $validator)
  {
    $errors = validate($data, $validator);
    if (!$errors) return;

    header('Content-Type: application/json', true, 400);
    echo json_encode($errors);
    exit();
  }
}
