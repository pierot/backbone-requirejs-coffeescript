<?php

# ============================================================================ #
/**
 * Proximity Apploader
 *
 * Class with helper functions for a basic application
 *
 * v0.01
 *
 * @package proximitybbdo
 *
 */
# ============================================================================ #

// Require spyc for YAML parsing.
require_once(dirname(dirname(__FILE__)) . "/spyc/spyc.php");

class ProximityApp {
  public static $settings = array();
  public static $settings_file = 'config.yml';

  // Parse a yaml config file and save it in an array
  private static function load_settings($settings_file) {
    self::$settings = spyc_load_file($settings_file);
  }

  // Inits the actual app, putting together a skeleton of
  // niceness to use in your app, like multilang
  public static function init($config_directory, $param_settings_file = '') {
    // Step one, parse settings
    self::load_settings($config_directory . (strlen($param_settings_file) > 0 ? $param_settings_file : self::$settings_file));

    // Init Multilang
    Multilang::getInstance()->init();
  }
}

// Helper _c function defined outside of the apploader class
// for easy of use
function _c() {
  $result = ProximityApp::$settings;

  for($i = 0; $i < func_num_args(); $i++)
    $result = $result[func_get_arg($i)];

  return $result;
}
