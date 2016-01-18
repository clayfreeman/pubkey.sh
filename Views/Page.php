<?php
  /**
   * @file Page.php
   *
   * Defines common functionality for all pages
   */

  namespace Views;

  class Page {
    public static function show($title, $contents) {
      // Adjust the indent level of the contents
      $contents = indent($contents, 2);
      // Load and flush the Page template
      ob_start();
      require(__PRIVATEROOT__.'/templates/Page.php');
      ob_end_flush();
    }
  }
