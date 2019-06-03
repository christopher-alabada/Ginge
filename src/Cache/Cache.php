<?php
/**
 * Cache Class
 */
namespace Ginge\Cache;

use \Ginge\Data\Config;


/**
 * @package Ginge\Cache
 */
class Cache
{
  /**
   * @access public
   * @param  array $settings (Optional) Settings to overwrite GLobal config
   * @return void
   */
  public function __construct($settings = []) {
    // overwrite cache location
    if (array_key_exists('cache_path', $settings)) {
      if ($settings['cache_path'] && is_dir($settings['cache_path']) && is_writable($settings['cache_path'])) {
        Config::set('CACHE_PATH', $settings['cache_path']);
      }
    }
  }

  /**
   * @access public
   * @param  string $template The template
   * @param  array  $data     Data for the template
   * @return string|bool      Returns the cache content or false if no cache exists.
   */
  public function get($template, $data) {
    if (!$template || !$data) {
      return false;
    }

    $cache_full_path = Config::get('CACHE_PATH') . '/' . $this->createCacheName($template, $data);

    if (is_file($cache_full_path)) {
      return file_get_contents($cache_full_path);
    } else {
      return false;
    }
  }

  /**
   * @access public
   * @param  string $template The template
   * @param  array  $data     Data for the template
   * @param  string $output   The output of the template engine to save to cache.
   * @return string           The full path to the cache
   */
  public function set($template, $data, $output) {
    $cache_full_path = Config::get('CACHE_PATH') . '/' . $this->createCacheName($template, $data);

    // only write if cache doesn't exist
    if (!is_file($cache_full_path)) {
      if (file_put_contents($cache_full_path, $output) === false) {
        return false;
      } else {
        return $cache_full_path;
      }
    } else {
      // file exists
      return $cache_full_path;
    }
  }

  /**
   * @access private
   * @param  string $template The template
   * @param  array  $data     Data for the template
   * @return string           The name of the cache's filename.
   */
  private function createCacheName($template, $data) {
    // md5 data and template
    $json = json_encode($data);
    $md5 = md5($json . $template);
    return Config::get('CACHE_PREFIX') . $md5 . ".txt";
  }

  /**
   * @access private
   * @param  string $cache (Optional) Cache file name to flush
   * @return string        The name of the cache's filename.
   */
  public function flushCache($cache = '') {
    if (is_writable($cache)) {
      unlink($file);
    } else {
      $files = glob(Config::get('CACHE_PATH') . '/*.txt');
      foreach($files as $file) {
        if (is_file($file)) {
          unlink($file);
        }
      }
    }
  }
}