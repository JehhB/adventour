<?php

/**
 * A utilitiy function to create link
 *
 * @param string    $base         the base url for the likn
 * @param array     $data         additional url parameters
 * @param string[]  $carryovers   additional parameter keys, taken from current request
 *
 * @return string
 */
function url($base, $data = [], $carryovers = [])
{
  $parameters = [];
  foreach ($carryovers as $key) {
    if (isset($_GET[$key])) {
      $parameters[$key] = $_GET[$key];
    }
  }

  $encoded_parameters = http_build_query(array_merge($parameters, $data));
  return count($parameters) === 0 ? $base : "$base?$encoded_parameters";
}
