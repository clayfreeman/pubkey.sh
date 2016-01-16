<?php
  /**
   * @file Index.php
   *
   * Defines functionality for the Index page
   */

  namespace Views;

  class Index {
    protected static $title = "Index";

    public static function show() {
      // Load and render the Index template
      ob_start();
      require(__PRIVATEROOT__.'/templates/Index.php');
      $contents = ob_get_clean();
      // Render and show the Page template
      \Views\Page::show(self::$title, $contents);
    }
  }
