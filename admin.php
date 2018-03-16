<?php
require_once "components.php";

$components = new components();
$components->header(["title" => "Inventory"]);
?>
  <main>
    <?php
    $components->navbar(["logo" => "./assets/img/Pokeball.PNG",
                         "links" => [["index.php", "Home", ""],
                                     ["shoppingcart.php", "Cart", ""],
                                     ["admin.php", "Admin", "active"]]]);
    ?>
    <section class="section section-admin">
      <div class="container">
        <div class="row">
          <div class="col s12">
            <h4>Welcome Admin</h4>
            <div class="divider"></div>
            <div class="col s6">
              <br>
              <a class="btn green waves-effect waves-light modal-trigger" href="#addNew">Add New Item</a>
            </div>
            <div class="col s6">
              <div class="input-field">
                <!-- implement autocomplete! -->
                <input type="text" id="search_inv">
                <label for="search_inv">
                  <i class="material-icons left">search</i> Search...</label>
              </div>
            </div>

            <table class="bordered">
              <thead>
              <tr>
                <th>Name</th>
                <th class="center">Image</th>
                <th>Description</th>
                <th class="center">Types</th>
                <th class="center">Price</th>
                <th class="center">Quantity</th>
                <th></th>
              </tr>
              </thead>

              <tbody id="inventory">
              <!-- INVENTORY ITEMS RENDER HERE -->
              </tbody>
            </table>
          </div>
        </div>
        <div class="col s12 center">
          <ul id="inventory-pagination" class="pagination number">
            <!-- PAGINATION -->
          </ul>
        </div>
      </div>
    </section>

    <div id="addNew" class="modal modal-fixed-footer">
      <div class="modal-content">
        <form action="">
          <div class="row">
            <div class="col s12">
              <h5>Add a New Pokemon</h5>
              <div class="divider"></div>
              <br>
            </div>
            <div class="input-field col s7">
              <input type="text" id="name">
              <label for="name">Pokemon Name</label>
            </div>
            <div class="input-field col s5">
              <select multiple>
                <option value="bug">Bug</option>
                <option value="dark">Dark</option>
                <option value="dragon">Dragon</option>
                <option value="ice">Ice</option>
                <option value="fairy">Fairy</option>
                <option value="fighting">Fighting</option>
                <option value="fire">Fire</option>
                <option value="flying">Flying</option>
                <option value="grass">Grass</option>
                <option value="ghost">Ghost</option>
                <option value="ground">Ground</option>
                <option value="electric">Electric</option>
                <option value="normal">Normal</option>
                <option value="poison">Poison</option>
                <option value="psychic">Psychic</option>
                <option value="rock">Rock</option>
                <option value="steel">Steel</option>
                <option value="water">Water</option>
              </select>
              <label>Pokemon Type</label>
            </div>
            <div class="input-field col s12">
              <textarea id="description" class="materialize-textarea"></textarea>
              <label for="description">Description</label>
            </div>
            <div class="input-field col s4">
              <i class="material-icons prefix">attach_money</i>
              <input type="text" id="price">
              <label for="price">Price</label>
            </div>
            <div class="input-field col s4">
              <i class="material-icons prefix">format_list_numbered</i>
              <input type="text" id="quantity">
              <label for="quantity">Quanity On Hand</label>
            </div>
            <div class="input-field col s4">
              <i class="material-icons prefix">attach_money</i>
              <input type="text" id="sale_price">
              <label for="sale_price">Sale Price</label>
            </div>
          </div>
          <div class="file-field input-field">
            <div style="font-size:.8rem;" class="btn">
              <span>Upload Image</span>
              <input type="file">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path" type="text">
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <a href="#!" class="add-new-item-btn modal-action green modal-close waves-effect waves-green btn">
          <i class="material-icons left">add_circle</i> Add</a>
      </div>
    </div>
  </main>

<?php
$components->footer(["title" => "PokeStore",
                     "subtitle" => "The Greatest Store in the World!",
                     "links" => ["index.php" => "Home",
                                 "http://materializecss.com" => "MaterializeCSS",
                                 "https://pokeapi.co/" => "Pokéapi"]]);
?>