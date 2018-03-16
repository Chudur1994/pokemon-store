<?php
require_once "DB.php";

session_start(); // start session

class Cart
{
  private $items = [];
  private $totalPrice = 0.0;
  private const TAX = 0.08875;
  private $db;
  private $pdo;

  /**
   * Cart constructor.
   */
  public function __construct()
  {
    $this->db = DB::getInstance();
    $this->pdo = $this->db->getConnection();

    // get cart data from session if it exists
    $this->items = !empty($_SESSION['cart-items']) ? $_SESSION['cart-items'] : array();
    $this->totalPrice = !empty($_SESSION['cart-total']) ? $_SESSION['cart-total'] : 0.0;
  }

  /**
   * @param Item $removedItem The item that will be removed from the cart.
   * @return bool
   */
  public function removeFromCart(Item $removedItem)
  {
    // index of item being removed
    $index = array_search($removedItem->getName(), array_column($this->items, 'name'));
    $amount = $this->items[$index]['amount'];

    $query = "UPDATE products SET quantity = quantity + {$amount} WHERE name = '{$removedItem->getName()}'";
    if ($this->pdo->query($query)) {
      $removedItem->setQuantity($removedItem->getQuantity() + $amount);
      $price = $removedItem->getPrice() + $removedItem->getPrice() * self::TAX;
      $this->totalPrice -= $price * $amount;
      unset($this->items[$index]);
      $this->items = array_values($this->items);
      $this->saveCart(); // save to session
    }
  }

  /**
   * @param Item $newItem The new item being added to the cart.
   * @return array Message to display to user
   */
  public function addToCart(Item $newItem)
  {
    if ($newItem->getQuantity() > 0) {
      $this->items = array_values($this->items); // reindex array of items

      /*if the item being added is already in the cart, then index will contain the index
      of the item in the cart, else it will be false*/
      $index = array_search($newItem->getName(), array_column($this->items, 'name'));

      $price = empty($newItem->getSale()) ? $newItem->getPrice() : $newItem->getSale();

      if ($index !== false) {
        $this->items[$index]['amount'] += 1;
      } else {
        $this->items[] = ['name' => $newItem->getName(), 'amount' => 1, 'price' => $price];
      }
      $query = "UPDATE products SET quantity = quantity - 1 WHERE name = '{$newItem->getName()}'";
      if ($this->pdo->query($query)) {
        $newItem->setQuantity($newItem->getQuantity() - 1);
        $this->totalPrice += $price + $price * self::TAX;
        $this->saveCart(); // save to session
        $msg = ["Added to Cart", "blue"];
      } else {
        $msg = ["Failed to Add to Cart", "red"];
      }
    } else {
      $msg = ["Failed to Add to Cart", "red"];
    }

    return $msg;
  }

  /**
   * @return string
   */
  public function getTotalPrice()
  {
    return number_format($this->totalPrice, 2, '.', ',');
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

  function getTax()
  {
    return self::TAX * 100;
  }
}