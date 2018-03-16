<?php

require_once "components.php";
require_once "DB.php";
require_once 'Pokemon.php';
include_once 'data.php';

$db = DB::getInstance();
$pdo = $db->getConnection();
$components = new components();

$query = "SELECT * FROM products WHERE sale IS NOT NULL";
$onSaleItems = $pdo->query($query)->fetchAll(PDO::FETCH_CLASS, 'Pokemon');

$components->header(["title" => SITENAME]);
?>

  <body>
<main>
  <?php
  $components->navbar(["logo" => "./assets/img/Pokeball.PNG",
                       "links" => [["index.php", "Home", "active"],
                                   ["shoppingcart.php", "Cart", ""],
                                   ["admin.php", "Admin", ""]]]);
  ?>
  <section class="section-sales">
    <div class="container">
      <div class="row">
        <div class="sale red darken-1 center">
          <h4 class="white-text">On Sale</h4>
        </div>
        <div class="col s12 m6">
          <div id="saleCarousel" class="carousel">
            <?php
            foreach ($onSaleItems as $item) {
              $encodedItem = json_encode($item);
              echo "<a data-salepokemon='{$encodedItem}' class='carousel-item' href='#{$item->getName()}'>
                      <img src='./assets/img/gen1/{$item->getImage()}'>
                    </a>";
            } ?>
          </div>
        </div>
        <div class="col s12 m6">
          <!-- SALE INFO -->
          <div id="sale-info">
            <div class='card-panel z-depth-2'>
              <h4 class="item-name center"><?php echo $onSaleItems[0]->getName() ?></h4>
              <div class='divider'></div>
              <p class="item-desc"><?php echo $onSaleItems[0]->getDescription() ?></p>
              <div id="sale-add-to-cart">
                <?php echo $components->addToCart(json_encode($onSaleItems[0])) ?>
                <!-- ADD TO CART BUTTON FOR SALE ITEM RENDERS HERE -->
              </div>
            </div>
          </div>
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
          foreach (TYPES as $type => $color) {
            $bgColor = "background-color:{$color}";

            echo "<p>
                    <input class='type' type='checkbox' id='{$type}'/>
                    <label for='{$type}'>
                      <span class='filter-type' style='{$bgColor}'>{$type}</span>
                    </label>
                  </p>";
          } ?>
        </form>
      </div>
      <div class="col s10">
        <div class="row">
          <div id="filter-chips" class="col s8">
            <!-- FILTERS-->
          </div>

          <div class="col s4">
            <?php echo $components->search(); ?>
          </div>

          <div id="catalog" class="col s12">
            <!-- CATALOG -->
          </div>

          <div class="col s12">
            <div class="divider"></div>
            <ul id="catalog-pagination" class="pagination number">
              <!-- PAGINATION -->
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>
<?php
$components->footer(["title" => SITENAME,
                     "subtitle" => "The Greatest Store in the World!",
                     "links" => ["index.php" => "Home",
                                 "http://materializecss.com" => "MaterializeCSS",
                                 "https://pokeapi.co/" => "Pokéapi"]]);
?>