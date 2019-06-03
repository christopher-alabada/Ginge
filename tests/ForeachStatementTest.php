<?php
/**
 * Foreach Statement Test
 */
use PHPUnit\Framework\TestCase;

class ForEachTest extends TestCase
{
  protected $data;

  public function setUp() : void {
    $this->data = [
      'name' => [
        'Christopher',
        'Ghost',
        'Timmy'
      ],
      'toy' => [
        'transformers',
        'bone',
        'legos'
      ]
    ];
  }

  public function testForeach() {
    $template = "{!foreach: name  as first_name   }{!first_name}{!endforeach}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('ChristopherGhostTimmy', $Ginge->render($template, $this->data));
  }

  public function testNestedForeachAndIf() {
    $template = "{!foreach: name as first_name}{!if: first_name == 'Ghost'}{!first_name}{!endif}{!endforeach}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('Ghost', $Ginge->render($template, $this->data));
  }

  public function testCountAndIndexForeach() {
    $template = "{!foreach: name as first_name}{!_index}:{!_count} {!endforeach}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('0:11:22:3', $Ginge->render($template, $this->data));
  }

  public function testNestedForeach() {
    $template = "{!foreach: name as first_name}{!foreach: toy as toy_name}{!first_name} - {!toy_name}{!endforeach}{!endforeach}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame(
      'Christopher - transformersChristopher - boneChristopher - legosGhost - transformersGhost - boneGhost - legosTimmy - transformersTimmy - boneTimmy - legos',
      $Ginge->render($template, $this->data)
    );
  }

  public function testCountAndIndexNestedForeach() {
    $template = "{!foreach: name as first_name}{!_index}:{!_count}-{!foreach: toy as toy_name}{!_index}:{!_count}+{!endforeach}{!endforeach}";
    $Ginge = new Ginge\Ginge();
    $this->assertSame('0:1-0:1+1:2+2:3+1:2-0:1+1:2+2:3+2:3-0:1+1:2+2:3+', $Ginge->render($template, $this->data));
  }
}