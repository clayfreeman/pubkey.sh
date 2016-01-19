<?php
  /**
   * @file User.php
   *
   * Controller to handle User object related functions
   */

  namespace Controllers;

  class User {
    /**
     * @brief Available
     *
     * Determines the availability of a username and prints a JSON encoded
     * response with the details of availability
     */
    public static function available($request) {
      // Fetch the username from the request
      $username = $request->getBody();
      // Determine if the username is available
      echo json_encode(array("available" => !is_object(self::get($username))));
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
    public static function get($username) {
      $username = preg_replace('/[^a-z0-9]/i', null, $username);
      $user     = \Model::factory('\\Models\\User')->where_like('user',
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
     * @brief Register
     *
     * Processes the submission from a registration form
     *
     * @param request The Slim framework request interface
     * @param response The Slim framework response interface
     */
    public static function register($request, $response) {
      // Ensure logged in users are redirected to the home page
      if (is_object(self::getCurrent()))
        return \Views\Login::show("You're already logged in.");

      // Fetch the parsed body from the Slim request interface
      $post = $request->getParsedBody();
      // Encrypt the password provided in the form
      $post['cipher'] = \ParagonIE\PasswordLock\PasswordLock::hashAndEncrypt($post['password'], __PASSKEY__);
      $post['verify'] = \ParagonIE\PasswordLock\PasswordLock::decryptAndVerify($post['password'], $post['cipher'], __PASSKEY__);
      $post['password'] = 'redacted';
      echo html_dump($post)."\n";
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
