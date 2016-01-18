<?php
  /**
   * @file Message.php
   *
   * Defines functionality for the Message generator
   */

  namespace Views;

  class Message {
    public static function render($message, $type = null, $closable = true) {
      // Ensure the passed variable is a string
      if (is_string($message)) {
        // Optionally flag this alert as an error
        $message  = indent('<div class="'.($type != null ? 'uk-alert-'.$type :
          null).' uk-alert" data-uk-alert>');
        // If the message should be closable, print the close link
        $message .= indent($closable ? '<a class="uk-alert-close uk-close" '.
          'href></a>' : null, 1);
        // Encode the message in a paragraph
        $message .= indent('<p>'.htmlspecialchars(trim($message), ENT_HTML401 |
          ENT_QUOTES).'</p>', 1);
        $message .= indent("</div>");
      }
      else
        $message = null;
      return $message;
    }
  }
