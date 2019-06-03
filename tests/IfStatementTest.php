<?php
/**
 * IfStatement Test
 */
use PHPUnit\Framework\TestCase;

class IfStatementTest extends TestCase
{
  protected $data;

  public function setUp() : void {
    $this->data = [
      'last_name' => 'Christopher',
      'template_name' => 'Ginge',
      'name' => 'Chris',
      'email' => 'chris@example.com',
      'stringed_number' => '123',
      'int_number' => 123
    ];
  }

  public function testIfStatement() {
    $template = "{!if:name}{!name}{!endif}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('Chris', $Ginge->render($template, $this->data));
  }

  public function testNestedIfStatement() {
    $template = "{!if:name}{!if:email}{!name}: {!email}{!endif}{!endif}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('Chris: chris@example.com', $Ginge->render($template, $this->data));
  }

  public function testFalseBoolIfStatement() {
    $template = "{!if: false}{!name}{!endif}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('', $Ginge->render($template, $this->data));
  }

  public function testTrueBoolIfStatement() {
    $template = "{!if: true}{!name}{!endif}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('Chris', $Ginge->render($template, $this->data));
  }

  public function testGreaterThanIfStatement() {
    $template = "{!if: int_number > 100}{!name}{!endif}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('Chris', $Ginge->render($template, $this->data));
  }

  public function testGreaterThanOrEqualIfStatement() {
    $template = "{!if: int_number >= 123}{!name}{!endif}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('Chris', $Ginge->render($template, $this->data));
  }

  public function testLessThanIfStatement() {
    $template = "{!if: int_number < 200}{!name}{!endif}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('Chris', $Ginge->render($template, $this->data));
  }

  public function testLessThanOrEqualIfStatement() {
    $template = "{!if: int_number <= 123}{!name}{!endif}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('Chris', $Ginge->render($template, $this->data));
  }

  public function testEqualIfStatement() {
    $template = "{!if:'Christopher' == last_name}{!name}{!endif}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('Chris', $Ginge->render($template, $this->data));
  }

  public function testFalseStrictEqualIfStatement() {
    $template = "{!if: int_number === '123'}{!name}{!endif}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('', $Ginge->render($template, $this->data));
  }

  public function testTrueStrictEqualIfStatement() {
    $template = "{!if: int_number === 123}{!name}{!endif}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('Chris', $Ginge->render($template, $this->data));
  }
}
