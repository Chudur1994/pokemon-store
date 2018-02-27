<?php

require_once "DB.php";
require_once 'Pokemon.php';
include_once 'data.php';

$db = new DB();

$query = "SELECT * FROM products WHERE sale IS NOT NULL";

$onSaleItems = $db->query($query)->fetchAll(PDO::FETCH_CLASS, 'Pokemon');
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
  <title>Welcome</title>
</head>

<body onload="showPage(1)">
<div class="navbar-fixed">
  <nav class="grey darken-3">
    <div class="container">
      <div class="nav-wrapper">
        <a href="#" class="brand-logo center">
          <div>
            <span class="white-text">Poke</span>
            <img src="./assets/img/Pokeball.PNG" alt="">
            <span class="white-text">Store</span>
          </div>
        </a>
        <ul class="hide-on-med-and-down">
          <li class="active">
            <a href="#">
              <i class="left material-icons">home</i> Home</a>
          </li>
          <li>
            <a href="cart.html">
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

<section class="section-sales">
  <div class="container">
    <div class="row">
      <div class="sale red darken-1 center">
        <h4 class="white-text">On Sale</h4>
      </div>
      <div class="col s12 m6">
        <div class="carousel">
          <?php
          foreach ($onSaleItems as $item) {
            echo "<a data-salePokemon='{$item->getName()}' class='carousel-item' href='#{$item->getName()}'>
                    <img src='./assets/img/Gen_2/Pichu.gif'>
                  </a>";
          }
          ?>
        </div>
      </div>
      <div class="col s12 m6" id="sale-info">
        <!-- SALE INFORMATION FOR A POKEMON GOES HERE -->
      </div>
    </div>
  </div>
</section>

<section class="section section-catalog grey lighten-4">
  <div class="row">
    <div class="col container s2 center">
      <p style="font-size:1.5rem;">Filter By Type</p>
      <div class="divider"></div>
      <form id="filterList">
        <?php
        foreach (types as $type => $color) {
          $style = "background-color:{$color};
                    border-bottom: 2px solid rgba(100, 100, 100, .7);
                    position: relative;
                    bottom: 3px;";
          echo "<p>
                  <input class='type' onchange='filterType()' type='checkbox' id='{$type}'/>
                  <label for='{$type}'>
                    <span style='{$style}'>{$type}</span>
                  </label>
                </p>";
        }
        ?>
      </form>
    </div>
    <div class="col s10" id="catalog">
      <!--  CATALOG ITEMS GO HERE  -->
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
<script src="script.js"></script>
<script>
    $(document).ready(function () {
        $('.carousel').carousel({
            onCycleTo: function (data) {
                $.post('sale.php', {
                    salePokemon: $(data).data('salepokemon')
                }, function (info) {
                    $('#sale-info').html(info);
                });
            }
        });
        $('ul.tabs').tabs();
        $('.fixed-action-btn').floatingActionButton();
    });
</script>
</body>

</html>