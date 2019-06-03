<?php
/**
 * Autoloader
 */
namespace Ginge;


spl_autoload_register(function($class_name) {
  if (strpos($class_name, __NAMESPACE__ . '\\') !== false) {
    // var_dump($class_name);

    $path_parts = explode('\\', $class_name);
    array_shift($path_parts);
    $path_parts[count($path_parts)-1] .= '.php';

    $full_path = __DIR__ . '/' . implode('/', $path_parts);

    if (is_file($full_path)) {
      require_once($full_path);
    }
  }
});