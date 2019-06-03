<?php
/**
 * Functions Class
 */
namespace Ginge\Functions;


/**
 * @abstract
 * @package Ginge\Functions
 */
abstract class Functions
{
  /**
   * @abstract
   * @param    array $arguments (Optional)
   */
  abstract protected function exec($arguments);

  /**
   * @access public
   * @param  array  $arguments
   * @return string
   */
  public function call($arguments) {
    $arguments = preg_split('/\s*,\s*/', $arguments);
    return $this->exec($arguments);
  }

  /**
   * @static
   * @access public
   * @param  string $class
   * @return object
   */
  public static function factory($class) {
    $object = '';
    $class_name = __NAMESPACE__ . "\\" . ucfirst($class);

    // Make sure class is defined and part of Functions class
    if (class_exists($class_name) && is_subclass_of($class_name, __CLASS__)) {
      $object = new $class_name();
    }

    return $object;
  }
}