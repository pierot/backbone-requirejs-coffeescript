<?php
# ============================================================================ #
/**
 * Proximity Multilang lib
 *
 * Handles translation through xml files
 * 
 * v0.05
 * @package proximitybbdo
 */
# ============================================================================ #

class Multilang
{
  private static $instance = null;

  private $lang = ''; 
  public $langs = array();
  private $inited = false;

  private function __construct() {
    $this->lang = '';
  }

  public function __clone() {
    trigger_error( "Cannot clone instance of Singleton pattern ...", E_USER_ERROR );
  }
  public function __wakeup() {
    trigger_error('Cannot deserialize instance of Singleton pattern ...', E_USER_ERROR );
  }

  /**
   * Returns an instance of Multilan
   */
  public static function getInstance() {
    if( self::$instance == null )
      self::$instance = new Multilang();

    return self::$instance;
  }

  public function iso_lang($lang) {
    $iso_langs['nl'] = 'nl-BE';
    $iso_langs['fr'] = 'fr-BE';
    $iso_langs['en'] = 'en-UK';
    $iso_langs['pt'] = 'pt-PT';
    
    if(array_key_exists($lang, $iso_langs) && strlen($iso_langs[$lang]) > 0)
      return $iso_langs[$lang]; 
    else
      return $lang;
  }

  /**
   * 
   */
  public function set_time_locale() { 
    switch($this->lang) { 
    case "nl-BE": 
      $l = setlocale(LC_TIME, "dutch-belgian", "nlb", "nlb-nlb", "nld-nld", "nl_NL");  
      break; 
    case "fr-BE": 
      $l = setlocale(LC_TIME, "french-belgian", "frb", "frb-frb", "fr_BE", "br_FR");  
      break; 
    default:  
      $l = setlocale(LC_TIME, ""); 
      break; 
    } 
  }

  /**
   * Parse the language files and set the default lang
   */
  public function init() {
    if($this->inited == FALSE)
      $this->inited = TRUE;
    else
      return;

    $lang_dir_setting = ProximityApp::$settings['multilang']['dir'];
    $lang_dir = strlen($lang_dir_setting) > 0 ? $lang_dir_setting : 'assets/locales/';
    $lang_dir = dirname(__FILE__) . '/../../../' . $lang_dir;

    // Set default lang
    $this->setlang(ProximityApp::$settings['multilang']['default']);

    // Parse languages
    foreach (glob($lang_dir . '*.yml') as $filename)
      $this->langs[basename($filename, '.yml')] = spyc_load_file($filename);
  }

  /**
   * Destroy the language array and any other variables
   */
  public function destroy() {
    /* unset($this->lang); */
    return TRUE;
  }

  /**
   * Change the default language multilang translates against
   * @param string $lang the new language
   */
  public function setLang($lang) {
    $this->lang = $this->iso_lang($lang);
    $this->set_time_locale();
  }

  /**
   * Return the current language
   * @return string
   */
  public function getLang() {
    return $this->lang;
  }

  /**
   * Switch back to the default language
   */
  public function defaultLang() {
    $this->setLang(ProximityApp::$settings['multilang']['default']);
  }

  /**
   * Main function of this class, gets the responding string for a given
   * key, in the current language. Change the language by using lang()
   *
   * @param string $key the key of the translated string
   * @param string $lang (optional) lang key
   * @return string
   */
  public function _t($key, $lang = '') {
    $lang = strlen($lang) == 0 ? $this->lang : $this->iso_lang($lang);

    return new MultiLangKey($this->langs[$lang][$key]);
  }

  /**
   * Main function of this class, gets the responding string for a given
   * key, in the current language. Change the language by using lang()
   *
   * @param string $key the key of the translated string
   * @param string $regexp a regular expression update dynamic values
   * @param string $params the params to replace the the regexp matches
   *
   * @return string
   */
  public function _d($key, $regexp, $params) {
    if(isset($regexp)) {
      $matches = array();

      $value = $this->langs[$this->lang][$key];
      $value = preg_replace($regexp, $params, $value);

      return $value;
    }

    return $this->langs[$this->lang][$key];
  }

  /**
   * Get all languages formatted for multi-select regular expression ``nl|fr|en|...``
   */
  public function langs_as_regexp() {
    $lang_names = array();

    foreach ($this->langs as $key => $value) 
      array_push($lang_names, $key);
    
    return "/" . implode('|', $lang_names) . "/";
  }

  /**
   * Get count of languages available
   * @return int
   */
  public function get_lang_count() {
    return count($this->langs);
  }
}

class MultiLangKey extends ArrayObject {
  public $_data = array();

  function __construct($data) {
    $this->_data = $data;

    if(is_array($this->_data))
      parent::__construct($this->_data, ArrayObject::ARRAY_AS_PROPS);
  }

  public function __call($name, array $arguments) {
    if($name == '_t' || $name == 't')
      return call_user_func_array(array($this, '__t'), $arguments);
  }

  private function __t($key) {
    return new MultiLangKey($this->_data[$key]);
  }

  public function __toString() {
    return (string) $this->_data;
  }
}

/**
 * Helper _t function defined outside of the multilang class for ease of use,
 * pass language as second parameter for specific translation of key
 * and pass false as 2nd or 3rd parameter to return value instead
 */
function _t($key, $var1 = '', $var2 = true) {
  if(is_bool($var1))
    $echo = (bool) $var1;
  else {
    $echo = $var2;

    if(strlen($var1) == 0)
      $var1 = Multilang::getInstance()->getLang();
  }

  $value = Multilang::getInstance()->_t($key, Multilang::getInstance()->iso_lang($var1));

  if(!$echo) 
    return $value;

  echo($value);
}

/**
 * Helper _d function defined outside of the multilang class
 * for easy of use, works with regexp for dynamic values
 */
function _d($key, $regexp = null, $params = null, $echo = true) {
  if(!$echo)
    return Multilang::getInstance()->_d($key, $regexp, $params);
  
  echo(Multilang::getInstance()->_d($key, $regexp, $params));
}
