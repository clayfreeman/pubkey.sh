<?php
  /**
   * @file      settings.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * This file serves as a non-public location to setup any requried settings
   * used by the application
   */

  // Enforce strict types for this file
  declare(strict_types=1);

  // Configure the database
  \ORM::configure(getenv('DATASOURCE_PATH'));
  if (strlen(trim(getenv('DATASOURCE_LOGIN'))) > 0)
    \ORM::configure('username', getenv('DATASOURCE_LOGIN'));
  if (strlen(trim(getenv('DATASOURCE_PASS'))) > 0)
    \ORM::configure('password', getenv('DATASOURCE_PASS'));

  // The time (in seconds) that it takes for a session to expire
  define('__SESSIONEXPIRE__', intval(getenv('SESSION_EXPIRE')));

  // The root domain of the application (used for cookie security restrictions)
  define('__DOMAIN__', getenv('SERVER_NAME'));

  // The encryption key file used for storing password information securely
  define('__HALITEKEY__', getenv('HALITE_KEYFILE'));

  // Attempt to generate an encryption key file if one is not present
  if (!file_exists(__HALITEKEY__))
    try { \ParagonIE\Halite\KeyFactory::save(
      \ParagonIE\Halite\KeyFactory::generateEncryptionKey(),
      __HALITEKEY__
    ); } catch (\Exception $e) { die(); }
