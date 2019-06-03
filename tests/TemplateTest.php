<?php
/**
 * Template Test
 */
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
  public function testTemplateData() {
    $template = "{!template:template}";
    $data = ['name' => 'Christopher', 'template' => '{!name}'];

    $Ginge = new Ginge\Ginge();
    $this->assertSame('Christopher', $Ginge->render($template, $data));
  }

  public function testTemplateFileData() {
    $template = "{!template : " . __DIR__ . "/assets/last_name.tpl}";
    $data = ['last_name' => 'Topher'];

    $Ginge = new Ginge\Ginge();
    $this->assertSame('Topher', $Ginge->render($template, $data));
  }

  public function testTemplateDataFileData() {
    $template = "{!template : tpl_file}";
    $data = ['tpl_file' => __DIR__ . '/assets/last_name.tpl', 'last_name' => 'Topher'];

    $Ginge = new Ginge\Ginge();
    $this->assertSame('Topher', $Ginge->render($template, $data));
  }

  public function testTemplateNestedData() {
    $template = "{!template: simple}{!if:name == 'chris'}{!name}{!endif}";
    $data = [
      'simple' => __DIR__ . '/assets/simple.tpl',
      'nickname_tpl' => __DIR__ . '/assets/nickname.tpl',
      'header' => 'My name is ',
      'name' => 'chris',
      'nickname' => 'Topher'
    ];

    $Ginge = new Ginge\Ginge();
    $this->assertSame('My name is Topherchris', $Ginge->render($template, $data));
  }
}