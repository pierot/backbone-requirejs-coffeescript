<?php

class Lister
{ 
  private $processed = array();

  public function process_links($url, $path) {
    $links = array();
    $xml = new DOMDocument();
    @$xml->loadHTMLFile($url . $path);

    foreach($xml->getElementsByTagName('a') as $link) {
      $href = $link->getAttribute('href');

      if( preg_match('/^(http)/', $href) == 0 && 
          preg_match('/^(#)/', $href) == 0 && 
          !in_array($href, $this->processed) && 
          !in_array($href, $links))
        array_push($links, $href);
    }

    $count = 0;

    foreach($links as $link) {
      if(!in_array($link, $this->processed)) {
        array_push($this->processed, $link);

        $count++;

        $this->process_links($url, $link);
      }
    }

    if($count == 0)
      $this->end_processing();
  }

  private function end_processing() {
    var_dump($this->processed);
  }
}

function _xporter_listing() {
  echo("Listing site for xPorter");
  echo("<br>"); echo("<br>");

  $lister = new Lister();
  $lister->process_links(ProximityApp::$settings['xporter']['base_url'], ProximityApp::$settings['xporter']['base_path']);

  echo("<br>"); echo("<br>");
  echo("Done listing.");
}

dispatch('/xporter-listr', '_xporter_listing');

class Exporter
{
  private $path_prefix_base = './';
  private $export_dir = 'export';
  private $ignore_dirs = array('assets', 'data', 'export');
  private $export_base = '';

  function __construct($export_base) {
    $this->export_base = $export_base; 
  }

  public function export($output) {
    $path_prefix = $this->path_prefix_base;
    $export_path = $this->export_base . $this->export_dir . '/';

    $path_split = explode('/', $this->request_path(request_uri()));
    $file_name = array_pop($path_split) . '.html';
    $dir_depth = count($path_split);

    if(!in_array($path_split[0], $this->ignore_dirs)) {
      if($dir_depth > 0) {
        $export_path .= implode('/', $path_split);

        mkdir($export_path, 0777, TRUE);

        for($i = 0; $i < $dir_depth; $i++)
          $path_prefix .= '../';
      }

      $cached = $this->clean_cached($path_prefix, $output);

      $this->save_file($export_path . '/' . $file_name, $cached);
    }
  }

  private function save_file($file_path, $input) {
    $file = fopen($file_path, 'w');

    fwrite($file, $input);
    fclose($file);
  }

  private function clean_cached($path_prefix, $cached) {
    $base_path_quoted = preg_quote(BASE_PATH == '/' ? '/' : BASE_PATH . '/', '/');

    //$cached = preg_replace('/href="(' . $base_path_quoted . ')((\/*\w*)*(.css))"/', 'href="' . $path_prefix . '$2"', $cached); // <link href='*.css'
    $cached = preg_replace('/href="(' . $base_path_quoted . ')(.*.css)"/', 'href="' . $path_prefix . '$2"', $cached); // <link href='*.css'
    $cached = preg_replace('/href="(' . $base_path_quoted . ')"/', 'href="' . $path_prefix . 'index.html"', $cached); // change root to index
    $cached = preg_replace('/href="(' . $base_path_quoted . ')([\/a-zA-z0-9-]*)"/', 'href="' . $path_prefix . '$2.html"', $cached); // all href
    $cached = preg_replace('/src="(' . $base_path_quoted . ')/', 'src="' . $path_prefix, $cached); // src assets
    $cached = preg_replace('/url\((' . $base_path_quoted . ')((\/*\w*\.*\w*)*)\)/', 'url(' . $path_prefix . '$2)', $cached); // inline css url

    return $cached;
  }

  private function request_path($uri) {
    switch($uri) {
      case "/":
        return 'index';
      default:
        $uri = preg_replace("/^\//", "", $uri); // remove slash if first character
        // $uri = preg_replace("/\\/$/", "/index", $uri); // if last char is slash, replace by /index

        return $uri;
    }
  }
}
