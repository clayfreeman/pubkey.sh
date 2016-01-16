<?php
  /**
   * @file Login.php
   *
   * Defines functionality for the Login page
   */

  namespace Views;

  class Login {
    protected static $title = "Login";

    public static function show() {
      // Load and render the Login template
      ob_start();
      require(__PRIVATEROOT__.'/templates/Login.php');
      $contents = ob_get_contents();
      ob_end_clean();
      // Render and show the Page template
      \Views\Page::show(self::$title, $contents, false);
    }
  }
