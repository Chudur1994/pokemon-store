<?php

require_once "DB.php";
require_once "Pokemon.php";

$db = new DB();
$query = "";
$output = "";

if (isset($_POST['salePokemon'])) {
  $query = "SELECT * FROM products WHERE name = '{$_POST['salePokemon']}'";
  $pokemon = $db->query($query)->fetchAll(PDO::FETCH_CLASS, 'Pokemon');

  $style = "height: 25rem !important;";

  $output .= "<div class='card-panel z-depth-2' style='$style'>
                <h4 class='center'>{$pokemon[0]->getName()}</h4>
                <div class='divider'></div>
                <p>{$pokemon[0]->getDescription()}</p>
                <h6>Learned Moves</h6>
                <ul>
                  <li>&bull; move1</li>
                  <li>&bull; move2</li>
                  <li>&bull; move3</li>
                  <li>&bull; move4</li>
                </ul>
                <a style='width: 100%;' class='btn green waves-effect waves-light add-to-cart'>
                  <i class='left material-icons'>shopping_cart</i>Add to Cart
                </a>
              </div>";
} else {
  $output = "Waiting for response from database...";
}

echo $output;

