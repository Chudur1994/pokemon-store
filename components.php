<?php

class components
{
  function __construct()
  {

  }

  function header(array $data)
  {
    echo "<!doctype html>
        <html lang='en'>
        
        <head>
          <meta charset='UTF-8'>
          <meta name='viewport'
                content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
          <meta http-equiv='X-UA-Compatible' content='ie=edge'>
          <link rel='stylesheet' href='./assets/css/style.css'>
          <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css'>
          <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
          <link href='https://fonts.googleapis.com/css?family=Press+Start+2P|Raleway' rel='stylesheet'>
          <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
          <script defer src='https://use.fontawesome.com/releases/v5.0.6/js/all.js'></script>
          <title>{$data['title']}</title>
        </head>
          <body>";
  }

  function footer(array $data)
  {
    $links = "";

    foreach ($data['links'] as $href => $text) {
      $links .= "<li>
                    <a class='grey-text text-lighten-3' href='$href' >{$text}</a>
                  </li>";
    }

    $footer = "<footer style='background-image: url(./assets/img/Pikachu.png);' class='page-footer grey darken-3'>
                <div class='container'>
                  <div class='row'>
                    <div class='col l6 s12'>
                      <h5 class='white-text'>{$data['title']}</h5>
                      <p class='grey-text text-lighten-4'>{$data['subtitle']}</p>
                    </div>
                    <div class='col l3 offset-l3 s12'>
                      <h5 class='white-text'>Links</h5>
                      <ul>
                        {$links}
                      </ul>
                    </div>
                  </div>
                </div>
                <div class='footer-copyright'>
                  <div class='container'>
                    &copy; 2018 Copyright Text
                  </div>
                </div>
              </footer>";


    $footer .= "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
                <script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js'></script>
                <script src='script.js'></script>
                </body>
                
                </html>";

    echo $footer;
  }

  function navbar(array $data)
  {
    $navbar = "";

    $logo = $data['logo'];
    $links = [];
    foreach ($data['links'] as $link) {
      $links[] = "<li class='$link[2]'>
                    <a href='$link[0]'>
                      <i class='left material-icons'>home</i> {$link[1]}</a>
                  </li>";
    }

    $navbar .= "<div class='navbar-fixed'>
                  <nav class='grey darken-3'>
                    <div class='container'>
                      <div class='nav-wrapper'>
                        <a href='#' class='brand-logo center'>
                          <div>
                            <span class='white-text'>Poke</span>
                            <img src='$logo'>
                            <span class='white-text'>Store</span>
                          </div>
                        </a>
                        <ul class='hide-on-med-and-down'>
                         {$links[0]}
                         {$links[1]}
                        </ul>
                        <ul class='right hide-on-med-and-down'>
                          {$links[2]}
                        </ul>
                      </div>
                    </div>
                  </nav>
                </div>";

    echo $navbar;
  }

  function search()
  {
    $search = "";
    $search .= "<div class='search-wrapper card input-field'>
                  <input id='search' type='search' placeholder='Search'>
                </div>";
    echo $search;
  }

  function addToCart($item)
  {
    $add = "";
    $add .= "<a data-pokemon='{$item}' class='btn green waves-effect waves-light add-to-cart'>
              <i class='left material-icons'>shopping_cart</i>Add</a>";
    return $add;
  }

  function paginationNavLink($classes, $icon)
  {
    return "<li class={$classes['li_link']}><a href='' class={$classes['a_link']}><i class='material-icons'> $icon</i></a></li>";
  }

  function paginationLink($page, $active)
  {
    return "<li class={$active}><a id={$page} href='' class='pagination_link'>{$page}</a></li>";
  }

  function cartItem($item)
  {
    $encodedCartItem = json_encode($item);
    $cartItem = "";
    $cartItem .= "<div class='valign-wrapper row card-panel z-depth-2 grey lighten-5 cart-item'>
                    <p class='col s5'>{$item["name"]}</p>
                    <p class='center col s2'>{$item["amount"]}</p>
                    <p class='center col s3'>$ " . $item["price"] . "</p>
                    <div class='col s2'>
                      <a data-pokemon='{$encodedCartItem}' class='remove-from-cart waves-effect btn red'>
                        <i class='material-icons'>close</i>
                      </a>
                    </div>
                  </div>";

    return $cartItem;
  }

  function empty($text)
  {
    return "<div class='center'>
              <img class='empty' src='./assets/img/gen1/Magikarp.gif'>
              <h5 class='blue-text'>{$text}</h5>
            </div>";
  }

  function inventoryItem($item)
  {
    $inventoryItem = "<tr>
              <td width='10%'>{$item->getName()}</td>
              <td width='10%'>
                <img style='max-width: 4rem' src='./assets/img/gen1/{$item->getImage()}'>
              </td>
              <td>{$item->getDescription()}</td>";

    $types = "";
    $typesArr = explode(",", $item->getType());

    foreach ($typesArr as $type) {
      $bgColor = "background-color: " . TYPES[$type];
      $types .= "<div style='$bgColor' class='type white-text'>
                  $type
                </div>";
    }

    $inventoryItem .= "<td width='9%' class='center'>{$types}</td>
                        <td width='10%' class='price center' >$ {$item->getPrice()}</td>
                        <td width='5%' class='quantity center'>{$item->getQuantity()}</td>
                        <td width=5%>
                          <a class='btn blue'>Edit</a>
                        </td>
                      </tr>";

    return $inventoryItem;
  }

  function catalogItem($item)
  {
    $encodedItem = json_encode($item);

    // item infos
    $name = $item->getName();
    $image = $item->getImage();
    $desc = $item->getDescription();

    return "<div class='col s3 left-align'>
              <div class='card sticky-action'>
                <div class='card-image waves-effect waves-block waves-light'>
                  <img class='activator' src='./assets/img/gen1/{$image}'>
                </div>
                <div class='card-content'>
                    <span class='card-title activator grey-text text-darken-4'>
                      {$name} <i class='material-icons right'>more_vert</i>
                    </span>
                </div>
                <div class='card-action'>
                  {$this->addToCart($encodedItem)}
                </div>
                <div class='card-reveal'>
                    <span class='item-name card-title grey-text text-darken-4'>
                      {$name} <i class='material-icons right'>close</i>
                    </span>
                  <p>{$desc}</p>
                </div>
              </div>
            </div>";
  }

  public function pagination($currentPage, $pages)
  {
    $pagination = "";

    // PREVIOUS ARROW
    $isDisabled = $currentPage == 1 ? ["li_link" => "disabled", "a_link" => "#!"] : ["li_link" => "waves-effect", "a_link" => "previous_link"];
    $pagination .= $this->paginationNavLink($isDisabled, "chevron_left");

    // LINKS
    for ($page = 1; $page <= $pages; $page++) {
      $isActive = $currentPage == $page ? "active" : "";
      $pagination .= $this->paginationLink($page, $isActive);
    }

    // NEXT ARROW
    $isDisabled = $currentPage == $pages ? ["li_link" => "disabled", "a_link" => "#!"] : ["li_link" => "waves-effect", "a_link" => "next_link"];
    $pagination .= $this->paginationNavLink($isDisabled, "chevron_right");

    return $pagination;
  }
}