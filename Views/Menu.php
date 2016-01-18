<?php
  /**
   * @file Menu.php
   *
   * Defines functionality for the Menu section
   */

  namespace Views;

  class Menu {
    protected static $items = array(
      '/'         => array(
        'name'    => 'Home',
        'anon'    => true,
        'user'    => true
      ),
      '/user'     => array(
        'name'    => 'My Account',
        'anon'    => false,
        'user'    => true
      ),
      '/login'    => array(
        'name'    => 'Login',
        'anon'    => true,
        'user'    => false
      ),
      '/register' => array(
        'name'    => 'Register',
        'anon'    => true,
        'user'    => false
      )
    );

    protected static function renderItem($path, $name, $active) {
      return '<li'.($active ? ' class="uk-active"' : null).'><a href="'.$path.
        '">'.htmlspecialchars(trim($name), ENT_HTML401 | ENT_QUOTES).
        '</a></li>';
    }

    public static function render($current) {
      // Determine if the current visitor is anonymous or a user
      $anon = !is_object(\Controllers\User::getCurrent());
      $user = !$anon;
      // Iterate over each menu item to decide how it's rendered
      $menu = null;
      foreach (self::$items as $path => $info) {
        // Determine if the current page matches this
        $active    = false;
        if ($path == $current)
          $active  = true;
        // Skip this menu item if conditions are not appropriate
        if ($anon && !$info['anon']) continue;
        if ($user && !$info['user']) continue;
        // Render the menu item and add it to the menu
        $menu .= self::renderItem($path, $info['name'], $active)."\n";
      }
      // Load and render the Menu template
      ob_start();
      require(__PRIVATEROOT__.'/templates/Menu.php');
      $contents = ob_get_contents();
      ob_end_clean();
      // Return the Menu template
      return $contents;
    }
  }
