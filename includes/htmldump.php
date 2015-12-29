<?php
  /**
   * @file htmldump.php
   *
   * This file exposes a function useful for debugging purposes
   */

  /**
   * @brief HTML Dump
   *
   * Dumps a given variable to the screen in a web browser friendly way
   *
   * @param item The item to dump to the web browser
   */
  function html_dump($item) {
    return nl2br(str_ireplace(' ', '&nbsp;', var_export($item, true)));
  }
