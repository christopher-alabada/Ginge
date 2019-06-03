<?php
/**
 * Ginge - A Simple PHP Template Engine
 * 
 * A simple PHP templating engine that uses variables, if statements,
 * and foreach loops, which can be nested. It also uses a simple cache.
 *
 * Usage:
 * require_once("/path/to/src/Autoload.php");
 * $Ginge = new Ginge\Ginge();
 * $output = $Ginge->render(<template>, <data>);
 *
 * See README.md for more info.
 *
 * @author    Christopher Alabada <christopher.alabada@gmail.com>
 * @copyright 2019 Christopher Alabada
 * @version   1.0.0
 * @package   Ginge
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Ginge;

use \Ginge\Data\Data;
use \Ginge\Data\Config;
use \Ginge\Cache\Cache;
use \Ginge\TemplateEngine\TemplateEngine;


/**
 * Main Ginge class
 *
 * @package Ginge
 */
class Ginge
{
  /**
   * @access public
   * @param  array  $settings
   * @return void
   */
  public function __construct($settings = []) {
    // Some settings
    Config::set('GINGE_PATH', dirname(__DIR__));
    Config::set('SRC_PATH', __DIR__);
    Config::set('NAMESPACE', __NAMESPACE__);
    Config::set('CACHE', true);
    Config::set('CACHE_PREFIX', 'ginge_cache_');
    Config::set('CACHE_PATH', dirname(__DIR__) . '/cache');
    
    // Overwrite Config settings
    if (!empty($settings)) {
      foreach ($settings as $key => $value) {
        Config::set(strtoupper($key), $value);
      }
    }
  }

  /**
   * @access public
   * @param  string $template The template to render
   * @param  array  $data     Data for the template
   * @return string           The result of the template engine
   */
  public function render($template, $data) {
    // If json, convert
    if (is_string($data)) {
      $data = json_decode($data, true);
      if (json_last_error() !== JSON_ERROR_NONE) {
        return false;
      }
    }

    // let's check if there's a cache
    if (Config::get('CACHE')) {
      $Cache = new Cache();
      $cache_contents = $Cache->get($template, $data);
      if ($cache_contents) {
        return $cache_contents;
      }
    }

    Data::initialize($data);

    $TemplateEngine = new TemplateEngine();
    $TemplateEngine->setTemplate($template);

    $output = $TemplateEngine->go();

    if (Config::get('CACHE')) {
      $cache_filename = $Cache->set($template, $data, $output);
    }

    return $output;
  }
}