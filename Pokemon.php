<?php

class Pokemon
{
  private $name = "";
  private $image = "";
  private $desc = "";
  private $price = 0.0;
  private $quantity = 0;
  private $sale = 0.0;
  private $type = [];
  private $stats = [];
  private $moves = [];

  /**
   * Pokemon constructor.
   */
  public function __construct()
  {
  }

  /**
   * @return string
   */
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * @param string $name
   */
  public function setName(string $name): void
  {
    $this->name = $name;
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

  /**
   * @return string
   */
  public function getDesc(): string
  {
    return $this->desc;
  }

  /**
   * @param string $desc
   */
  public function setDesc(string $desc): void
  {
    $this->desc = $desc;
  }

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
   * @return array
   */
  public function getType(): array
  {
    return $this->type;
  }

  /**
   * @param array $type
   */
  public function setType(array $type): void
  {
    $this->type = $type;
  }

  /**
   * @return array
   */
  public function getStats(): array
  {
    return $this->stats;
  }

  /**
   * @param array $stats
   */
  public function setStats(array $stats): void
  {
    $this->stats = $stats;
  }

  /**
   * @return array
   */
  public function getMoves(): array
  {
    return $this->moves;
  }

  /**
   * @param array $moves
   */
  public function setMoves(array $moves): void
  {
    $this->moves = $moves;
  }


}