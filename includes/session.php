<?php
  /**
   * @file session.php
   *
   * A straightforward interface for session data management
   */

  /**
   * @brief Get Session
   *
   * Retrieves a requested key from the session
   *
   * @param name    The name of the key to fetch from the session
   * @param default A default value to return if the key doesn't exist
   */
  function getSession($name, $default = false) {
    if (session_status() == PHP_SESSION_NONE) session_start();
    return (isset($_SESSION[$name]) ? $_SESSION[$name] : $default);
  }

  /**
   * @brief Put Session
   *
   * Places a value in the requested key in the session
   *
   * @param name  The name of the key to write in the session
   * @param value The value to place in the session
   */
  function putSession($name, $value) {
    if (session_status() == PHP_SESSION_NONE) session_start();
    $_SESSION[$name] = $value;
  }
