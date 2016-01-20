<?php
  /**
   * @file session.php
   *
   * A straightforward and secure interface for session data management
   */

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
      // Begin the session and set the appropriate security restrictions
      session_start(array(
        'name'                    => 'token',
        'cookie_domain'           => __DOMAIN__,
        'cookie_httponly'         => true,
        'cookie_lifetime'         => __SESSIONEXPIRE__,
        'cookie_path'             => '/',
        'cookie_secure'           => true,
        'entropy_file'            => '/dev/urandom',
        'entropy_length'          => 512,
        'hash_function'           => 'whirlpool',
        'hash_bits_per_character' => 4,
        'use_cookies'             => true,
        'use_only_cookies'        => true,
        'use_strict_mode'         => true,
        'use_trans_sid'           => false
      ));
      // If this is a fresh session, place the IP address and user agent of the
      // user in the session
      if (count($_SESSION) == 0) {
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
      }
    }
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
  function getSession($name, $default = false) {
    beginSession();
    return (isset($_SESSION[$name]) ? $_SESSION[$name] : $default);
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
    $_SESSION[$name] = $value;
  }
