<?php

namespace vld {
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
   * Validate if data is a number
   *
   * @param string $msg error message
   */
  function is_numeric($msg = "Is not an integer") {
    return ensure(fn ($x) => is_numeric($x), $msg);
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
        $pass = $predicate($data[$key]);
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
