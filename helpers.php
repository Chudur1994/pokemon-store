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
$filteredTypes = [];

/**
 * @param array $availablePokemons Current array of pokemons
 * @param array $filteredPokemons Filtered array pokemons
 * @param array $filteredTypes
 * @param $type Type to filter
 */
function filterType(array $availablePokemons, array &$filteredPokemons, string $type)
{
  echo "<h4>Filtered: {$type}</h4>";
  $newFiltered = array_filter($availablePokemons, function ($pokemon) use ($type) {
    // if the type is found in the pokemon's array of types, return true
    return in_array($type, $pokemon->types);
  });
  // find out why array_merge wasn't working but '+' worked
  $filteredPokemons = $filteredPokemons + $newFiltered;
}

function unfilterType(array &$filteredPokemons, string $type)
{
  echo "<h4>Unfiltered: {$type}</h4>";
  // remove the pokemons from the filtered list that has the passed in type
  $filteredPokemons = array_filter($filteredPokemons, function ($pokemon) use ($type) {
    return !in_array($type, $pokemon->types);
  });
}

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


filterType($availablePokemons, $filteredPokemons, "flying");

debugTable($filteredPokemons);

echo "<hr>";

filterType($availablePokemons, $filteredPokemons, "fire");

debugTable($filteredPokemons);

echo "<hr>";

filterType($availablePokemons, $filteredPokemons, "poison");

debugTable($filteredPokemons);

echo "<hr>";

unfilterType($filteredPokemons, 'flying');

debugTable($filteredPokemons);

echo "<hr>";

filterType($availablePokemons, $filteredPokemons, "flying");

debugTable($filteredPokemons);

echo "<hr>";

unfilterType($filteredPokemons, 'fire');

debugTable($filteredPokemons);

echo "<hr>";

unfilterType($filteredPokemons, 'poison');

debugTable($filteredPokemons);

echo "<hr>";

filterType($availablePokemons, $filteredPokemons, "fire");

debugTable($filteredPokemons);

echo "<hr>";

filterType($availablePokemons, $filteredPokemons, "flying");

debugTable($filteredPokemons);

echo "<hr>";

unfilterType($filteredPokemons, 'fire');

debugTable($filteredPokemons);

echo "<hr>";

unfilterType($filteredPokemons, 'poison');

debugTable($filteredPokemons);

echo "<hr>";

unfilterType($filteredPokemons, 'flying');

debugTable($filteredPokemons);

echo "<hr>";