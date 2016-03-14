<?php
  /**
   * @file      indent.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   This project is released under the GNU General Public License
   *            v3 (GPL-3.0)
   *
   * File containing the `indent(...)` function responsible for prettying HTML
   * output in a composite template system
   */

  /**
   * @brief Indent
   *
   * @param contents The contents to indent
   * @param level    The level in which to indent by two spaces
   *
   * @return A string containing the indented contents
   */
  function indent($contents, $level = 0) {
    // Adjust the indent level of the contents
    $indentText = str_repeat('  ', $level);
    $contents   = $indentText.trim(implode("\n".$indentText, explode("\n",
      trim($contents))))."\n";
    return strlen(trim($contents)) > 0 ? $contents : null;
  }
