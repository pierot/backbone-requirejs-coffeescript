<?php
# ============================================================================ #
/**
 * Proximity Framwork Helpers 
 * 
 * v0.01
 * @package proximitybbdo
 *
 * These functions are generic helpers that can be used throughout the framework
 * They can be called from everywhere since they are loaded from the moment
 * the app starts.
 */
# ============================================================================ #

/**
 * Logs input to the console (if available, won't crash on IE)
 *
 * @param $msg  the input for the log, can be anything from a string to an object
 *              try me :)
 * 
 * The output will not be shown if you have 'verbose' in you config.yaml
 */
function _log($msg) {
  $out = "<script>//<![CDATA[\n";
  $out .= 'if(this.console) {';
  $out .= 'console.dir(' . json_encode($msg) . '); }';
  $out .= "\n//]]></script>";

  if(_c('verbose')) 
    echo($out);
}

// Splits the url into parts.
function _url_parts() {
  $parts = explode("/", request_uri());
  
  array_shift($parts); // remove first empty element (blame the explode)
  return $parts;
}

// Returns the name (based on the URL) of the part you request (based on the ``$id``).
function _page($id = 0) {
  $parts = _url_parts();

  // if first part is a lang (we match it with the lang array from MultiLang)
  if(count($parts) > 0 && preg_match(Multilang::getInstance()->langs_as_regexp(), $parts[0]))
    array_shift($parts);

  // if the given index is found in the url
  if(count($parts) > 0 && $id < count($parts))
    return $parts[$id];

  return '';
}

// Returns **active** when the ``$page_name`` argument combined with the given ``$id`` resembles the page.
function _get_active($page_name, $id = 0) {
  if(_page($id) == $page_name)
    return 'active';
  
  return '';
}

function _asset($path) {
  $path = preg_replace("/^\//", "", $path);

  return (BASE_PATH == '/' ? '' : BASE_PATH) . '/' . $path;
}
