<?php
  /**
   * @file Page.php
   *
   * Defines common functionality for all pages
   */

  namespace Views;

  class Page {
    protected static function indent($contents, $level) {
      // Adjust the indent level of the contents
      $indentText = str_repeat('  ', $level);
      $contents   = $indentText.implode("\n".$indentText, explode("\n",
        trim($contents)))."\n";
      return $contents;
    }

    public static function show($title, $contents) {
      // Adjust the indent level of the contents
      $contents = self::indent($contents, 2);
      // Load and flush the Page template
      ob_start();
      require(__PRIVATEROOT__.'/templates/Page.php');
      ob_end_flush();
    }
  }
