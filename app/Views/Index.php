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
        array                  $args = null): ResponseInterface {
      global $twig;
      // Render the appropriate template then write it to the response body
      $output = $twig->render(basename(__CLASS__).'.twig', $args);
      return $response->withBody($output);
    }
  }
