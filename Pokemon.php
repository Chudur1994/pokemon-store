<?php

require_once "Item.php";

class Pokemon extends Item implements JsonSerializable
{
  private $name = "";
  private $description = "";
  private $type = "";

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
   * @return string
   */
  public function getType(): string
  {
    return $this->type;
  }

  /**
   * @param string $type
   */
  public function setType(string $type): void
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