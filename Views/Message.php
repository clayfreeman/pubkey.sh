<?php
  /**
   * @file Message.php
   *
   * Defines functionality for the Message generator
   */

  namespace Views;

  class Message {
    public static function render($message, $type = null, $closable = true,
        $encode = true) {
      // Optionally encode the message for display in the alert
      if ($encode)
        $message = html_encode(trim($message));
      // Ensure the passed variable is a string
      $output = null;
      if (is_string($message)) {
        // Optionally flag this alert as an error
        $output  = indent('<div class="'.($type != null ? 'uk-alert-'.$type :
          null).' uk-alert" data-uk-alert>');
        // If the message should be closable, print the close link
        $output .= $closable ? indent('<a class="uk-alert-close uk-close" '.
          'href></a>', 1) : null;
        // Place the message in a paragraph
        $output .= indent('<p>'.$message.'</p>', 1);
        $output .= indent("</div>");
      }
      return $output;
    }
  }
