<?php
  /**
   * @file      Page.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * Defines common functionality for all pages
   */

  namespace Views;

  class Page {
    public static function show($title, $contents) {
      // Load and flush the Page template
      ob_start();
      require(__PRIVATEROOT__.'/templates/Page.php');
      ob_end_flush();
    }
  }
