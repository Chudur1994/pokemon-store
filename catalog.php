<?php

require_once "DB.php";
require_once "Paginator.php";
require_once "Cart.php";
require_once "components.php";
require_once "Pokemon.php";
include_once "data.php";

$db = DB::getInstance();
$pdo = $db->getConnection();
$cart = new Cart();
$components = new components();
$output = [];

if (isset($_POST['salePokemon'])) {
  $name = $_POST['salePokemon']["name"];
  $desc = $_POST['salePokemon']["description"];

  $query = "SELECT * FROM products WHERE name = '{$name}'";
  $pokemon = $pdo->query($query)->fetchAll(PDO::FETCH_CLASS, 'Pokemon');

  $output["addToCart"] = $components->addToCart(json_encode($pokemon[0]));
  $output["name"] = $name;
  $output["description"] = $desc;

  echo json_encode($output);
} else if (isset($_POST['pageNumber'])) {
  $currentPage = !isset($_POST['pageNumber']) ? 1 : $_POST['pageNumber'];

  switch ($_POST['item']) {
    case 'inventory':
      $itemsPerPage = 10;
      $query = "SELECT COUNT(*) FROM products";

      $paginator = new Paginator($query, $itemsPerPage);
      $items = $paginator->getInventoryItems($currentPage);
      $inventoryItems = "";

      foreach ($items as $item) {
        $inventoryItems .= $components->inventoryItem($item);
      }

      $output["items"] = $inventoryItems;
      $output["pagination"] = $components->pagination($currentPage, $paginator->getPages());


      echo json_encode($output);
      break;
    case 'catalog':
      $itemsPerPage = 8;
      $filteredTypes = [];

      if (!isset($_POST['types']) && empty($_POST['types'])) {
        $query = "SELECT COUNT(*) FROM products WHERE sale IS NULL";
      } else {
        $filteredTypes = $_POST['types'];
        $query = makeQuery($filteredTypes);
      }

      $paginator = new Paginator($query, $itemsPerPage);
      $items = $paginator->getCatalogItems($currentPage, $filteredTypes);

      $filterChips = "";
      $catalogItems = "";
      $pagination = "";

      if (empty($filteredTypes)) {
        // "placeholder" for item type chip
        $filterChips .= "<div class='grey chip white-text'>
                        No Filters
                     </div>";
      } else {
        for ($i = 0; $i < count($filteredTypes); $i++) {
          // create a chip for all the filtered types
          $bgColor = "background-color: " . TYPES[$filteredTypes[$i]];
          $filterChips .= "<div style='$bgColor' class='chip white-text'>
                          $filteredTypes[$i]
                        </div>";
        }
      }

      if (!empty($items)) {
        foreach ($items as $item) {
          $catalogItems .= $components->catalogItem($item);
        }
        $pagination = $components->pagination($currentPage, $paginator->getPages());
      } else {
        $catalogItems = $components->empty("No Matching Items Found...");
        $pagination = "";
      }

      $output[] = $filterChips;
      $output[] = $catalogItems;
      $output[] = $pagination;

      echo json_encode($output);
      break;
  }
} else if (isset($_POST['itemAdded'])) {
  $addedItem = $_POST['itemAdded'];
  $pokemon = new Pokemon();
  $pokemon->setName($addedItem["name"]);
  $pokemon->setDescription($addedItem["description"]);
  $pokemon->setImage($addedItem["image"]);
  $pokemon->setPrice($addedItem["price"]);
  $pokemon->setQuantity($addedItem["quantity"]);

  $msg = $cart->addToCart($pokemon);

  echo json_encode($msg);
} else if (isset($_POST['itemRemoved'])) {
  $item = $_POST['itemRemoved'];

  $pokemon = new Pokemon();
  $pokemon->setName($item["name"]);
  $pokemon->setPrice($item["price"]);
  $pokemon->setQuantity($item["amount"]);

  $cart->removeFromCart($pokemon);

  $cartItems = $cart->getItems();

  $output["total"] = $cart->getTotalPrice();

  if (count($cartItems) == 0) {
    $output["empty"] = $components->empty("Empty Cart");
  }

  echo json_encode($output);
}

function makeQuery($filteredTypes)
{
  $query = "SELECT COUNT(*) FROM (";

  if (count($filteredTypes) == 1) {
    // if there is only 1 filtered type
    $query .= "products) 
              JOIN product_type USING(name) 
              JOIN TYPES USING(type) 
              WHERE TYPES.type = '{$filteredTypes[0]}' AND sale IS NULL";
  } else {
    // if there is more than 1 type being filtered
    for ($i = 0; $i < count($filteredTypes); $i++) {
      if ($i + 1 != count($filteredTypes)) {
        $query .= "(SELECT * FROM products 
                  JOIN product_type USING(name) 
                  JOIN TYPES USING(type) 
                  WHERE TYPES.type = '{$filteredTypes[$i]}' AND sale IS NULL) 
                  UNION ";
      } else {
        // if last filtered item in the list
        $query .= "(SELECT * FROM products 
                  JOIN product_type USING(name) 
                  JOIN TYPES USING(type) 
                  WHERE TYPES.type = '{$filteredTypes[$i]}' AND sale IS NULL)) result 
                  GROUP BY name HAVING COUNT(result.name) > 1";
      }
    }
  }
  return $query;
}
