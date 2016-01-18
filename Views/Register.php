<?php
  /**
   * @file Register.php
   *
   * Defines functionality for the Register page
   */

  namespace Views;

  class Register {
    protected static $title = "Register";

    protected static function prepareError($error) {
      // Ensure the passed variable is a string
      if (is_string($error)) {
        // Encode the message for embed in an HTML document
        $error = '<p>'.htmlspecialchars(trim($error), ENT_HTML401 |
          ENT_QUOTES).'</p>';
        $error = "<a class=\"uk-alert-close uk-close\" href></a>\n".$error;
        $error = "<div class=\"uk-alert uk-alert-danger uk-text-left\" ".
          "data-uk-alert>\n".indent($error, 1)."</div>";
      }
      else
        $error = null;
      return $error;
    }

    protected static function prepareInfo($info) {
      // Ensure the passed variable is a string
      if (is_string($info)) {
        // Encode the message for embed in an HTML document
        $info = '<p>'.htmlspecialchars(trim($info), ENT_HTML401 |
          ENT_QUOTES).'</p>';
        $info = "<a class=\"uk-alert-close uk-close\" href></a>\n".$info;
        $info = "<div class=\"uk-alert uk-text-left\" data-uk-alert>\n".
          indent($info, 1)."</div>";
      }
      else
        $info = null;
      return $info;
    }

    public static function show($_ = null) {
      // Prepare the error for display (if one was provided)
      $error = is_string($_) ? self::prepareError($_) : self::prepareInfo(
        'Submission will be enabled when your password strength '.
        'is sufficient.');
      // Load and render the Register template
      ob_start();
      require(__PRIVATEROOT__.'/templates/Register.php');
      $contents = ob_get_contents();
      ob_end_clean();
      // Render and show the Page template
      \Views\Page::show(self::$title, $contents, false);
    }
  }
