<?php
  /**
   * @file Register.php
   *
   * Defines functionality for the Register page
   */

  namespace Views;

  class Register {
    public static function show($_ = null) {
      // Prepare the error for display (if one was provided)
      $error = is_string($_) ?
        \Views\Message::render($_, 'danger') :
        \Views\Message::render('Submission will be enabled when your password '.
          'strength is sufficient.<br /><br />'.
          '<code id="password-status">0</code> / <code>4</code><br />'.
          '<span class="uk-text-small">Strength</span>',
          null, false, false);
      // Load and render the Register template
      ob_start();
      require(__PRIVATEROOT__.'/templates/Register.php');
      $contents = ob_get_contents();
      ob_end_clean();
      // Render and show the Page template
      \Views\Page::show('Register', $contents);
    }
  }
