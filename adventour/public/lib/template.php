<?php

/** @var string Directory to look for components */
define('COMPONENTS_DIR', __DIR__ . '/views');
/** @var string File extention of components */
define('COMPONENTS_EXT', 'php');

/** 
 * Sanitize string or strings in an array using htmlspecialchars;
 *
 * @param string|array $input Input to sanitize
 * @return string|array Returns sanitize string
 */
function e($input)
{
  if (is_string($input)) {
    return htmlspecialchars($input);
  } else if (is_array($input)) {
    return array_map(fn ($e) => e($e), $input);
  }
  return $input;
}

/**
 * Resolve fullpath to component file
 * 
 * @param string $name Name of component
 * 
 * @return string Returns the resolved path for the component
 */
function resolve_path($name)
{
  return COMPONENTS_DIR . "/$name." . COMPONENTS_EXT;
}

/**
 * Insert template section of component
 * 
 * @param string  $name Name of component to be insert
 * @param mixed[] $data Data to be passed into component
 */
function insert($name, $data = array())
{
  echo render($name, $data);
}

/**
 * Render a component with the given data
 * 
 * @param string  $name     Name of component to be rendered
 * @param mixed[] $data     Data to be passed into component
 * @param bool    $sanitize Wheter to sanitize data before inserting
 * 
 * @return string Return rendered component
 */

function render($name, $data = array(), $sanitize = false)
{
  if ($sanitize) {
    $data = e($data);
  }

  $path = resolve_path($name);
  ob_start();

  (function () {
    extract(func_get_arg(0));
    require func_get_arg(1);
  })($data, $path);

  return ob_get_clean();
}
