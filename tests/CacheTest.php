<?php
/**
 * Cache Test
 */
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{
  public function testCache() {
    $template = "{!if: isOdd : 9}{!name}{!endif}";
    $data = ['name' => 'Christopher'];

    $Ginge = new Ginge\Ginge();
    $output = $Ginge->render($template, $data);

    $Cache = new Ginge\Cache\Cache();
    $this->assertSame('Christopher', $Cache->get($template, $data));
  }

  public function testCacheFlush() {
    $template = "{!if: isOdd : 9}{!name}{!endif}";
    $data = ['name' => 'Christopher'];

    $Ginge = new Ginge\Ginge();
    $output = $Ginge->render($template, $data);

    $Cache = new Ginge\Cache\Cache();
    $Cache->flushCache();

    $this->assertSame([], array_diff(scandir(Ginge\Data\Config::get('CACHE_PATH')), array('..', '.', '.gitignore')));
  }
}