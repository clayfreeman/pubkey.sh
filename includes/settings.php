<?php
  /**
   * @file settings.php
   *
   * This file serves as a non-public location to setup any requried settings
   * used by the application
   */

  // Configure the database
  ORM::configure('sqlite:'.__PRIVATEROOT__.'/data/'.
    basename(__PRIVATEROOT__).'.db');
