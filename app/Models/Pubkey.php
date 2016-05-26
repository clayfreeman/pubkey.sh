<?php
  /**
   * @file      Pubkey.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * A dummy class to expose the `models_pubkey` table in the database
   */

  // Enforce strict types for this file
  declare(strict_types=1);

  namespace Models;

  class Pubkey extends \Model {
    public function user() {
      return $this->has_one('User', 'id');
    }
  }
