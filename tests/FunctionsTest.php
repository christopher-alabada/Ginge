<?php
/**
 * Functions Test
 */
use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
  public function testIsOdd() {
    $template = "{!if: isOdd : 9}{!name}{!endif}";
    $data = ['name' => 'Christopher'];

    $Ginge = new Ginge\Ginge();
    $this->assertSame('Christopher', $Ginge->render($template, $data));
  }

  public function testIsEvenWithVariable() {
    $template = "{!if: isEven : number }{!name}{!endif}";
    $data = ['name' => 'Christopher', 'number' => 10];

    $Ginge = new Ginge\Ginge();
    $this->assertSame('Christopher', $Ginge->render($template, $data));
  }
}