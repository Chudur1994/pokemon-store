<?php

$availablePokemons = [(object)['types' => ['grass', 'poison']],
                      (object)['types' => ['fire']],
                      (object)['types' => ['fire', 'flying']],
                      (object)['types' => ['fire', 'flying']],
                      (object)['types' => ['water']],
                      (object)['types' => ['bug']],
                      (object)['types' => ['bug', 'flying']],
                      (object)['types' => ['bug', 'poison']],
                      (object)['types' => ['normal', 'flying']],
                      (object)['types' => ['normal']],
                      (object)['types' => ['poison']],
                      (object)['types' => ['electric']],
                      (object)['types' => ['ground']],
                      (object)['types' => ['poison', 'ground']],
                      (object)['types' => ['poison', 'flying']],
                      (object)['types' => ['grass', 'poison']],
                      (object)['types' => ['bug', 'grass']]];

$filteredItems = [];

/**
 * @param array $availableItems All items in stock
 * @param array $filteredItems Current list of filtered items
 * @param string $type Type to filter by
 */
function filterType(array $availableItems, array &$filteredItems, string $type)
{
  $newFiltered = array_filter($availableItems, function ($item) use ($type) {
    // if the type is found in the item's array of types, return true
    return in_array($type, $item->types);
  });
  // find out why array_merge wasn't working while '+' worked
  $filteredItems = $filteredItems + $newFiltered;
}

/**
 * @param array $filteredItems Current list of filtered items
 * @param string $type Type to unfilter by
 */
function unfilterType(array &$filteredItems, string $type)
{
  // remove the items from the filtered list that has the passed in type
  $filteredItems = array_filter($filteredItems, function ($item) use ($type) {
    return !in_array($type, $item->types);
  });
}

/**
 * @param $item Item to add
 * @param $inventory Current inventory
 * @return bool True if successful, else false
 */
function addToInventory($item, &$inventory)
{
  // do some validation before adding...
  if (true) {
    $inventory[$item->getName()] = $item;
    return true;
  } else {
    return false;
  }
}

/**
 * @param $item Item to remove
 * @param $inventory Current inventory
 * @return bool True if successfully removed, else false
 */
function removeFromInventory($item, &$inventory)
{
  // do some validation before removing...
  if (true) {
    unset($inventory[$item->getName()]);
    return true;
  } else {
    return false;
  }
}

/**
 * @param $item Item to update
 * @param $inventory Current inventory
 * @return bool True if successfully updated, else false
 */
function updateInventory($item, &$inventory)
{
  // do some validation before updating...
  if (true) {
    $inventory[$item->getName()] = $item;
  } else {
    return false;
  }
}

// used for debugging filtering functions
function debugTable(array $data)
{
  echo "<table>";
  foreach ($data as $item) {
    echo "<tr>";
    foreach ($item->types as $type) {
      echo "<td>{$type}</td>";
    }
    echo "</tr>";
  }
  echo "</table>";
}