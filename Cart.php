<?php
session_start(); // start session

class Cart
{
  private $items = [];
  private $totalPrice = 0.0;
  private const TAX = 0.08875;

  /**
   * Cart constructor.
   */
  public function __construct()
  {
    // get cart data from session if it exists
    $this->items = !empty($_SESSION['cart-items']) ? $_SESSION['cart-items'] : [];
    $this->totalPrice = !empty($_SESSION['cart-total']) ? $_SESSION['cart-total'] : 0.0;
  }


  /**
   * @param Item $removedItem The item that will be removed from the cart.
   * @param int $amount
   */
  public function removeFromCart(Item $removedItem, int $amount)
  {
    // index of item being removed
    $index = array_search($removedItem->getName(), array_column($this->items, 'name'));

    if (($this->items[$index]['amount'] - $amount) == 0) {
      // no more items of that type in cart remaining
      unset($this->items[$index]);
      $this->items = array_values($this->items);
    } else {
      // there are items remaining
      $this->items[$index]['amount'] -= $amount;
    }

    $price = empty($removedItem->getSale()) ? $removedItem->getPrice() : $removedItem->getSale();
    $this->totalPrice -= $price * $amount;
    $this->saveCart(); // save to session
  }

  /**
   * @param Item $newItem The new item being added to the cart.
   */
  public function addToCart(Item $newItem)
  {
    $this->items = array_values($this->items); // reindex array of items

    /*if the item being added is already in the cart, then index will contain the index
    of the item in the cart, else it will be false*/
    $index = array_search($newItem->getName(), array_column($this->items, 'name'));
    if ($index !== false) {
      $this->items[$index]['amount'] += 1;
    } else {
      $this->items[] = ['name' => $newItem->getName(), 'amount' => 1];
    }

    $price = empty($newItem->getSale()) ? $newItem->getPrice() : $newItem->getSale();
    $this->totalPrice += $price;
    $this->saveCart(); // save to session
  }


  /**
   * used for debugging
   */
  public function print()
  {
    // if cart not empty
    if (!empty($this->items)) {
      echo "<table>";
      foreach ($this->items as $item) {
        echo "<tr>";
        echo "<td>{$item['name']}</td>";
        echo "<td>{$item['amount']}</td>";
        echo "</tr>";
      }
      echo "</table><hr>";
    }
  }

  /**
   * @return string
   */
  public function getTotalPrice()
  {
    return number_format($this->totalPrice + $this->totalPrice * self::TAX, 2, '.', ',');
  }

  /**
   * @return array
   */
  public function getItems(): array
  {
    return $this->items;
  }

  /**
   * save the current cart info to session
   */
  protected function saveCart()
  {
    $_SESSION['cart-items'] = $this->items;
    $_SESSION['cart-total'] = $this->getTotalPrice();
  }

  /**
   * Reset cart values and unset session variables
   */
  public function destroyCart()
  {
    // reset values
    $this->items = [];
    $this->totalPrice = 0.0;

    unset($_SESSION['card-items']);
    unset($_SESSION['card-total']);

    session_destroy(); // is this the right place to destroy session?
  }
}