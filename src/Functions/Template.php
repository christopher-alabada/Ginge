<?php
/**
 * Template class of Functions
 */
namespace Ginge\Functions;

use \Ginge\Data\Data;


/**
 * @package Ginge\Functions
 */
class Template extends Functions
{
  // Need to define this
  protected function exec($arguments) {
    // just need the first arguments
    $template = $arguments[0];

    // do path to file
    if (is_file($template)) {
      $template_contents = file_get_contents($template);

    // Check Data
    } else {
      $template_contents = Data::get($template);

      // If the path to a file is in the data
      if (is_file($template_contents)) {
        $template_contents = file_get_contents($template_contents);
      }
    }
    
    if ($template_contents) {
      $Ginge = new \Ginge\Ginge();
      return $Ginge->render($template_contents, Data::get());
    } else {
      return '';
    }
  }
}