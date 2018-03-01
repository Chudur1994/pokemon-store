<?php

include_once "data.php";

$pokemon_file = 'pokemon_data.txt';
$handle = fopen($pokemon_file, 'a') or die('Cannot open file:  ' . $pokemon_file);

$curl_arr = array();
$master = curl_multi_init();

for ($i = 0; $i < count($pokemons[0]); $i++) {
  $url = $pokemons[0][$i];
  $curl_arr[$i] = curl_init($url);
  curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
  curl_multi_add_handle($master, $curl_arr[$i]);
}

do {
  curl_multi_exec($master, $running);
} while ($running > 0);


for ($i = 0; $i < count($pokemons[0]); $i++) {
  $result = []; // reset result for next pokemon
  $data = ""; // reset data for next pokemon

  $result = json_decode(curl_multi_getcontent($curl_arr[$i]), true);

  $data = ucfirst($result["name"]) . ","; // add name to text file

  // add types to text file
  foreach ($result["types"] as $type) {
    $data .= ucfirst($type["type"]["name"]) . ",";
  }

  $data .= "\n";
  echo $data;

  fwrite($handle, $data);

  curl_multi_remove_handle($master, $curl_arr[$i]);
}


curl_multi_close($master);
fclose($handle);