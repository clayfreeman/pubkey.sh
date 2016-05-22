<?php
  /**
   * @file      Pubkey.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * Defines functionality for the Pubkey page
   */

  // Enforce strict types for this file
  declare(strict_types=1);

  namespace Views;

  use \Psr\Http\Message\ServerRequestInterface;
  use \Psr\Http\Message\ResponseInterface;

  class Pubkey {
    public static function prepareArgs(
        ServerRequestInterface $request,
        array&                 $args) {
      // Attempt to fetch the requested user by username
      $user = $request->getAttribute('username');
      $user = \Controllers\User::fetchByUsername($user);
      // Ensure the user is valid and not disabled
      if (is_object($user) && $user->disabled == false) {
        // Fetch the name of the requested key
        $key = trim($request->getAttribute('key', null));
        if ($key != null)
          // Fetch the key by its name specified in the URI component
          $key = $user->pubkeys()->where('uri', $key)->find_one();
        else
          // Fetch the user's default key by its ID
          $key = $user->pubkey()->find_one();
        // Ensure the key is valid
        if (is_object($key)) {
          // Setup the arguments for the template
          $args['type']   = $key->type;
          $args['pubkey'] = $key->data;
          $args['finger'] = $key->fp;
          $args['author'] = $user->username;
        }
      }
    }

    public static function show(
        ServerRequestInterface $request,
        ResponseInterface      $response,
        array                  $args = array()): ResponseInterface {
      global $twig;
      // Prepare the template's arguments
      self::prepareArgs($request, $args);
      $args['path'] = $request->getUri()->getPath();
      // Render the appropriate template then write it to the response body
      $output = $twig->render(
        'installers/'.($args['type'] ?? 'SSH').'.twig', $args);
      $response->getBody()->write($output);
      return $response;
    }
  }
