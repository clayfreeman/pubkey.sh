<?php
  /**
   * @file Page.php
   *
   * Defines common functionality for all pages
   */

  namespace Views;

  class Page {
    protected static $menu = array(
      '/'         => 'Home',
      '/register' => '/register',
      '/login'    => '/login'
    );

    protected static function generateMenu() {
      $menu = null;
      foreach (self::$menu as $location => $name)
        $menu .= '<li><a href="'.urlencode($location).'">'.
          htmlspecialchars(trim($name), ENT_HTML401 | ENT_QUOTES)."</a></li>\n";
      return $menu;
    }

    public static function show($title, $contents, $shownav = true,
        $indent = 2) {
      // Adjust the indent level of the contents
      $indentText = str_repeat('  ', $indent);
      $contents   = $indentText.implode("\n".$indentText, explode("\n",
        trim($contents)))."\n";
      // Generate the menu
      $menu = self::generateMenu();
      // Load and flush the Page template
      ob_start();
      require(__PRIVATEROOT__.'/templates/Page.php');
      ob_end_flush();
    }
  }
