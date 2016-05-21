<?php
  /**
   * @file      Index.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * Defines functionality for the Index page
   */

  // Enforce strict types for this file
  declare(strict_types=1);

  namespace Views;

  use \Psr\Http\Message\ServerRequestInterface;
  use \Psr\Http\Message\ResponseInterface;

  class Index {
    public static function show(
        ServerRequestInterface $request,
        ResponseInterface      $response,
        array                  $args = array()): ResponseInterface {
      global $twig;
      $args['message']  = getSession('message'); putSession('message', null);
      $args['path']     = $request->getUri()->getPath();
      $info             = new \ReflectionClass(__CLASS__);
      // Render the appropriate template then write it to the response body
      $output = $twig->render(basename($info->getShortName()).'.twig', $args);
      $response->getBody()->write($output);
      return $response;
    }
  }
