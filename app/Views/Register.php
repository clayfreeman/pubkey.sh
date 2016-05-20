<?php
  /**
   * @file      Register.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * Defines functionality for the Register page
   */

  namespace Views;

  class Register {
    public static function show($_ = null) {
      global $twig;
      // Load and render the Login template
      ob_start();
      echo $twig->render('Register.twig', array(
        'error' => is_string($_) ? $_ : null
      ));
      ob_end_flush();
    }
  }
