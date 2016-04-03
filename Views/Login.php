<?php
  /**
   * @file      Login.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * Defines functionality for the Login page
   */

  namespace Views;

  class Login {
    public static function show($_ = null) {
      // Load and render the Login template
      $contents = Template::render(__PRIVATEROOT__.'/templates/Login.html',
        array(
          'error' => is_string($_) ? \Views\Message::render($_, 'danger') : null
        ));
      // Render and show the Page template
      \Views\Page::show('Login', $contents);
    }
  }
