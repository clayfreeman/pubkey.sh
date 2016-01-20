<?php
  /**
   * @file htmlutils.php
   *
   * This file exposes functions useful for HTML output and sanitization
   */

  /**
   * @brief HTML Dump
   *
   * Dumps a given variable to the screen in a web browser friendly way
   *
   * @param item The item to dump to the web browser
   */
  function html_dump($item) {
    return "<div style='font-family: Courier;'><pre>".
      html_encode(var_export($item, true))."</pre></div>";
  }

  /**
   * @brief HTML Encode
   *
   * Encodes the given contents to be output-friendly in HTML contexts
   *
   * @param text The text in which to encode
   *
   * @return A string with the encoded text
   */
  function html_encode($text) {
    return htmlspecialchars($text, ENT_HTML401 | ENT_QUOTES);
  }
