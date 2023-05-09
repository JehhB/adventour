<?php

/** @var string Directory to look for components */
define('COMPONENTS_DIR', __DIR__ . '/../views/');
/** @var string File extention of components */
define('COMPONENTS_EXT', '.php');
/** @var bool Configure automatic sanitization of template data */
define('COMPONENT_SANITIZE_STRING', true);

/** 
 * Sanitize string. alias to htmlspecialchars()
 *
 * @param string $input Input string to sanitize
 * @return string Returns sanitize string
 */
function e($input) {
  return htmlspecialchars($input);
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
  $path = resolve_path($name);
  $content = render($path, $data);
  $sections = get_sections($content);
  if (isset($sections["component"])) {
    echo $sections["component"];
  }
}

/**
 * Insert all sections with the given name from all templates
 * 
 * @param string $section Name of the section to be inserted
 */
function insert_all($section)
{
  $output =  '';
  foreach (glob(resolve_path('*')) as $file) {
    $content = render($file);
    $sections = get_sections($content);
    if (isset($sections[$section])) {
      $output .= $sections[$section];
    }
  }
  echo $output;
}

/**
 * Render a component with the given data
 * 
 * @param string  $name Name of component to be rendered
 * @param mixed[] $data Data to be passed into component
 * 
 * @return string Return rendered component
 */

function render($path, $data = array())
{
  if (COMPONENT_SANITIZE_STRING) {
    $data = array_map(fn ($e) => is_string($e) ? e($e) : $e, $data);
  }

  extract($data);
  ob_start();
  require $path;
  return ob_get_clean();
}

/**
 * Extract sections from component
 * 
 * @param string $content The contents of the component
 * 
 * @return array Return an associative array of sections
 *               this sections are: component, style, and script
 */
function get_sections($content)
{
  $sections = array();
  foreach (array('component', 'style', 'script') as $section) {
    preg_match("#<$section>(.*?)</$section>#s", $content, $match);
    if (count($match) < 2) continue;
    $sections[$section] = $match[1];
  }
  return $sections;
}
