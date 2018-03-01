<?php
require_once "Cart.php";

$cart = new Cart();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Press+Start+2P|Raleway" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  <title>Cart</title>
</head>

<body>
<main>
  <div class="navbar-fixed">
    <nav class="grey darken-3">
      <div class="container">
        <div class="nav-wrapper">
          <a href="index.php" class="brand-logo center">
            <div>
              <span class="white-text">Poke</span>
              <img src="./assets/img/Pokeball.PNG" alt="">
              <span class="white-text">Store</span>
            </div>
          </a>
          <ul class="hide-on-med-and-down">
            <li class="">
              <a href="index.php">
                <i class="left material-icons">home</i> Home</a>
            </li>
            <li class="active">
              <a href="#">
                <i class="left material-icons">shopping_cart</i> Cart</a>
            </li>
          </ul>
          <ul class="right hide-on-med-and-down">
            <li>
              <a href="admin.html">
                <i class="left material-icons">account_circle</i> Admin</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>

  <section class="section section-cart">
    <div class="container">
      <div class="row">
        <div class="col s12">
          <h4>Your Cart</h4>
          <div class="divider"></div>
          <br>
        </div>
        <div class="col s8">
          <table class="bordered">
            <thead>
            <tr>
              <th>Name</th>
              <th>Quantity</th>
              <th>Price</th>
              <th></th>
            </tr>
            </thead>

            <tbody>
            <?php

            $cart_items = $cart->getItems();

            foreach ($cart_items as $cart_item) {
              echo "<tr>
                    <td>{$cart_item->getName()}</td>
                    <td>{$cart_item->getQuantity()}</td>
                    <td>{$cart_item->getPrice()}</td>
                    <td width=5%>
                      <a class='btn red'>Remove</a>
                    </td>
                  </tr>";
            }

            ?>
            </tbody>
          </table>
          <h5 class="right-align">Total:
            <b><?php echo "$" . $cart->getTotalPrice(); ?></b>
          </h5>
        </div>
        <div class="col s3 offset-s1 confirm">
          <div>
            <h5 class="center">Confirm</h5>
            <div class="divider"></div>
            <p><b>Tax</b>:
              <?php echo $cart->getTax(); ?>%
            </p>
            <p><b>Total Price</b>:
              $<?php echo $cart->getTotalPrice(); ?>
            </p>
            <div class="divider"></div>
            <br>
            <a href="" class="btn blue">Place Order</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="fixed-action-btn">
    <a class="btn-floating btn-large" style="background-color: #1DA1F2;">
      <div style="font-size:1.7em;">
        <i class="fab fa-twitter"></i>
      </div>
    </a>
    <ul>
      <li>
        <a class="btn-floating" style="background-color:#4867AA;">
          <div style="font-size:1.5em;">
            <i class="fab fa-facebook-f"></i>
          </div>
        </a>
      </li>
      <li>
        <a class="btn-floating" style="background-color:#D62976;">
          <div style="font-size:1.5em;">
            <i class="fab fa-instagram"></i>
          </div>
        </a>
      </li>
      <li>
        <a class="btn-floating" style="background-color: #DC4A38;">
          <div style="font-size:1.5em;">
            <i class="fab fa-google-plus-g"></i>
          </div>
        </a>
      </li>
    </ul>
  </div>

</main>
<footer style="background-image: url(./assets/img/Pikachu.png);" class="page-footer grey darken-3">
  <div class="container">
    <div class="row">
      <div class="col l6 s12">
        <h5 class="white-text">Footer Content</h5>
        <p class="grey-text text-lighten-4">Footer stuff goes here.</p>
      </div>
      <div class="col l3 offset-l3 s12">
        <h5 class="white-text">Links</h5>
        <ul>
          <li>
            <a class="grey-text text-lighten-3" href="#!">Link 1</a>
          </li>
          <li>
            <a class="grey-text text-lighten-3" href="#!">Link 2</a>
          </li>
          <li>
            <a class="grey-text text-lighten-3" href="#!">Link 3</a>
          </li>
          <li>
            <a class="grey-text text-lighten-3" href="#!">Link 4</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="footer-copyright">
    <div class="container">
      &copy; 2018 Copyright Text
      <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
    </div>
  </div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
<script>
</script>
</body>

</html>