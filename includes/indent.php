<?php
  /**
   * @file indent.php
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
    $contents   = trim($indentText.implode("\n".$indentText, explode("\n",
      trim($contents))));
    return strlen($contents) > 0 ? $contents."\n" : null;
  }
