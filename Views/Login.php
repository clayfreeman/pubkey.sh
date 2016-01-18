<?php
  /**
   * @file Login.php
   *
   * Defines functionality for the Login page
   */

  namespace Views;

  class Login {
    public static function show($_ = null) {
      // Prepare the error for display (if one was provided)
      $error = is_string($_) ? \Views\Message::render($_, 'danger') : null;
      // Load and render the Login template
      ob_start();
      require(__PRIVATEROOT__.'/templates/Login.php');
      $contents = ob_get_contents();
      ob_end_clean();
      // Render and show the Page template
      \Views\Page::show('Login', $contents);
    }
  }
