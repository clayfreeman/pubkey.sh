<?php
  /**
   * @file      index.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * This file serves as the global entry point to the application
   */

  // Enforce strict types for this file
  declare(strict_types=1);

  // Refuse to load if PHP is older than 7.0
  if (version_compare(PHP_VERSION, '7.0') < 0)
    die('This application requires at least PHP 7.0 to run.');

  // Refuse to load over plaintext connections
  if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on')
    die('This application cannot be loaded over plaintext transports.');

  // Require the site bootstrap file
  require_once(__DIR__.'/../includes/bootstrap.php');

  // Define application route information
  $routes = [
    '/' => [
      // The home page should be accessible by everyone from the menu
      'menu'    => ['anon' => true, 'user' => true],
      'methods' => [
        'get'   => '\\Views\\Index::show'
      ],
      'title'   => 'Home'
    ],
    '/api/email/available' => [
      // Private API endpoints should not be accessible from the menu
      'menu'    => ['anon' => false, 'user' => false],
      'methods' => [
        'post'  => '\\Controllers\\User::emailAvailable'
      ],
      'title'   => null
    ],
    '/api/user/available' => [
      // Private API endpoints should not be accessible from the menu
      'menu'    => ['anon' => false, 'user' => false],
      'methods' => [
        'post'  => '\\Controllers\\User::userAvailable'
      ],
      'title'   => null
    ],
    '/app/user' => [
      // The account page should be restricted to logged in users from the menu
      'menu'    => ['anon' => false, 'user' => true],
      'methods' => [
        'get'   => '\\Views\\User::show'
      ],
      'title'   => 'Account'
    ],
    '/app/login' => [
      // The login page should be restricted to anonymous users from the menu
      'menu'    => ['anon' => true, 'user' => false],
      'methods' => [
        'get'   => '\\Views\\Login::show',
        'post'  => '\\Controllers\\User::login'
      ],
      'title'   => 'Login'
    ],
    '/app/logout' => [
      // The logout page should be restricted to logged in users from the menu
      'menu'    => ['anon' => false, 'user' => true],
      'methods' => [
        'get'   => function(
                     ServerRequestInterface $request,
                     ResponseInterface      $response) {
                       // Perform the user logout method
                       \Controllers\User::logout();
                       // Inform the user that they're logged out
                       putSession('message', 'You have successfully logged '.
                         'out.');
                       // Redirect the user to the home page
                       return $response->withRedirect('/');
                     }
      ],
      'title'   => 'Logout'
    ],
    '/app/register' => [
      // The register page should be restricted to anonymous users from the menu
      'menu'    => ['anon' => true, 'user' => false],
      'methods' => [
        'get'   => '\\Views\\Register::show',
        'post'  => '\\Controllers\\User::register'
      ],
      'title'   => 'Register'
    ],
    '/{username}/{key}' => [
      // All other endpoints should represent a username and key URI
      'menu'    => ['anon' => false, 'user' => false],
      'methods' => [
        'get'   => '\\Controllers\\Pubkey::script'
      ],
      'title'   => null
    ]
  ];

  // Setup a new instance of the Twig framework
  $loader = new Twig_Loader_Filesystem(__PRIVATEROOT__.'/templates');
  $twig   = new Twig_Environment($loader, ['debug' => true]);
  $twig->addFilter(new Twig_SimpleFilter('eshell', 'escapeshellarg'));
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
