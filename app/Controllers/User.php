<?php
  /**
   * @file      User.php
   * @copyright Copyright 2016 Clay Freeman. All rights reserved
   * @license   GNU General Public License v3 (GPL-3.0)
   *
   * Controller to handle `User` object related functions
   */

  // Enforce strict types for this file
  declare(strict_types=1);

  namespace Controllers;

  use \Psr\Http\Message\ServerRequestInterface;
  use \Psr\Http\Message\ResponseInterface;

  class User {
    /**
     * Attempts to fetch a `\Models\User` object from the database by a
     * corresponding e-mail address
     *
     * The provided e-mail address is first validated (to save time by avoiding
     * a database visit for invalid addresses) then an attempt is made to fetch
     * a corresponding database record using case-insensitive matching
     *
     * @see    User::validEmail() For details on the validation process that the
     *                            provided e-mail address will be subjected
     *
     * @param  string $email The e-mail address of a potential `\Models\User`
     *                       object stored in the database
     *
     * @return mixed         The corresponding `\Models\User` object of the
     *                       provided e-mail address or `false` on failure
     */
    public static function fetchByEmail(string $email) {
      $user   = false;
      // Only go to the database if the email is valid
      if (self::validEmail($email = strtolower($email)))
        $user = \Model::factory('\\Models\\User')->where_raw(
          'LOWER(email) = ?', $email)->find_one();
      return (is_object($user) ? $user : false);
    }

    /**
     * Attempts to fetch a `\Models\User` object from the database by a
     * corresponding username
     *
     * The provided username is first validated (to save time by avoiding a
     * database visit for invalid usernames) then an attempt is made to fetch a
     * corresponding database record using case-insensitive matching
     *
     * @see    User::validUsername() For details on the validation process that
     *                               the provided username will be subjected
     *
     * @param  string $username The username of a potential `\Models\User`
     *                          object stored in the database
     *
     * @return mixed            The corresponding `\Models\User` object of the
     *                          provided username or `false` on failure
     */
    public static function fetchByUsername(string $username) {
      $user   = false;
      // Only go to the database if the username is valid
      if (self::validUsername($username = strtolower($username)))
        $user = \Model::factory('\\Models\\User')->where_raw(
          'LOWER(username) = ?', $username)->find_one();
      return (is_object($user) ? $user : false);
    }

    /**
     * Attempts to fetch a `\Models\User` object corresponding to the current
     * browsing session
     *
     * Determines if the current browsing session contains sufficient/correct
     * information to authenticate for a `\Models\User` object in the database
     * by fetching the 'user' key from the session and enforcing a positive
     * value for it then placing constraints on the browsing session
     *
     * @see    User::verifyPeer() For details on the constraints placed on the
     *                            browsing session
     *
     * @return mixed              The corresponding `\Models\User` object of the
     *                            current session or `false` on failure
     */
    public static function fetchCurrent() {
      // Assume a false state
      $user   = false;
      // Attempt to extract the 'user' field containing a user ID
      $userid = intval(getSession('user', 0));

      // If the value of 'user' satisfies the range {1..inf}, attempt to verify
      // the peer with its initial IP and U/A state
      if ($userid > 0 && self::verifyPeer())
        // Fetch the matching record from the database
        $user = \Model::factory('\\Models\\User')->find_one($userid);

      // Return the given result (if valid), otherwise return false
      return (is_object($user) && property_exists($user, 'id') &&
        $user->user_id == $userid ? $user : false);
    }

    /**
     * Attempts to authenticate a user based on the provided username and
     * password from the login page.
     *
     * If the user is already logged in they will be redirected to the home
     * page and informed accordingly.
     *
     * If the user is not already logged in then an attempt will be made to
     * look up a user account based on the provided username. If an account is
     * found that is not disabled then the provided password is validated
     * against the password stored in the database.
     *
     * If an account is found that is disabled then the user will be notified
     * accordingly. In all other cases where an error occurs a generic message
     * conveying failure will be displayed.
     *
     * Once the user is successfully authenticated the session will be prepared
     * so that `User::fetchCurrent()` will retrieve the user account associated
     * with the current session.
     *
     * @param  ServerRequestInterface $request  The `Slim` request interface.
     * @param  ResponseInterface      $response The `Slim` response interface.
     *
     * @return ResponseInterface                Modified `Slim` response.
     */
    public static function login(
        ServerRequestInterface $request,
        ResponseInterface      $response): ResponseInterface {
      // Ensure logged in users are redirected to their account page
      if (is_object(self::fetchCurrent())) {
        putSession('message', 'You\'re already logged in.');
        return $response->withRedirect('/app/user');
      }

      // Fetch the parsed body from the Slim request interface
      $post = $request->getParsedBody();
      // Attempt to load the requested user account
      $user = self::fetchByUsername($post['username']);
      // Verify that the username exists
      if (is_object($user)) {
        // Verify that the user account is not disabled
        if (!$user->disabled) {
          // Check the provided password against the user's password
          $verified = \ParagonIE\Halite\Password::verify(
            $post['password'], // The provided password
            $user->password,   // The stored   password
            \ParagonIE\Halite\KeyFactory::loadEncryptionKey(__HALITEKEY__));
          if ($verified) {
            // The user is now authenticated and the login should proceed
            putSession('user', $user->user_id);
            // Inform the user that they have been logged in
            putSession('message', 'You have successfully logged in.');
            // Redirect the user to the home page
            return $response->withRedirect('/');
          }
        } else {
          // Inform the user about their account being disabled
          putSession('error', 'Your account is disabled. Contact the site '.
            'owner for more information.');
          // Redirect the user back to the login page
          return $response->withRedirect('/app/login');
        }
      }
      // Catch all other errors to inform the user of a general failure
      putSession('error', 'Unable to login. Check your username and password '.
        'and try again.');
      // Redirect the user back to the login page
      return $response->withRedirect('/app/login');
    }

    /**
     * @brief Logout
     *
     * Erases the current session
     */
    public static function logout() {
      // Just clear the session
      killSession();
    }

    /**
     * @brief E-Mail Available
     *
     * Determines the availability of an email address and prints a JSON encoded
     * response with the details of availability
     */
    public static function emailAvailable(
        ServerRequestInterface $request,
        ResponseInterface      $response): ResponseInterface {
      // Fetch the e-mail address from the request
      $email = $request->getParsedBody();
      $email = $email['email'] ?? null;
      // Determine if the e-mail address is available
      $available = self::validEmail($email) &&
        !is_object(self::fetchByEmail($email));
      // Determine the appropriate response code
      $code      = $available ? 200 /* OK */ : 409 /* CONFLICT */;
      return $response->withJson(['available' => $available], $code);
    }

    /**
     * @brief Register
     *
     * Processes the submission from a registration form
     *
     * @param request The Slim framework request interface
     * @param response The Slim framework response interface
     */
    public static function register(
        ServerRequestInterface $request,
        ResponseInterface      $response): ResponseInterface {
      // Fetch the parsed body from the Slim request interface
      $post = $request->getParsedBody();
      // Fetch the appropriate form fields
      $username = $post['username'] ?? null;
      $email    = $post['email']    ?? null;
      $password = $post['password'] ?? null;

      // Ensure logged in users are redirected to their account page
      if (is_object(self::fetchCurrent()))
        return $response->withRedirect('/app/user');

      // Determine if the provided username is valid
      if (!self::validUsername($username)) {
        putSession('error', 'Invalid username provided.');
        return $response->withRedirect('/app/register');
      }

      // Determine if the provided username is valid
      if (!self::validEmail($email)) {
        putSession('error', 'Invalid e-mail address provided.');
        return $response->withRedirect('/app/register');
      }

      // Determine if the provided password meets strength requirements
      $zxcvbn   = new \ZxcvbnPhp\Zxcvbn;
      $strength = $zxcvbn->passwordStrength($password, array_merge(
        ['pubkey', 'pub', 'key', 'public'],
        explode(' ', $email),
        explode(' ', $username)
      ));
      if (isset($strength) && $strength['score'] < 3) {
        putSession('error', 'Password strength requirement was not satisfied.');
        return $response->withRedirect('/app/register');
      }

      // Determine if the username or email address were taken
      if (is_object(self::fetchByUsername($username))) {
        putSession('error', 'Username already registered.');
        return $response->withRedirect('/app/register');
      }
      if (is_object(self::fetchByEmail($email))) {
        putSession('error', 'E-mail address already registered.');
        return $response->withRedirect('/app/register');
      }

      // If we've reached this point, registration is possible and should
      // continue as requested
      $newUser = \Model::factory('\\Models\\User')->create();
      $newUser->username = $username;
      $newUser->email    = $email;
      try { $newUser->password = base64_encode(
        \ParagonIE\Halite\Password::hash(
          $password,
          \ParagonIE\Halite\KeyFactory::loadEncryptionKey(__HALITEKEY__)
        )
      ); } catch (\Exception $e) { die(); }
      // Unset the cleartext password and save the user
      unset($password);
      $newUser->save();

      // Redirect the user to the home page informing them of a successful
      // registration process
      putSession('message', 'Registration was successful. You may now login.');
      return $response->withRedirect('/');
    }

    /**
     * @brief User Available
     *
     * Determines the availability of a username and prints a JSON encoded
     * response with the details of availability
     */
    public static function userAvailable(
        ServerRequestInterface $request,
        ResponseInterface      $response): ResponseInterface {
      // Fetch the username from the request
      $username = $request->getParsedBody();
      $username = $username['username'] ?? null;
      // Determine if the username is available
      $available = self::validUsername($username) &&
        !is_object(self::fetchByUsername($username));
      // Determine the appropriate response code
      $code      = $available ? 200 /* OK */ : 409 /* CONFLICT */;
      return $response->withJson(['available' => $available], $code);
    }

    /**
     * @brief Valid E-Mail
     *
     * Determines if an email address is valid
     *
     * @param email The email address to test
     *
     * @return `true` if valid,
     *         otherwise `false` will be returned
     */
    public static function validEmail(string $email): bool {
      return strlen(trim($email)) > 5 &&
        filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * @brief Valid Username
     *
     * Determines if a username is valid
     *
     * @param username The username to test
     *
     * @return `true` if valid,
     *         otherwise `false` will be returned
     */
    public static function validUsername(string $username): bool {
      return preg_match('/^[a-z][a-z0-9]{2,}$/i', $username) == 1;
    }

    /**
     * @brief Verify Peer
     *
     * Curbs the vulnerability of session hijacking by verification of IP
     * address and the user agent that the browser sends
     */
    public static function verifyPeer(): bool {
      // Attempt to fetch IP address and User Agent from the session, and only
      // continue upon successful verification
      if ($ip = getSession('ip', false)  && $ua = getSession('ua', false) &&
          isset($_SERVER['REMOTE_ADDR']) &&
          isset($_SERVER['HTTP_USER_AGENT']) &&
          $ip == $_SERVER['REMOTE_ADDR'] && $ua == $_SERVER['HTTP_USER_AGENT'])
        return true;
      // Assume failure in all other cases and clear the session
      self::logout();
      return false;
    }
  }
