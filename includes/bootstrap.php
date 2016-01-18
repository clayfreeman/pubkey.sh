<?php
  /**
   * @file bootstrap.php
   *
   * This file loads the required files and defines the required constants for
   * the application to run
   */

  // Setup constants for important directories
  define('__PRIVATEROOT__', realpath(__DIR__.'/..'));
  define('__PUBLICROOT__',  __PRIVATEROOT__.'/public');

  // Require the composer autoload
  require_once(__PRIVATEROOT__.'/vendor/autoload.php');

  // Require the class autoload function
  require_once(__PRIVATEROOT__.'/includes/autoload.php');

  // Require the settings file
  require_once(__PRIVATEROOT__.'/includes/settings.php');

  // Require the htmldump file
  require_once(__PRIVATEROOT__.'/includes/htmldump.php');

  // Require the indent file
  require_once(__PRIVATEROOT__.'/includes/indent.php');

  // Require the session file
  require_once(__PRIVATEROOT__.'/includes/session.php');
