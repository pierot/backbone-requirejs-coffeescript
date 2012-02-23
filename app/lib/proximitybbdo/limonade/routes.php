<?php

// This default helper sets some interesting default values.
// ``base_path`` can be used to generate a url that points to the root of the site.
// ``lang`` will give your the language based on an optional language url (eg. /nl-BE/...)
function before($route) {
  set('base_path', BASE_PATH);

  // Set lang if first controller is a language
  $url_parts = _url_parts();
  
  if(preg_match(Multilang::getInstance()->langs_as_regexp(), $url_parts[0]))
    Multilang::getInstance()->setLang($url_parts[0]);

  set('lang', Multilang::getInstance()->getLang());

  if(function_exists('before_route'))
    before_route($route);  
}

function after($output) {
  global $root_directory;

  if(ProximityApp::$settings['xporter']['active']) {
    $xporter = new Exporter($root_directory);
    $xporter->export($output);
  }

  if(function_exists('after_route'))
    return after_route($output);  
  else
    return $output;
}
