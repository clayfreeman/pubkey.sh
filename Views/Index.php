<?php
  /**
   * @file Index.php
   *
   * Defines functionality for the Index page
   */

  namespace Views;

  class Index {
    public static function show() {
      // Load and flush the Index template
      ob_start();
      require(__PRIVATEROOT__.'/templates/Index.php');
      ob_end_flush();
    }
  }
