<?php
  /**
   * @file Login.php
   *
   * Defines functionality for the Login page
   */

  namespace Views;

  class Login {
    protected static $title = "Login";

    protected static function prepareError($error) {
      // Ensure the passed variable is a string
      if (is_string($error)) {
        // Encode the message for embed in an HTML document
        $error = '<p>'.htmlspecialchars(trim($error), ENT_HTML401 |
          ENT_QUOTES).'</p>';
        $error = "<a class=\"uk-alert-close uk-close\" href></a>\n".$error;
        $error = "<div class=\"uk-alert uk-alert-danger uk-text-left\" ".
          "data-uk-alert>\n".indent($error, 1)."</div>\n";
      }
      else
        $error = null;
      return $error;
    }

    public static function show($error = null) {
      // Prepare the error for display (if one was provided)
      $error = is_string($_) ? self::prepareError($_) : null;
      // Load and render the Login template
      ob_start();
      require(__PRIVATEROOT__.'/templates/Login.php');
      $contents = ob_get_contents();
      ob_end_clean();
      // Render and show the Page template
      \Views\Page::show(self::$title, $contents, false);
    }
  }
