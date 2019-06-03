<?php
/**
 * Data Class
 */
namespace Ginge\Data;


/**
 * @package Ginge\Data
 */
class Data
{
  /**
   * @static
   * @access protected
   * @var    array     $data
   */
  static protected $data = [];

  /**
   * @static
   * @access public
   * @param  array  $data
   * @return void
   */
  public static function initialize($data) {
    static::$data = $data;
  }

  /**
   * @static
   * @access public
   * @return mixed
   */
  public static function get($arguments = '') {
    if (!empty($arguments) && is_string($arguments)) {
      // dotnotaion array traversal
      if (strpos($arguments, '.') !== false) {
        $arguments = explode('.', $arguments);
      } else {
        $arguments = [$arguments];
      }
    }

    $variable = static::$data;

    if (!empty($arguments)) {
      foreach ($arguments as $key) {
        if (array_key_exists($key, $variable)) {
          $variable = $variable[$key];
        } else {
          return '';
        }
      }
    }

    return $variable;
  }

  /**
   * @static
   * @access public
   * @param  string $key
   * @param  mixed  $data
   * @return void
   */
  public static function set($key, $data) {
    if ($key) {
      static::$data[$key] = $data;
    } else {
      static::$data = $data;
    }
  }
}
