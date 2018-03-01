<?php

$availableTypes = ['fire', 'water', 'grass', 'ghost', 'electric', 'rock', 'steel'];

 function filterType(string $type)
{
  print_r(array_filter($availableTypes, function($pokeTypes) {
    return in_array($type, $pokeTypes);
  });
}