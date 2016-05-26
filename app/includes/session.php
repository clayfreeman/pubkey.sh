<?php
  /**
   * @file      session.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * A straightforward and secure interface for session data management
   */

  // Enforce strict types for this file
  declare(strict_types=1);

  /**
   * @brief Begin Session
   *
   * This wrapper for `session_start(...)` ensures the security of the session
   * cookie in the browser of each client by doing the following:
   *
   *   - Genericizing the name of the cookie to 'token'
   *   - Restricting cookie scope to `__DOMAIN__`
   *   - Restricting cookie to HTTP contexts (no JavaScript access, etc.)
   *   - Restricting cookie validity to `__SESSIONEXPIRE__` seconds
   *   - Restricting cookie to secure connections
   *   - Making use of `/dev/urandom` to generate 512 bytes of entropy per token
   *   - Using the 'whirlpool' hash function to generate a ~128 byte token
   *   - Restricting sessions to only cookies (no session IDs in query)
   *   - Generating a new ID for uninitialized sessions on page load
   *   - Establishing the initial IP address and user agent of the client
   *
   * @remarks Constant values `__SESSIONEXPIRE__` and `__DOMAIN__` are defined
   * in the `includes/session.php` file in the project's root directory
   */
  function beginSession() {
    if (session_status() == PHP_SESSION_NONE) {
      // Set the appropriate restraints on the session
      session_name('token');
      session_set_cookie_params(__SESSIONEXPIRE__, '/', __DOMAIN__, true, true);
      // Begin the session (hopefully with the specified configuration)
      session_start([
        'entropy_file'            => '/dev/urandom',
        'entropy_length'          => 512,
        'hash_function'           => 'whirlpool',
        'hash_bits_per_character' => 4,
        'use_cookies'             => 1,
        'use_only_cookies'        => 1,
        'use_strict_mode'         => 1,
        'use_trans_sid'           => 0
      ]);
      // Renew the session token each time it is resumed
      session_regenerate_id();
      // If this is a fresh session, place the IP address and user agent of the
      // user in the session
      if (!isset($_SESSION['ip']) && !isset($_SESSION['ua'])) {
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
      }
    }
  }

  /**
   * @brief Kill Session
   *
   * Safely destroys the current session (including session data)
   */
  function killSession() {
    // Unset the session in the standard way
    $cookie = session_name();
    session_unset();
    // Clear the cookie used for the session (according to OWASP guidelines)
    setcookie($cookie, "", 1);
    unset($_COOKIE[$cookie]);
  }

  /**
   * @brief Get Session
   *
   * Retrieves a requested key from the session
   *
   * @param name    The name of the key to fetch from the session
   * @param default A default value to return if the key doesn't exist
   *
   * @return Either the value stored in the session, or the provided default
   */
  function getSession($name, $default = null) {
    beginSession();
    return $_SESSION[$name] ?? $default;
  }

  /**
   * @brief Put Session
   *
   * Places a value in the requested key in the session
   *
   * @param name  The name of the key to write in the session
   * @param value The value to place in the session
   *
   * @return The value provided to this function
   */
  function putSession($name, $value) {
    beginSession();
    if ($value !== null)
      $_SESSION[$name] = $value;
    else
      unset($_SESSION[$name]);
  }
