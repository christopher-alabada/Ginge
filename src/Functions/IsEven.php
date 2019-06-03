<?php
/**
 * isEven function
 */
namespace Ginge\Functions;

use \Ginge\Data\Data;

/**
 * @package Ginge\Functions
 */
class IsEven extends Functions
{
  // Need to define this
  protected function exec($arguments) {
    $dividend = Data::get($arguments[0]);
    
    if (!is_numeric($dividend)) {
      if (is_numeric($arguments[0])) {
        $dividend = $arguments[0];
      } else {
        return false;
      }
    }

    return ($dividend % 2 == 0);
  }
}