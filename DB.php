<?php

class DB extends PDO
{
  // be sure to move these to htaccess
  private $host = 'localhost';
  private $dbname = 'Project1';
  private $user = 'root';
  private $password = '#@lv8J*^6X6g';
  private $default_options = [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => true];


  public function __construct()
  {
    try {
      // Assign the connection
      parent::__construct("mysql:host={$this->host};dbname={$this->dbname}",
                          $this->user,
                          $this->password,
                          $this->default_options);

    } catch (PDOException $e) {
      echo $e->getMessage();
      die();
    }
  }

//  /**
//   * DB constructor.
//   * @param string $host
//   * @param string $dbname
//   * @param string $user
//   * @param string $password
//   * @param array $options
//   */
//  public function __construct(string $host, string $dbname, string $user, string $password, array $options)
//  {
//    $this->host = $host;
//    $this->dbname = $dbname;
//    $this->user = $user;
//    $this->password = $password;
//
//    try {
//      // Assign the connection
//      $options = array_merge($this->default_options, $options);
//
//      parent::__construct("mysql:host={$this->host};dbname={$this->dbname}",
//                          $this->user,
//                          $this->password,
//                          $options);
//
//    } catch (PDOException $e) {
//      echo $e->getMessage();
//      die();
//    }
//  }
}