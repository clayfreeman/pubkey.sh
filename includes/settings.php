<?php
  /**
   * @file settings.php
   *
   * This file serves as a non-public location to setup any requried settings
   * used by the application
   */

  // Configure the database
  \ORM::configure('sqlite:'.__PRIVATEROOT__.'/data/'.
    basename(__PRIVATEROOT__).'.db');

  // The time (in seconds) that it takes for a session to expire
  define('__SESSIONEXPIRE__', 3600);

  // The root domain of the application
  define('__DOMAIN__', 'pubkey.sh');
