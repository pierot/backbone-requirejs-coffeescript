<?php

/**
 * You can place all the Zend libraries here, you want to be loaded.
 */
Zend_Loader::loadClass('Zend_Db');

// require whatever is located in app/lib (lib folder is in include_dir)

/**
 * Extra application config
 */
function config() {
  // You can override these default settings.
  // ProximityApp::$settings_file = 'other_config.yml';
  // option('env', ENV_DEVELOPMENT);

  // Extra config
}
