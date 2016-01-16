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
    return "<div style='font-family: Courier;'>".nl2br(str_ireplace(' ',
      '&nbsp;', var_export(json_encode($item, JSON_PRETTY_PRINT),
      true)))."</div>";
  }
