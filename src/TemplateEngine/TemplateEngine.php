<?php
/**
 * The Template Engine
 */
namespace Ginge\TemplateEngine;

use \Ginge\Data\Data;
use \Ginge\Variable\Variable;


/**
 * @package Ginge\TemplateEngine
 */
class TemplateEngine
{
  protected $template = '';
  protected $expression = '';
  protected $Variable;
  private $local_data = [];

  /**
   * @access public
   * @return void
   */
  public function __construct() {
    $this->Variable = new Variable();
  }

  /**
   * @access public
   * @return string
   */
  public function go() {
    return $this->parse();
  }

  /**
   * The main engine. Basically this splits template by statements, which
   * is a subclass of this TemplateEngine class, and instatiates statements
   * objects. When statements are nested, it recursively calls this class.
   *
   * @access protected
   * @return string
   */
  protected function parse() {
    $statement_count = 0;
    $output = [];

    // Split template string to array and include statements
    $lines = preg_split('/\s*(\{!\s*(?:[a-z\s]+:[^\}]+|end(?:if|foreach))\s*\})/', $this->template, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    // Start Loop
    foreach($lines as $line) {

      // Match if|foreach or end
      if (preg_match('/^\{!\s*((if|foreach)\s*:\s*([^\}]+)\s*|end(?:if|foreach))\s*\}$/', $line, $statement)) {
        // var_dump($statement);

        // Check if we have a if|foreach beginning statement
        if (preg_match('/^(?:if|foreach)/', $statement[1])) {
          // We only need to put main statement in the statement class. Nested statements get appended as the template.
          $statement_count++;

          // if 1, instantiate, else put in statement_node
          if ($statement_count == 1) {
            $StatementClass = __NAMESPACE__ . "\\" . ucfirst($statement[2]) . "Statement";
            $Statement = new $StatementClass();
            $Statement->expression = trim($statement[3]);
          } else {
            // put in $Statement object
            $Statement->setTemplate($line);
          }

        // end cap
        } else {
          if ($statement_count == 1) {
            $output[] = $Statement->go();
          } else {
            $Statement->setTemplate($line);
          }

          $statement_count--;
        }

      // Match just text
      } else {
        if ($statement_count > 0) {
          $Statement->setTemplate($line);
        } else {
          $output[] = $this->Variable->translate($line);
        }
      }
    }

    return implode($output);
  }

  /**
   * @access public
   * @param  string $item
   */
  public function setTemplate($item) {
    $this->template .= $this->loadTemplate($item);
  }

  /**
   * @access private
   * @param  string $template
   * @return string
   */
  private function loadTemplate($template) {
    if (is_file($template)) {
      $template = file_get_contents($template);
    }

    return $template;
  }
}