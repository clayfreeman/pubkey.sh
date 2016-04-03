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

  // Setup a new instance of the Slim framework
  $app = new \Slim\App;

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

  // Define route to homepage
  $app->get('/', '\\Views\\Index::show');
  // Define route to login form
  $app->get('/login', '\\Views\\Login::show');
  // Define route to register form
  $app->get('/register', '\\Views\\Register::show');

  // Define route to login processing
  $app->post('/login', '\\Controllers\\User::login');
  // Define route to register processing
  $app->post('/register', '\\Controllers\\User::register');
  // Define route to check username availability
  $app->post('/email/available', '\\Controllers\\User::emailAvailable');
  // Define route to check username availability
  $app->post('/user/available', '\\Controllers\\User::userAvailable');

  // Unset the Slim framework error handler during development
  unset($app->getContainer()['errorHandler']);

  // Run Slim app instance
  $app->run();
