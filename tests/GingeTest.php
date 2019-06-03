<?php
/**
 * Ginge test
 */
use PHPUnit\Framework\TestCase;

class GingeTest extends TestCase
{
  protected $data;

  public function setUp() : void {
    $this->data = ['name' => 'Christopher'];
  }

  public function testIs_Ginge_An_Object() {
    $Ginge = new Ginge\Ginge();
    $this->assertTrue(is_object($Ginge));
  }

  public function testTemplateVariables() {
    $template = "{!name}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('Christopher', $Ginge->render($template, $this->data));
  }

  public function testTemplateFile() {
    $template = __DIR__ . '/assets/last_name.tpl';
    $data = ['last_name' => 'Topher'];

    $Ginge = new Ginge\Ginge();
    $this->assertSame('Topher', $Ginge->render($template, $data));
  }

  public function testSettings() {
    $template = '{!name}';
    $data = ['name' => 'Chris'];

    $Ginge = new Ginge\Ginge(['CACHE' => false, 'CACHE_PATH' => '/path/to/new/cache']);
    $this->assertFalse(Ginge\Data\Config::get('CACHE'));
    $this->assertSame('/path/to/new/cache', Ginge\Data\Config::get('CACHE_PATH'));
  }
}