<?php
  /**
   * @file      Index.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * Defines functionality for the Index page
   */

  namespace Views;

  class Index {
    public static function show($_ = null) {
      global $twig;
      // Load and render the Index template
      ob_start();
      echo $twig->render('Index.twig', array(
        'message' => is_string($_) ? $_ : null,
        'path'    => '/'
      ));
      ob_end_flush();
    }
  }
