<?php

abstract class Item
{
  protected $price = 0.0;
  protected $quantity = 0;
  protected $sale = 0.0;
  protected $image = "";

  /**
   * @return float
   */
  public function getPrice(): float
  {
    return $this->price;
  }

  /**
   * @param float $price
   */
  public function setPrice(float $price): void
  {
    $this->price = $price;
  }

  /**
   * @return int
   */
  public function getQuantity(): int
  {
    return $this->quantity;
  }

  /**
   * @param int $quantity
   */
  public function setQuantity(int $quantity): void
  {
    $this->quantity = $quantity;
  }

  /**
   * @return float
   */
  public function getSale(): float
  {
    return $this->sale;
  }

  /**
   * @param float $sale
   */
  public function setSale(float $sale): void
  {
    $this->sale = $sale;
  }

  /**
   * @return string
   */
  public function getImage(): string
  {
    return $this->image;
  }

  /**
   * @param string $image
   */
  public function setImage(string $image): void
  {
    $this->image = $image;
  }
}