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

  $cartPokemons = "";
  $output["tax"] = $cart->getTax();
  $output["total"] = $cart->getTotalPrice();

  if (count($cartItems) == 0) {
    $output["item"] = $components->empty("Empty Cart");
  } else {
    foreach ($cartItems as $cartItem) {
      $cartPokemons .= $components->cartItem($cartItem);
    }
    $output["item"] = $cartPokemons;
  }

  echo json_encode($output);
} else {
  $itemsPerPage = 8;
  $filteredTypes = [];

  $currentPage = !isset($_POST['page']) ? 1 : $_POST['page'];

  if (!isset($_POST['types']) && empty($_POST['types'])) {
    $query = "SELECT COUNT(*) FROM products WHERE sale IS NULL";
  } else {
    $filteredTypes = $_POST['types'];
    $query = makeQuery($filteredTypes);
  }

  $paginator = new Paginator($query, $itemsPerPage);
  $catalogItems = $paginator->getResults($currentPage, $filteredTypes);

  $filterChips = "";
  $itemCards = "";
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

  if (!empty($catalogItems)) {
    foreach ($catalogItems as $item) {
      $encodedItem = json_encode($item);

      // item infos
      $name = $item->getName();
      $image = $item->getImage();
      $desc = $item->getDescription();

      $itemCards .= "<div class='col s3 left-align'>
                      <div class='card sticky-action'>
                        <div class='card-image waves-effect waves-block waves-light'>
                          <img class='activator' src='./assets/img/gen1/{$image}'>
                        </div>
                        <div class='card-content'>
                            <span class='card-title activator grey-text text-darken-4'>
                              ${name} <i class='material-icons right'>more_vert</i>
                            </span>
                        </div>
                        <div class='card-action'>
                          {$components->addToCart($encodedItem)}
                        </div>
                        <div class='card-reveal'>
                            <span class='item-name card-title grey-text text-darken-4'>
                              ${name} <i class='material-icons right'>close</i>
                            </span>
                          <p>{$desc}</p>
                        </div>
                      </div>
                    </div>";
    }
    // PREVIOUS ARROW
    $isDisabled = $currentPage == 1 ? ["li_link" => "disabled", "a_link" => "#!"] : ["li_link" => "waves-effect", "a_link" => "previous_link"];
    $pagination .= $components->paginationNavLink($isDisabled, "chevron_left");

    // LINKS
    for ($page = 1; $page <= $paginator->getPages(); $page++) {
      $isActive = $currentPage == $page ? "active" : "";
      $pagination .= $components->paginationLink($page, $isActive);
    }

    // NEXT ARROW
    $isDisabled = $currentPage == $paginator->getPages() ? ["li_link" => "disabled", "a_link" => "#!"] : ["li_link" => "waves-effect", "a_link" => "next_link"];
    $pagination .= $components->paginationNavLink($isDisabled, "chevron_right");
  } else {
    $itemCards = $components->empty("No Matching Items Found...");
    $pagination = "";
  }

  $output[] = $filterChips;
  $output[] = $itemCards;
  $output[] = $pagination;
  echo json_encode($output);
}
function makeQuery($filteredTypes)
{
  $query = "SELECT COUNT(*)
            FROM ";

  if (count($filteredTypes) == 1) {
    // if there is only 1 filtered type
    $query .= "products
              JOIN product_type USING(name)
              JOIN TYPES USING(type)
              WHERE TYPES.type = '{$filteredTypes[0]}' AND sale IS NULL";
  } else {
    // if there is more than 1 type being filtered
    for ($i = 0; $i < count($filteredTypes); $i++) {
      if ($i + 1 == count($filteredTypes)) {
        // if last filtered item in the list
        $query .= "(
                SELECT *
                FROM products
                JOIN product_type USING(name)
                JOIN TYPES USING(type)
                WHERE TYPES.type = '{$filteredTypes[$i]}' AND sale IS NULL
             )) result 
                GROUP BY name
                HAVING
                  COUNT(result.name) > 1";
      } else {
        $query .= "((
                SELECT *
                FROM products
                JOIN product_type USING(name)
                JOIN TYPES USING(type)
                WHERE TYPES.type = '{$filteredTypes[$i]}' AND sale IS NULL
              ) UNION ";
      }
    }
  }
  return $query;
}
