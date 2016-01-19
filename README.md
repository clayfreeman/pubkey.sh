# Patch

Until `paragonie/password_lock` makes another release, the following patch is
required, and may need to be repeated after utilizing the `composer` command:

```sh
patch vendor/composer/installed.json < password_lock.patch
composer dump-autoload
```

# Attributions

* [Key](https://thenounproject.com/term/key/12637/) by
  [Ricardo Moreira](https://thenounproject.com/skatakila/) from the
  [Noun Project](https://thenounproject.com) used in the logo for this project
