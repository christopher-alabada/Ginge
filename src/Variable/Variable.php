<?php
/**
 * Variable Class
 */
namespace Ginge\Variable;

use \Ginge\Data\Data;
use \Ginge\Functions\Functions;


/**
 * @package Ginge\Variable
 */
class Variable
{
  /**
   * @access private
   * @var $local_data
   */
  private $local_data;


  /**
   * Sets local data for statement blocks
   *
   * @access public
   * @param  string $key
   * @param  mixed  $value
   * @return void
   */
  public function setLocalData($key, $value) {
    $this->local_data[$key] = $value;
  }

  /**
   * Gets local data for statement blocks
   *
   * @access public
   * @param  string $key
   * @return mixed
   */
  public function getLocalData($key) {
    return $this->local_data[$key];
  }

  /**
   * Translates template variables from the data
   *
   * @access public
   * @param string $text
   * @return string
   */
  public function translate($text) {
    if (preg_match_all('/\{!\s*([-_.0-9a-zA-Z]+)\s*:?\s*([^\}]*)\}/', $text, $matches, PREG_SET_ORDER)) {
      foreach ($matches as $variable) {
        // Function Factory here
        if (!empty($variable[2])) {
          $Functions = Functions::factory($variable[1]);
          $replace = $Functions->call($variable[2]);

        // check if local variable
        } else if (strpos($variable[1], '_') === 0) {
          $replace = $this->getLocalData($variable[1]);

        // just a regular variable
        } else {
          $replace = Data::get($variable[1]);
        }

        $text = str_replace($variable[0], $replace, $text);
      }
    }

    return $text;
  }
}