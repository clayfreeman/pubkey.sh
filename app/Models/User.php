<?php
  /**
   * @file      User.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * A dummy class to expose the `models_user` table in the database
   */

  // Enforce strict types for this file
  declare(strict_types=1);

  namespace Models;

  class User extends \Model {
    public function pubkey() {
      return $this->belongs_to('Pubkey');
    }

    public function pubkeys() {
      return $this->has_many('Pubkey');
    }
  }
