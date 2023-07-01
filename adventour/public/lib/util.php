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
  foreach ($data as $key => $values) {
    $parameters[$key] = $values;
  }

  $encoded_parameters = http_build_query($parameters);
  return count($parameters) === 0 ? $base : "$base?$encoded_parameters";
}
