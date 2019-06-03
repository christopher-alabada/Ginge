<?php
/**
 * If Statement class
 */
namespace Ginge\TemplateEngine;

use \Ginge\Data\Data;
use \Ginge\Functions\Functions;


/**
 * @package Ginge\TemplateEngine
 */
class IfStatement extends TemplateEngine
{
  /**
   * @access public
   * @return string
   */
  public function go() {
    if ($this->evaluateExpression()) {
      return $this->parse();
    } else {
      return '';
    }
  }

  /**
   * @access private
   * @return boolean
   */
  private function evaluateExpression() {
    // Check if we have a full expression
    if (preg_match('/((["\'])(?:[^\1\\\]|\\.)*?\2|[^\s]+)\s*([=!<>:]{1,3})\s*((["\'])(?:[^\1\\\]|\\.)*?\5|[^\s]+)/', $this->expression, $expression_parts)) {
      // Separate full regex match
      $expression = array_shift($expression_parts);

      // Split expression between operand1 operator operand2
      list($operand1, $operator, $operand2) = array_values(array_filter($expression_parts, function($part) { return (!empty($part) && !preg_match('/^["\']$/', $part)); }));

      // check if colon because it's a function
      if ($operator == ":") {
        $Functions = Functions::factory($operand1);
        return $Functions->call($operand2);
      } else {
        return $this->evaluateComparisonExpression($operand1, $operator, $operand2);
      }

    // Probably just a boolean or variable
    } else {
      // check if boolean
      if (preg_match('/(?:true|false)/', $this->expression)) {
        return ($this->expression === "true") ? true : false;

      // check if variable
      } elseif (Data::get($this->expression)) {
        return true;
      } else {
        return false;
      }
    }
  }

  /**
   * @access private
   * @param  string $operand1
   * @param  string $operator
   * @param  string $operand2
   * @return boolean
   */
  private function evaluateComparisonExpression($operand1, $operator, $operand2) {
    // Get either string or if variable, get data
    $operand1 = $this->parseOperand($operand1);
    $operand2 = $this->parseOperand($operand2);

    switch($operator) {
      case '===':
        return ($operand1 === $operand2); // Identical
        break;
      case '!==':
        return ($operand1 !== $operand2); // Not identical
        break;
      case '==':
        return ($operand1 == $operand2); // Equal
        break;
      case '!=':
      case '<>':
        return ($operand1 != $operand2); // Not equal
        break;
      case '<=':
        return ($operand1 <= $operand2); // Less than or equal to
        break;
      case '>=':
        return ($operand1 >= $operand2); // Greater than or equal to
        break;
      case '<':
        return ($operand1 < $operand2); // Less than
        break;
      case '>':
        return ($operand1 > $operand2); // Greater than
        break;
      default:
        return false;
    }
  }

  /**
   * @access private
   * @param  string $operand
   * @return mixed
   */
  private function parseOperand($operand) {
    // check if string
    if (preg_match('/^(["\'])((?:[^\1\\\]|\\.)*?)(\1)$/', $operand, $matches)) {
      return stripcslashes($matches[2]);
    } elseif (preg_match('/^[0-9]/', $operand)) {
      return (int) $operand;
    } else {
      return Data::get($operand);
    }
  }
}