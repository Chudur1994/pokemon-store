<?php

require_once "Cart.php";
require_once "Pokemon.php";
require_once "DB.php";
require_once "Paginator.php";


//$pikachu = new Pokemon("Pikachu",
//                       "Pikachu's Image",
//                       "Pikachu's Description",
//                       ["Normal", "Electric"],
//                       [30, 25, 10, 5],
//                       ["Thunderbolt", "Quick Attack", "Leer", "Dodge"],
//                       9.99,
//                       3,
//                       7.99);
//
//$charizard = new Pokemon("Charizard",
//                         "Charizard's Image",
//                         "Charizard's Description",
//                         ["Flying", "Fire"],
//                         [55, 70, 80, 90],
//                         ["Flamethrower", "Wing Attack", "Tackle", "Fly"],
//                         23.99,
//                         5,
//                         21.99);


$db = new DB();
$query = "SELECT COUNT(*) FROM products";

$itemsPerPage = 8;
$paginator = new Paginator($db, $query, $itemsPerPage);

$page = 1;

if (!isset($_POST['page'])) {
  $page = 1;
} else {
  $page = $_POST['page'];
}


?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
  <title>Document</title>
</head>
<body>
<div class="container">
  <div id="pagination_data">

  </div>
</div>
<?php
for ($page = 1; $page <= $paginator->getPages(); $page++) {
  echo "<span class='pagination_link' style='cursor:pointer; padding:6px; border:1px solid #ccc;' id={$page}>{$page}</span>";
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="script.js"></script>
<script>
</script>
</body>
</html>