<?php

if (!defined('COMPONENTS_DIR'))
  define('COMPONENTS_DIR', 'components/');

if (!defined('COMPONENTS_EXT'))
  define('COMPONENTS_EXT', 'php');

$__component_stack = array();

function start($name, $data = array())
{
  global $__component_stack;

  $component = ['name' => $name, 'data' => $data];
  array_push($__component_stack, $component);
  ob_start();
}

function stop()
{
  global $__component_stack;

  $component = array_pop($__component_stack);
  $content = ob_get_clean();
  $data = array_merge(
    $component['data'],
    ['children' => $content]
  );
  insert($component['name'], $data);
}

function insert($name, $data = array())
{
  extract($data);
  include COMPONENTS_DIR . $name . '.' . COMPONENTS_EXT;
}

$__sections = array();
$__section_stack = array();

function section($name, $key = null)
{
  global $__section_stack;
  array_push(
    $__section_stack,
    ['name' => $name, 'key' => $key]
  );
  ob_start();
}

function end_section()
{
  global $__sections, $__section_stack;
  static $keys = array();

  $buffer = array_pop($__section_stack);
  ['name' => $name, 'key' => $key] = $buffer;
  $content = ob_get_clean();

  if ($key !== '' && isset($keys[$key])) {
    return;
  }

  $keys[$key] = 1;
  if ($name === '') {
    echo $content;
  } elseif (!isset($__sections[$name])) {
    $__sections[$name] = $content;
  } else {
    $__sections[$name] .= $content;
  }
}

function insert_section($name)
{
  global $__sections;
  if (isset($__sections[$name])) {
    echo $__sections[$name];
  }
}
