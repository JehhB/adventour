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

function gt($a, $b)
{
  return $a > $b;
}

function gte($a, $b)
{
  return $a >= $b;
}

function params()
{
  $url = $_SERVER['REQUEST_URI'];
  $queryString = parse_url($url, PHP_URL_QUERY);
  parse_str($queryString, $params);
  return $params;
}
