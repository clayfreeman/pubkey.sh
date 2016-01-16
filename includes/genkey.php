<?php
  /**
   * @file genkey.php
   *
   * Used for generating a 16-byte hexadecimal string value for use when
   * encrypting the hashes used by `\ParagonIE\PasswordLock\PasswordLock`
   */

  $key = array();
  for ($i = 0; $i < 16; ++$i)
    $key[] = '\\x'.strtoupper(dechex(rand(0, 255)));
  echo implode($key)."\n";
