<?php
  /**
   * @file      index.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * This file serves as the global entry point to the application
   */

  // Refuse to load if PHP is older than 5.5.3
  if (version_compare(PHP_VERSION, '5.5.3') < 0)
    die('This application requires at least PHP 5.5.3 to run.');

  // Refuse to load over plaintext connections
  if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on")
    die('This application cannot be loaded over plaintext transports.');

  // Require the site bootstrap file
  require_once(__DIR__.'/../includes/bootstrap.php');

  // Define application route information
  $routes = array(
    '/' => array(
      // The home page should be accessible by everyone from the menu
      'menu'    => array('anon' => true, 'user' => true),
      'methods' => array(
        'get'  => '\\Views\\Index::show'
      ),
      'title'   => 'Home'
    ),
    '/email/available' => array(
      // Private API endpoints should not be accessible from the menu
      'menu'    => array('anon' => false, 'user' => false),
      'methods' => array(
        'post' => '\\Controllers\\User::emailAvailable'
      ),
      'title'   => null
    ),
    '/login' => array(
      // The login page should be restricted to anonymous users from the menu
      'menu'    => array('anon' => true, 'user' => false),
      'methods' => array(
        'get'  => '\\Views\\Login::show',
        'post' => '\\Controllers\\User::login'
      ),
      'title'   => 'Login'
    ),
    '/register' => array(
      // The register page should be restricted to anonymous users from the menu
      'menu'    => array('anon' => true, 'user' => false),
      'methods' => array(
        'get'  => '\\Views\\Register::show',
        'post' => '\\Controllers\\User::register'
      ),
      'title'   => 'Register'
    ),
    '/user/available' => array(
      // Private API endpoints should not be accessible from the menu
      'menu'    => array('anon' => false, 'user' => false),
      'methods' => array(
        'post' => '\\Controllers\\User::userAvailable'
      ),
      'title'   => null
    )
  );

  // Setup a new instance of the Twig framework
  $loader = new Twig_Loader_Filesystem(__PRIVATEROOT__.'/templates');
  $twig   = new Twig_Environment($loader, array('debug' => true));
  $twig->addGlobal('routes', $routes);
  $twig->addGlobal('user',   \Controllers\User::fetchCurrent());
  $twig->addExtension(new Twig_Extension_Debug());

  // Setup a new instance of the Slim framework
  $app = new \Slim\App;

  // Unset the Slim framework error handler during development
  unset($app->getContainer()['errorHandler']);

  // Redirect trailing slash to non-trailing slash
  $app->add(function($request, $response, $next) {
    $uri  = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
      // Permanently redirect paths with a trailing slash to their non-trailing
      // counterpart
      $uri = $uri->withPath(substr($path, 0, -1));
      return $response->withRedirect($uri, 301);
    }
    return $next($request, $response);
  });

  foreach($routes as $path => $info) {
    // Register each method and class with the Slim framework
    foreach ($info['methods'] as $method => $class)
      $app->$method($path, $class);
  }

  // Run Slim app instance
  $app->run();
