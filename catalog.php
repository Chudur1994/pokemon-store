<?php

require_once "DB.php";
require_once "Paginator.php";
include_once "data.php";

$db = new DB();

$itemsPerPage = 8;

$currentPage;

$query;

$filteredTypes = [];

if (!isset($_POST['types']) && empty($_POST['types'])) {
  if (!isset($_POST['page'])) {
    $currentPage = 1;
  } else {
    $currentPage = $_POST['page'];
  }
  $query = "SELECT COUNT(*) FROM products";
} else {
  $filteredTypes = $_POST['types'];
  if (!isset($_POST['page'])) {
    $currentPage = 1;
  } else {
    $currentPage = $_POST['page'];
  }
  $query = "SELECT COUNT(*)
            FROM products 
            JOIN product_type ON product_type.name = products.name 
            JOIN types ON types.type = product_type.type 
            WHERE ";
  for ($i = 0; $i < count($filteredTypes); $i++) {
    if ($i + 1 == count($filteredTypes)) {
      $query .= "product_type.type='{$filteredTypes[$i]}'";
    } else {
      $query .= "product_type.type='{$filteredTypes[$i]}' AND ";
    }
  }
}

$paginator = new Paginator($db, $query, $itemsPerPage);
$catalogItems = $paginator->getResults($currentPage, $filteredTypes);
if (!empty($catalogItems)) {
  $output = '<div class="row">
            <div class="col s12 right-align">';

  for ($i = 0; $i < count($filteredTypes); $i++) {
    $bgColor = "background-color: " . types[$filteredTypes[$i]];
    $output .= "<div style='$bgColor;' class='chip white-text'>
                  $filteredTypes[$i]
                </div>";
  }

  $output .= "</div>";

  foreach ($catalogItems as $item) {
    $output .= '<div class="col s3 left-align">
                <div class="card sticky-action">
                  <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="./assets/img/Gen_2/Pichu.gif">
                  </div>
                  <div class="card-content">
                      <span class="card-title activator grey-text text-darken-4">' . $item->getName() .
      '<i class="material-icons right">more_vert</i>
                      </span>
                  </div>
                  <div class="card-action">
                    <a class="btn green waves-effect waves-light">
                      <i class="left material-icons">shopping_cart</i>Add</a>
                  </div>
                  <div class="card-reveal">
                      <span class="card-title grey-text text-darken-4">' . $item->getName() .
      '<i class="material-icons right">close</i>
                      </span>
                    <p>' . $item->getDescription() . '</p>
                  </div>
                </div>
              </div>';
  }

  $output .= '</div>
            </div>
              <div class="row">
                <div class="col s12">
                  <ul class="pagination">';

// PREVIOUS ARROW
  if ($currentPage == 1) {
    $output .= '<li class="disabled"><a class=""><i class="material-icons">chevron_left</i></a></li>';
  } else {
    $output .= '<li class="waves-effect"><a class="previous_link"><i class="material-icons">chevron_left</i></a></li>';
  }

// LINKS
  for ($page = 1; $page <= $paginator->getPages(); $page++) {
    if ($currentPage == $page) {
      $output .= '<li class="active" ><a id="' . $page . '" class="pagination_link">' . $page . '</a></li>';
    } else {
      $output .= '<li class="waves-effect" ><a id="' . $page . '" class="pagination_link">' . $page . '</a></li>';
    }
  }

// NEXT ARROW
  if ($currentPage == $paginator->getPages()) {
    $output .= '<li class="disabled"><a class=""><i class="material-icons"> chevron_right</i></a></li>';
  } else {
    $output .= '<li class="waves-effect"><a class="next_link"><i class="material-icons"> chevron_right</i></a></li>';
  }

  $output .= '</ul>
          </div>
        </div>
      </div>';

  echo $output;
} else {
  echo "Nothing available...";
}