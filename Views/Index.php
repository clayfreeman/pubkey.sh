<?php
  /**
   * @file Index.php
   *
   * Defines functionality for the Index page
   */

  namespace Views;

  class Index {
    public static function show() {
      // Render the Menu
      $menu = \Views\Menu::render('/');
      // Load and render the Index template
      ob_start();
      require(__PRIVATEROOT__.'/templates/Index.php');
      $contents = ob_get_contents();
      ob_end_clean();
      // Render and show the Page template
      \Views\Page::show('Home', $contents);
    }
  }
