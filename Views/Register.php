<?php
  /**
   * @file Register.php
   *
   * Defines functionality for the Register page
   */

  namespace Views;

  class Register {
    protected static $title = "Register";

    public static function show($error = null) {
      // Load and render the Register template
      ob_start();
      require(__PRIVATEROOT__.'/templates/Register.php');
      $contents = ob_get_contents();
      ob_end_clean();
      // Render and show the Page template
      \Views\Page::show(self::$title, $contents, false);
    }
  }
