<?php

/**
 * Display servers list from defined ADMINER_SERVERS variable.
 * @link https://www.adminer.org/plugins/#use
 * @author https://github.com/garis-space
 */
class AdminerLoginServers
{
  private $servers;

  /**
   * Set servers from environment variable
   * Example:
   * $_ENV['ADMINER_SERVERS'] = '{
   *  "Server 1":{"driver":"pgsql","server":"","username":"","password":"","db":""},
   *  "Server 2":{"driver":"pgsql","server":"","username":"","password":"","db":""}
   * }';
   */
  public function __construct()
  {
    if ($_ENV['ADMINER_SERVERS']) {
      $this->servers = json_decode($_ENV['ADMINER_SERVERS'], true);
    }

    if ($_POST["auth"]["custom_server"]) {
      $key = $_POST["auth"]["custom_server"];
      $_POST["auth"]["driver"] = $this->servers[$key]["driver"];
      $_POST["auth"]["server"] = $this->servers[$key]["server"];
      $_POST["auth"]["username"] = $this->servers[$key]["username"];
      $_POST["auth"]["password"] = $this->servers[$key]["password"];
      $_POST["auth"]["db"] = $this->servers[$key]["db"];
    }
  }

  public function loginFormField($name, $heading, $value)
  {
    if ($name == 'db' && $this->servers) {
      $servers = $this->servers;

      ob_start();
      echo $heading . $value;
      include __DIR__ . '/login-servers/template.tpl';

      return ob_get_clean();
    }
  }
}

return new AdminerLoginServers();
