<?php
  /**
   * @file      htmlutils.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * This file exposes functions useful for HTML output and sanitization
   */

  // Enforce strict types for this file
  declare(strict_types=1);

  /**
   * @brief HTML Dump
   *
   * Dumps a given variable to the screen in a web browser friendly way
   *
   * @param item The item to dump to the web browser
   */
  function html_dump($item) {
    return '<div style=\'font-family: Courier;\'><pre>'.
      html_encode(var_export($item, true)).'</pre></div>';
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
  function html_encode(string $text): string {
    return htmlspecialchars($text, ENT_HTML401 | ENT_QUOTES);
  }
