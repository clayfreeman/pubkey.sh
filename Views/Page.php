<?php
  /**
   * @file Page.php
   *
   * Defines common functionality for all pages
   */

  namespace Views;

  class Page {
    public static function show($title, $contents, $indent = 2) {
      // Adjust the indent level of the contents
      $indentText = str_repeat('  ', $indent);
      $contents   = $indentText.implode("\n".$indentText, explode("\n",
        rtrim($contents)));
      // Load and flush the Page template
      ob_start();
      require(__PRIVATEROOT__.'/templates/Page.php');
      echo ob_get_clean();
    }
  }
