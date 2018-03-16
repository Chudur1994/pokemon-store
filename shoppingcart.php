<?php
require_once "Cart.php";
require_once "components.php";

$cart = new Cart();
$components = new components();
$components->header(["title" => "Your Cart"]);
?>
  <main>
    <?php
    $components->navbar(["logo" => "./assets/img/Pokeball.PNG",
                         "links" => [["index.php", "Home", ""],
                                     ["shoppingcart.php", "Cart", "active"],
                                     ["admin.php", "Admin", ""]]]);
    ?>

    <section class="section section-cart">
      <div class="container">
        <div class="row">
          <div class="col s8">
            <div class="col s12">
              <div class="blue darken-1 white-text row card valign-wrapper z-depth-2">
                <div class="card-content col s12">
                <span class="card-title">
                  <h5>Your Cart</h5>
                  <hr>
                </span>
                  <div class="col s5">Item</div>
                  <div class="col s2">Quantity</div>
                  <div class="col s3 center">Price</div>
                  <div class="col s2 center">Remove</div>
                </div>
              </div>
              <div id="cart">
                <?php
                if (count($cart->getItems()) == 0) {
                  echo $components->empty("Empty Cart");
                } else {
                  foreach ($cart->getItems() as $cartItem) {
                    echo $components->cartItem($cartItem);
                  }
                } ?>
              </div>
            </div>
          </div>

          <div class="col s4">
            <div class='card z-depth-1 grey lighten-5'>
              <div class='card-content confirm-purchase'>
                <span class='card-title'><h5>Confirm</h5></span>
                <hr>
                <h6>
                  Tax: <span id="tax">8.875%</span>
                </h6>
                <h6>
                  Total: $<span id="total"><?php echo $cart->getTotalPrice(); ?></span>
                </h6>
                <hr>
                <br>
                <a class='btn green white-text'>Place Order</a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </main>
<?php
$components->footer(["title" => "PokeStore",
                     "subtitle" => "The Greatest Store in the World!",
                     "links" => ["index.php" => "Home",
                                 "http://materializecss.com" => "MaterializeCSS",
                                 "https://pokeapi.co/" => "Pokéapi"]]);
?>