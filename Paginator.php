<?php

require_once "Pokemon.php";

class Paginator
{
  private $db;
  private $pdo;
  private $query = "";
  private $pages = 0;
  private $count = 0;
  private $itemsPerPage;

  /**
   * Paginator constructor.
   * @param $query - should use the count(*) MySql method to count rows
   * @param int $itemsPerPage
   */
  public function __construct(string $query, $itemsPerPage = 8)
  {
    $this->db = DB::getInstance();
    $this->pdo = $this->db->getConnection();
    $this->query = $query;
    $this->itemsPerPage = $itemsPerPage;

    // get the number of rows
    $this->count = $this->pdo->query($this->query)->fetchColumn();
    $this->pages = ceil($this->count / $this->itemsPerPage);
  }

  /**
   * @param int $currentPage
   * @return array
   */
  public function getInventoryItems(int $currentPage)
  {
    $startingLimit = ($currentPage - 1) * $this->itemsPerPage;
    $this->query = "SELECT products.*, GROUP_CONCAT(product_type.type) AS type FROM products 
                    JOIN product_type USING(name) 
                    GROUP BY name LIMIT {$startingLimit}, {$this->itemsPerPage}";
    try {
      $results = $this->pdo->query($this->query)->fetchAll(PDO::FETCH_CLASS, 'Pokemon');
      return $results;
    } catch (PDOException $e) {
      echo $e->getMessage();
      die();
    }
  }

  /**
   * @param int $currentPage
   * @param array $types
   * @return array
   */
  public function getCatalogItems(int $currentPage, array $types = [])
  {
    $startingLimit = ($currentPage - 1) * $this->itemsPerPage;

    if (empty($types)) {
      $this->query = "SELECT * FROM products WHERE sale IS NULL LIMIT {$startingLimit}, {$this->itemsPerPage}";
    } else {
      $this->query = "SELECT *
            FROM (";

      if (count($types) == 1) {
        // if there is only 1 type to be filtered
        $this->query .= "products)
                        JOIN product_type USING(name)
                        JOIN TYPES USING(type)
                        WHERE TYPES.type = '{$types[0]}' AND sale IS NULL 
                        LIMIT {$startingLimit}, {$this->itemsPerPage}";
      } else {
        // if there are more than 1 type being filtered
        for ($i = 0; $i < count($types); $i++) {
          if ($i + 1 != count($types)) {
            $this->query .= "(
                SELECT *
                FROM products
                JOIN product_type USING(name)
                JOIN TYPES USING(type)
                WHERE TYPES.type = '{$types[$i]}' AND sale IS NULL
              ) UNION ";
          } else {
            // if last item in the list of filtered items
            $this->query .= "(
                SELECT *
                FROM products
                JOIN product_type USING(name)
                JOIN TYPES USING(type)
                WHERE TYPES.type = '{$types[$i]}' AND sale IS NULL
             )) result 
                GROUP BY name
                HAVING
                  COUNT(result.name) > 1
                LIMIT {$startingLimit}, {$this->itemsPerPage}";
          }
        }
      }
    }
    try {
      $results = $this->pdo->query($this->query)->fetchAll(PDO::FETCH_CLASS, 'Pokemon');
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

  /**
   * @return string
   */
  public function getQuery(): string
  {
    return $this->query;
  }


}