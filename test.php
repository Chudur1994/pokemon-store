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

if (isset($_POST['itemRemoved'])) {
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
    $output["item"] = $components->empty();
  } else {
    foreach ($cartItems as $cartItem) {
      $cartPokemons .= $components->cartItem($cartItem);
    }
    $output["item"] = $cartPokemons;
  }

  echo json_encode($output);
}