<?php
  /**
   * @file session.php
   *
   * A straightforward and secure interface for session data management
   */

  /**
   * @brief Begin Session
   *
   * This wrapper for `session_start()` ensures the security of the session
   * cookie in the browser of each client by doing the following:
   *
   *   - Restricting cookie validity to `__SESSIONEXPIRE__`
   *   - Restricting cookie to `__DOMAIN__`
   *   - Restricting cookie to secure connections
   *   - Restricting cookie to HTTP contexts
   *   - Establishing the initial IP address and user agent of the client
   *
   * @remarks Constant values `__SESSIONEXPIRE__` and `__DOMAIN__` are defined
   * in the `includes/session.php` file in the project's root directory
   */
  function beginSession() {
    if (session_status() == PHP_SESSION_NONE) {
      // Begin the session
      session_start();
      // Set the security restrictions on the session cookie as outlined above
      session_set_cookie_params(__SESSIONEXPIRE__, '/', __DOMAIN__, true, true);
      // If this is a fresh session, place the IP address and user agent of the
      // user in the session
      if (count($_SESSION) == 0)
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
