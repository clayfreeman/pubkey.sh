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
      global $twig;
      // Load and render the Login template
      ob_start();
      echo $twig->render('Login.html', array(
        'error' => is_string($_) ? $_ : null,
        'path'  => '/'
      ));
      ob_end_flush();
    }
  }
