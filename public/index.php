<?php
  /**
   * @file index.php
   *
   * This file serves as the global entry point to the application
   */

  // Require the site bootstrap file
  require_once(__DIR__.'/../includes/bootstrap.php');

  // Setup a new instance of the Slim framework
  $app = new \Slim\App;

  // Define route to homepage
  $app->get ('/',      '\\Views\\Index::show');
  // Define route to login form
  $app->get ('/login', '\\Views\\Login::show');

  // // Define route to login processing
  // $app->post('/login', '\\Controllers\\Login::submit');

  // Run Slim app instance
  $app->run();
