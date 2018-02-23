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

$filteredPokemons = [];

/**
 * @param array $availablePokemons All pokemons in stock
 * @param array $filteredPokemons Current list of filtered pokemons
 * @param string $type Type to filter by
 */
function filterType(array $availablePokemons, array &$filteredPokemons, string $type)
{
  $newFiltered = array_filter($availablePokemons, function ($pokemon) use ($type) {
    // if the type is found in the pokemon's array of types, return true
    return in_array($type, $pokemon->types);
  });
  // find out why array_merge wasn't working but '+' worked
  $filteredPokemons = $filteredPokemons + $newFiltered;
}

/**
 * @param array $filteredPokemons Current list of filtered pokemons
 * @param string $type Type to unfilter by
 */
function unfilterType(array &$filteredPokemons, string $type)
{
  // remove the pokemons from the filtered list that has the passed in type
  $filteredPokemons = array_filter($filteredPokemons, function ($pokemon) use ($type) {
    return !in_array($type, $pokemon->types);
  });
}

/**
 * @param $pokemon Pokemon to add
 * @param $inventory Current inventory
 * @return bool True if successful, else false
 */
function addToInventory($pokemon, &$inventory)
{
  // do some validation before adding...
  if (true) {
    $inventory[$pokemon->getName()] = $pokemon;
    return true;
  } else {
    return false;
  }
}

/**
 * @param $pokemon Pokemon to remove
 * @param $inventory Current inventory
 * @return bool True if successfully removed, else false
 */
function removeFromInventory($pokemon, &$inventory)
{
  // do some validation before removing...
  if (true) {
    unset($inventory[$pokemon->getName()]);
    return true;
  } else {
    return false;
  }
}

/**
 * @param $pokemon Pokemon to update
 * @param $inventory Current inventory
 * @return bool True if successfully updated, else false
 */
function updateInventory($pokemon, &$inventory)
{
  // do some validation before updating...
  if (true) {
    $inventory[$pokemon->getName()] = $pokemon;
  } else {
    return false;
  }
}


// used for debugging filtering functions
function debugTable(array $data)
{
  echo "<table>";
  foreach ($data as $pokemon) {
    echo "<tr>";
    foreach ($pokemon->types as $type) {
      echo "<td>{$type}</td>";
    }
    echo "</tr>";
  }
  echo "</table>";
}