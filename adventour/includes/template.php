<?php

/** @var string Directory to look for components */
define('COMPONENTS_DIR', __DIR__ . '/../views/');
/** @var string File extention of components */
define('COMPONENTS_EXT', '.php');
/** @var bool Configure automatic sanitization of template data */
define('COMPONENT_SANITIZE_STRING', true);

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
  }
  return array_map(fn ($e) => is_string($e) ? e($e) : $e, $input);
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
  return COMPONENTS_DIR . $name . COMPONENTS_EXT;
}

/**
 * Extract a section, which is the content of a root
 * root element in an XML-Like string,
 *
 * @param string $section Section to be extracted
 * @param string $content String to extract section from
 *
 * @return string|false false if section doesn't exist
 * otherwise, returns the extracted section
 */
function extract_section($section, $content)
{
  preg_match("#<$section>(.*?)</$section>#s", $content, $match);
  if (count($match) < 2) return false;
  return $match[1];
}

/**
 * Get a section from a file without evaluating it
 *
 * @param string $path    Path to file
 * @param string $section Section to be extracted
 *
 * @return string|false false if section or file doesn't exist
 *                      otherwise, returns the extracted section
 */
function get_section($path, $section)
{
  $content = file_get_contents($path);
  if ($content === false) return false;

  return extract_section($section, $content);
}

/**
 * Get specified section from all component without evaluating it
 *
 * @param string $section Section to be extracted
 *
 * @return string Concatenation of all extracted section.
 */
function get_all($section)
{
  $output = "";
  foreach (glob(resolve_path('*')) as $path) {
    $content = get_section($path, $section);
    if ($content) $output .= $content;
  }
  return $output;
}

$__component_stack = array();

/**
 * Specify start of a container component
 * 
 * @param string  $name Name of container component
 * @param mixed[] $data Data to be passed into component
 */
function start($name, $data = array())
{
  global $__component_stack;

  $component = array(
    'name' => $name,
    'data' => $data
  );
  array_push($__component_stack, $component);
  ob_start();
}

/**
 * Specify the end of a component
 */
function stop()
{
  global $__component_stack;

  $component = array_pop($__component_stack);
  $content = ob_get_clean();
  $data = array_merge(
    $component['data'],
    array('content' => $content),
  );
  insert($component['name'], $data);
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
 * @param string  $name Name of component to be rendered
 * @param mixed[] $data Data to be passed into component
 * 
 * @return string Return rendered component
 */

function render($name, $data = array())
{
  if (COMPONENT_SANITIZE_STRING) {
    $data = e($data);
  }

  $path = resolve_path($name);
  ob_start();

  (function () {
    extract(func_get_arg(0));
    require func_get_arg(1);
  })($data, $path);

  $content = ob_get_clean();
  $component = extract_section('component', $content);
  return $component === false ? '' : $component;
}
