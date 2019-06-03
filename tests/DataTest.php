<?php
/**
 * Data Test
 */
use PHPUnit\Framework\TestCase;

class DataTest extends TestCase
{
  public function testDataSetAndGet() {
    \Ginge\Data\Data::set('name', 'Christopher');
    $this->assertSame('Christopher', \Ginge\Data\Data::get('name'));
  }

  public function testDataArray() {
    \Ginge\Data\Data::initialize([
      'user' => [
        'first_name' => 'Chris',
        'last_name' => 'Topher'
      ]
    ]);
    $this->assertSame('Chris', \Ginge\Data\Data::get(['user', 'first_name']));
  }

  public function testDataArrayInTemplate() {
    $template = "{!user.last_name}";
    $data = [
      'user' => [
        'first_name' => 'Chris',
        'last_name' => 'Topher'
      ]
    ];
    $g = new Ginge\Ginge();
    $this->assertSame('Topher', $g->render($template, $data));
  }

  public function testJsonInit() {
    $template = "{!email}";
    $data = '{"email": "email@example.com"}';
    
    $g = new Ginge\Ginge();
    $this->assertSame('email@example.com', $g->render($template, $data));
  }
}