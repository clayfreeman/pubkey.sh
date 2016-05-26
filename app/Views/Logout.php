<?php
  /**
   * @file      Logout.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * Defines functionality for the Logout page
   */

  // Enforce strict types for this file
  declare(strict_types=1);

  namespace Views;

  use \Psr\Http\Message\ServerRequestInterface;
  use \Psr\Http\Message\ResponseInterface;

  class Logout {
    public static function show(
        ServerRequestInterface $request,
        ResponseInterface      $response,
        array                  $args = array()): ResponseInterface {
      global $twig;
      // Perform the logout routine
      \Controllers\User::logout();
      // Inform the user that they have been logged out
      putSession('message', 'You have successfully logged out.');
      // Redirect the user to the home page
      return $response->withRedirect('/');
    }
  }
