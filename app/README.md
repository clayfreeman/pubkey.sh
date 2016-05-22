# TODO

 * Work on removing all inline JS/CSS from source (to enable the use of the
   `Content-Security-Policy` HTTP header).
 * Consider using custom session management instead of PHP's built in session
   management utilities (using [Halite](https://github.com/paragonie/halite)'s
   symmetric encryption & browser cookies).
 * Consider rewriting JS for registration page to be more abstract, potentially
   use another solution.
 * Look into type strict `\Controllers\User::fetch*()` method implementations
   with ease-of-use in mind (currently not possible due to returning either
   a `\Models\User` instance or `false` on failure).
 * Design & implement user dashboard for key management.
 * Explore options for easily setting up & configuring different database
   targets such as MySQL or PostgreSQL (this may require a more abstract schema
   that is flexible enough to work across multiple database platforms).
 * Probably other things too that haven't been thought of...
