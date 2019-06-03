<?php
/**
 * Foreach Statement class
 */
namespace Ginge\TemplateEngine;

use \Ginge\Data\Data;


/**
 * @package Ginge\TemplateEngine
 */
class ForeachStatement extends TemplateEngine
{
  /**
   * @access protected
   * @var int $count
   */
  protected $count = 1;

  /**
   * @access protected
   * @var int $index
   */
  protected $index = 0;


  /**
   * @access public
   * @return string
   */
  public function go() {
    $output = [];
    $foreach_parts = $this->parseLoop();
    if ($foreach_parts) {
      // loop through data and pass value
      foreach ($foreach_parts[0] as $local_var) {
        Data::set($foreach_parts[1], $local_var);
        
        $this->Variable->setLocalData('_count', $this->count);
        $this->Variable->setLocalData('_index', $this->index);

        $output[] = $this->parse();

        $this->count++;
        $this->index++;
      }
    } else {
      return '';
    }

    return implode($output);
  }

  /**
   * @access private
   * @return mixed
   */
  private function parseLoop() {
    // separate by " as "
    $expression_parts = preg_split('/\s+as\s+/', $this->expression);
    if (count($expression_parts) === 2) {
      // make sure $set is an array
      $set = Data::get($expression_parts[0]);

      if (is_array($set)) {
        return [$set, $expression_parts[1]];
      } else {
        return false;
      }
    }
  }
}