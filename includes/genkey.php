<?php
  /**
   * @file      genkey.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   This project is released under the GNU General Public License
   *            v3 (GPL-3.0)
   *
   * Used for generating a 16-byte hexadecimal string value for use when
   * encrypting the hashes used by `\ParagonIE\PasswordLock\PasswordLock`
   */

  $key = array();
  for ($i = 0; $i < 16; ++$i) {
    $hex   = strtoupper(dechex(rand(0, 255)));
    $hex   = str_repeat('0', 2 - strlen($hex)).$hex;
    $key[] = '\\x'.$hex;
  }
  echo implode($key)."\n";
