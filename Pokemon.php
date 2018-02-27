<?php

require_once "Item.php";

class Pokemon extends Item
{
  private $name = "";
  private $description = "";
  private $type = [];
  private $stats = [];
  private $moves = [];

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
  public function getDescription(): string
  {
    return $this->description;
  }

  /**
   * @param string $description
   */
  public function setDescription(string $description): void
  {
    $this->description = $description;
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