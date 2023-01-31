<?php

  function relpath($from, $to) {

    $from = str_replace('\\', '/', $from);
    $to   = str_replace('\\', '/', $to);

    $from = is_dir($from) ? rtrim($from, '/') . '/' : $from;
    $to   = is_dir($to)   ? rtrim($to, '/') . '/'   : $to;

    $from   = explode('/', $from);
    $to     = explode('/', $to);
    $relPath  = $to;

    foreach ($from as $depth => $dir) {
      if ($dir === $to[$depth]) {
        array_shift($relPath);
      } else {
        $remaining = count($from) - $depth;
        if ($remaining > 1) {
          $padLength = (count($relPath) + $remaining - 1) * -1;
          $relPath = array_pad($relPath, $padLength, '..');
          break;
        } else {
          $relPath[0] = './' . $relPath[0];
        }
      }
    }
    return implode('/', $relPath);
  }

  require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.inc.php');
  require_once($_SERVER['DOCUMENT_ROOT'].'/includes/compatibility.inc.php');
  
  if (!class_exists('Less_Parser')) {
    require_once FS_DIR_APP . 'ext/Less/Autoloader.php';
    Less_Autoloader::register();
  }

  $requested_file = DOCUMENT_ROOT . parse_url($_GET['file'], PHP_URL_PATH);
  $is_minified_request = preg_match('#\.min\.css$#', $requested_file) ? true : false;

  $css_file = preg_replace('#((\.min)?\.css)$#', '.css', $requested_file);
  $css_minified_file = preg_replace('#(\.css)$#', '.min.css', $css_file);

  $less_file = preg_replace('#(/css/)#', '/less/', $requested_file);
  $less_file = preg_replace('#((\.min)?\.css)$#', '.less', $less_file);

  $scss_file = preg_replace('#(\/css\/)#', '/scss/', $requested_file);
  $scss_file = preg_replace('#((\.min)?\.css)$#', '.scss', $scss_file);

//   var_dump($css_file);

  var_dump($less_file);
//   var_dump($scss_file);
  
  try {

    switch (true) {

    // Build .css and/or .min.css from .scss
      case file_exists($scss_file):

        require_once(FS_DIR_APP . 'ext/scssphp/scss.inc.php');

        $scss = new ScssPhp\ScssPhp\Compiler();

        $scss->setImportPaths(dirname($scss_file));

     // Build CSS
        if (file_exists($css_file)) {
          $css = $scss->compile(file_get_contents($scss_file));
          file_put_contents($css_file, $css);
        }

      // Build minified CSS
        if (file_exists($css_minified_file)) {
          $scss->setFormatter("ScssPhp\\ScssPhp\\Formatter\\Compressed");
          $css = $scss->compile(file_get_contents($scss_file));
          file_put_contents($css_minified_file, $css);
        }

        break;

    // Build .css and/or .min.css from .less
      case file_exists($less_file):

      // Build CSS
        if (file_exists($css_file)) {
          $map_file = $css_file.'.map';

          $less = new Less_Parser([
            'compress' => false,
            'sourceMap' => true,
            'sourceMapWriteTo' => $map_file,
            'sourceMapURL' => basename($map_file),
            'sourceMapBasepath' => dirname($less_file),
            'sourceMapRootpath' => dirname(relpath($map_file, $less_file)),
            'cache_dir' => FS_DIR_APP . 'cache/',
          ]);

          $less->parseFile($less_file);
          $css = $less->getCss();

          file_put_contents($css_file, $css);
        }

      // Build minified CSS
        if (file_exists($css_minified_file)) {

          $map_file = $css_minified_file.'.map';

          $less = new Less_Parser([
            'compress' => true,
            'sourceMap' => true,
            'sourceMapWriteTo' => $map_file,
            'sourceMapURL' => basename($map_file),
            'sourceMapBasepath' => dirname($less_file),
            'sourceMapRootpath' => dirname(relpath($map_file, $less_file)),
            'cache_dir' => FS_DIR_APP . 'cache/',
          ]);

          $less->parseFile($less_file);
          $css = $less->getCss();

          file_put_contents($css_minified_file, $css);
        }

        break;

    // Build .min.css from .css
      case (file_exists($css_file) && file_exists($css_minified_file)):

        $map_file = $css_file.'.map';

        $less = new Less_Parser([
          'compress' => preg_match('#\.min\.css$#', $requested_file) ? true : false,
          'sourceMap' => true,
          'sourceMapWriteTo' => $map_file,
          'sourceMapURL' => basename($map_file),
          'sourceMapBasepath' => dirname($css_file),
          'sourceMapRootpath' => dirname(relpath($map_file, $css_file)),
          'cache_dir' => FS_DIR_APP . 'cache/',
        ]);

        $less->parseFile($css_file);
        $css = $less->getCss();

        file_put_contents($css_minified_file, $css);

        break;
    }

  } catch (Exception $e) {
    http_response_code(404);
    die($e->getMessage());
  }

  if (!file_exists($requested_file)) {
    http_response_code(404);
    die('File Not Found');
  }

  ob_start('ob_gzhandler');

  header('Content-Type: text/css');
  header('Expires: ' . gmdate('r', strtotime('+7 days')));

  echo file_get_contents($requested_file);
