<?php

require_once "Item.php";

class Pokemon extends Item implements JsonSerializable
{
  private $name = "";
  private $description = "";
  private $type = [];

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
   * Specify data which should be serialized to JSON
   */
  public function jsonSerialize()
  {
    return array(
      'price' => $this->price,
      'quantity' => $this->quantity,
      'name' => $this->name,
      'sale' => $this->sale,
      'image' => $this->image,
      'types' => $this->type,
      'description' => $this->description
    );
  }
}