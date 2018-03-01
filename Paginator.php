<?php

require_once "Pokemon.php";

class Paginator
{
  private $db;
  private $query = "";
  private $pages = 0;
  private $count = 0;
  private $itemsPerPage;

  /**
   * Paginator constructor.
   * @param $connection
   * @param $query - should use the count(*) MySql method to count rows
   * @param int $itemsPerPage
   */
  public function __construct($connection, string $query, $itemsPerPage = 8)
  {
    $this->db = $connection;
    $this->query = $query;
    $this->itemsPerPage = $itemsPerPage;

    // get the number of rows
    $this->count = $this->db->query($this->query)->fetchColumn();
    $this->pages = ceil($this->count / $this->itemsPerPage);
  }

  /**
   * @param int $currentPage
   * @param array $types
   * @return array
   */
  public function getResults(int $currentPage, array $types = [])
  {
    if (empty($types)) {
      $startingLimit = ($currentPage - 1) * $this->itemsPerPage;

      $this->query = "SELECT * FROM products WHERE sale IS NULL LIMIT {$startingLimit}, {$this->itemsPerPage}";
    } else {
      $startingLimit = ($currentPage - 1) * $this->itemsPerPage;

      $this->query = "SELECT products.*
                    FROM products 
                    JOIN product_type ON product_type.name = products.name 
                    JOIN types ON types.type = product_type.type 
                    WHERE ";

      for ($i = 0; $i < count($types); $i++) {
        if ($i + 1 == count($types)) {
          $this->query .= "product_type.type='{$types[$i]}' AND (sale IS NULL) ";
        } else {
          $this->query .= "product_type.type='{$types[$i]}' AND ";
        }
      }

      $this->query .= "LIMIT {$startingLimit}, {$this->itemsPerPage}";
    }

    try {
      $results = $this->db->query($this->query)->fetchAll(PDO::FETCH_CLASS, 'Pokemon');
      return $results;
    } catch (PDOException $e) {
      echo $e->getMessage();
      die();
    }
  }

  /**
   * @return int
   */
  public function getPages()
  {
    return $this->pages;
  }
}