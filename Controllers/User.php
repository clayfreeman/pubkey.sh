<?php
  /**
   * @file User.php
   *
   * Controller to handle User object related functions
   */

  namespace Controllers;

  use \ParagonIE\PasswordLock\PasswordLock;
  use \ZxcvbnPhp\Zxcvbn;
  class User {
    /**
     * @brief Get
     *
     * Fetches a user by username
     *
     * @param username The username as listed in the database
     *
     * @return A `\Models\User` object if the username exists,
     *         otherwise `false` will be returned
     */
    public static function getEmail($email) {
      $user   = false;
      // Only go to the database if the username is valid
      if (self::validEmail($email))
        $user = \Model::factory('\\Models\\User')->where_like('email',
          $email)->find_one();
      return (is_object($user) ? $user : false);
    }

    /**
     * @brief Get
     *
     * Fetches a user by username
     *
     * @param username The username as listed in the database
     *
     * @return A `\Models\User` object if the username exists,
     *         otherwise `false` will be returned
     */
    public static function getUser($username) {
      $user   = false;
      // Only go to the database if the username is valid
      if (self::validUsername($username))
        $user = \Model::factory('\\Models\\User')->where_like('username',
          $username)->find_one();
      return (is_object($user) ? $user : false);
    }

    /**
     * @brief Get Current User
     *
     * Fetches the currently logged in user's database model
     *
     * @return A `\Models\User` object if the current user is logged in,
     *         otherwise `false` will be returned
     */
    public static function getCurrent() {
      // Assume a false state
      $user   = false;
      // Attempt to extract the 'user' field containing a user ID
      $userid = intval(getSession('user', 0));

      // If the value of 'user' satisfies the range {1..inf}, attempt to verify
      // the peer with its initial IP and U/A state
      if ($userid > 0 && self::verifyPeer())
        // Fetch the matching record from the database
        $user = \Model::factory('\\Models\\User')->find_one($user);

      // Return the given result (if valid), otherwise return false
      return (is_object($user) && property_exists($user, 'id') &&
        $user->id == $userid ? $user : false);
    }

    /**
     * @brief Login
     *
     * Processes the submission from a login form
     *
     * @param request  The Slim framework request interface
     * @param response The Slim framework response interface
     */
    public static function login($request, $response) {
      // Ensure logged in users are redirected to the home page
      if (is_object(self::getCurrent()))
        return \Views\Login::show("You're already logged in.");

      // Fetch the parsed body from the Slim request interface
      $post = $request->getParsedBody();
      $post['password'] = 'redacted';
      echo html_dump($post)."\n";
    }

    /**
     * @brief Logout
     *
     * Erases the current session
     */
    public static function logout() {
      // Just clear the session
      session_unset();
    }

    /**
     * @brief E-Mail Available
     *
     * Determines the availability of an email address and prints a JSON encoded
     * response with the details of availability
     */
    public static function emailAvailable($request) {
      // Fetch the username from the request
      $email = $request->getParsedBody();
      $email = $email['email'];
      // Determine if the username is available
      die(json_encode(array(
        "available" => !is_object(self::getEmail($email))
      )));
    }

    /**
     * @brief Register
     *
     * Processes the submission from a registration form
     *
     * @param request The Slim framework request interface
     * @param response The Slim framework response interface
     */
    public static function register($request, $response) {
      // Fetch the parsed body from the Slim request interface
      $post = $request->getParsedBody();
      // Fetch the appropriate form fields
      $username = $post['username'];
      $email    = $post['email'];
      $password = $post['password'];

      // Ensure logged in users are redirected to their account page
      if (is_object(self::getCurrent()))
        return $response->withRedirect('/user');

      // Determine if the provided username is valid
      if (!self::validUsername($username))
        return \Views\Register::show('Invalid username provided.');

      // Determine if the provided username is valid
      if (!self::validEmail($email))
        return \Views\Register::show('Invalid email address provided.');

      // Determine if the provided password meets strength requirements
      $zxcvbn   = new Zxcvbn;
      $strength = $zxcvbn->passwordStrength($password, array_merge(
        explode(" ", $email),
        explode(" ", $username)
      ));
      if ($strength['score'] < 3)
        return \Views\Register::show('Password strength requirements were not '.
          'satisfied.');

      // Determine if the username or email address were taken
      if (is_object(self::getUser($username)))
        return \Views\Register::show('Username already registered.');
      if (is_object(self::getEmail($email)))
        return \Views\Register::show('Email address already registered.');

      // If we've reached this point, registration is possible and should
      // continue as requested
      $newUser = \Model::factory('\\Models\\User')->create();
      $newUser->username = $username;
      $newUser->email    = $email;
      $newUser->password = PasswordLock::hashAndEncrypt($password, __PASSKEY__);
      // Unset the cleartext password and save the user
      unset($password);
      $newUser->save();

      // Redirect the user to the home page informing them of a successful
      // registration process
      return \Views\Index::show('Registration was successful. '.
        'You may now login.');
    }

    /**
     * @brief User Available
     *
     * Determines the availability of a username and prints a JSON encoded
     * response with the details of availability
     */
    public static function userAvailable($request) {
      // Fetch the username from the request
      $username = $request->getParsedBody();
      $username = $username['username'];
      // Determine if the username is available
      die(json_encode(array(
        "available" => !is_object(self::getUser($username))
      )));
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
    public static function validEmail($email) {
      return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
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
    public static function validUsername($username) {
      return preg_match('/^[a-z][a-z0-9]{2,}$/i', $username);
    }

    /**
     * @brief Verify Peer
     *
     * Curbs the vulnerability of session hijacking by verification of IP
     * address and the user agent that the browser sends
     */
    public static function verifyPeer() {
      // Attempt to fetch IP address and User Agent from the session, and only
      // continue upon successful verification
      if ($ip = getSession('ip', false)  && $ua = getSession('ua', false) &&
          $ip == $_SERVER['REMOTE_ADDR'] && $ua == $_SERVER['HTTP_USER_AGENT'])
        return true;
      // Assume failure in all other cases and clear the session
      self::logout();
      return false;
    }
  }
