<?php

class DB
{
  // be sure to move these to htaccess
  private $_connection;
  private static $_instance; //The single instance
  private $host = 'localhost';
  private $dbname = 'Project1';
  private $user = 'root';
  private $password = '#@lv8J*^6X6g';
  private $default_options = [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => true];

  public static function getInstance()
  {
    if (!self::$_instance) { // If no instance then make one
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  public function __construct()
  {
    try {
      // Assign the connection
      $this->_connection = new PDO("mysql:host={$this->host};dbname={$this->dbname}",
                                               $this->user,
                                               $this->password,
                                               $this->default_options);

    } catch (PDOException $e) {
      echo $e->getMessage();
      die();
    }
  }

  // Magic method clone is empty to prevent duplication of connection
  private function __clone()
  {
  }

  // Get pdo connection
  public function getConnection()
  {
    return $this->_connection;
  }
}