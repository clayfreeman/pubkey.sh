<?php
  /**
   * @file autoload.php
   *
   * This file creates a class autoloader based off of namespace and class name
   * which are then translated to a file path relative to __PRIVATEROOT__
   */

  /**
   * @brief Autoload Class from Directory
   *
   * Load the file associated with a class name by turning the namespace parts
   * into directory structure
   *
   * @param className The name of the class to load
   */
  function autoloadClassFromDirectory($className) {
    $className = str_ireplace('\\', DIRECTORY_SEPARATOR, $className);
    require_once(__PRIVATEROOT__.'/'.$className.'.php');
  }

  // Now register the autoloader
  spl_autoload_register("autoloadClassFromDirectory");
