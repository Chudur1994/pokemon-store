<?php

class CartSingleton
{
  private static $items = [];
  private static $totalPrice = 0.0;
  private const TAX = 0.08875;

  private function __construct()
  {
  }

  /**
   * @param $pokemon the pokemon object being removed from the cart
   */
  static function removeItem($pokemon)
  {
    // if the cart has the item that needs to be removed
    if (array_key_exists($pokemon->getName(), self::$items)) {
      echo "{$pokemon->getName()} has been removed from the cart";
      unset(self::$items[$pokemon->getName()]);
      self::$totalPrice -= $pokemon->getPrice();
    } else {
      echo "{$pokemon->getName()} doesn't exist in the cart";
    }
  }

  /**
   * @param $pokemon the pokemon object being added to cart
   */
  static function addItem($pokemon)
  {
    // TODO: Below validation needs to be implemented
    // if the store has the sufficient amount
    self::$items[$pokemon->getName()][] = $pokemon;
    self::$totalPrice += $pokemon->getPrice();
    echo "{$pokemon->getName()} has been added to the cart...";
  }


  /**
   * used for debuggin
   */
  static function print()
  {
    // if cart not empty
    if (!empty(self::$items)) {
      foreach (self::$items as $pokemons) {
        foreach ($pokemons as $pokemon) {
          echo "<ul>
              <li>{$pokemon->getName()}</li>
              <li>{$pokemon->getDesc()}</li>
              <li>{$pokemon->getImage()}</li>
              <li>{$pokemon->getPrice()}</li>
              <li>{$pokemon->getQuantity()}</li>
              <li>{$pokemon->getSale()}</li>
            </ul>";
        }
      }
    }
  }

  /**
   * @return float? maybe string?
   */
  static function totalPrice()
  {
    return number_format(self::$totalPrice + self::$totalPrice * self::TAX, 2, '.', ',');
  }

  /**
   * @return array pokemons in cart
   */
  static function getItems()
  {
    return self::$items;
  }
}