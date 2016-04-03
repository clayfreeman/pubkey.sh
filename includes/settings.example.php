<?php
  /**
   * @file      settings.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * This file serves as a non-public location to setup any requried settings
   * used by the application
   */

  // Configure the database
  \ORM::configure('sqlite:'.__PRIVATEROOT__.'/data/site.db');

  // The time (in seconds) that it takes for a session to expire
  define('__SESSIONEXPIRE__', 3600);

  // The root domain of the application (used for cookie security restrictions)
  define('__DOMAIN__', 'example.org');

  // The AES encryption key used for storing password information
  // NOTE: Generate a key with `includes/genkey.php`
  define('__PASSKEY__', "16-byte password");
