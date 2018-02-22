<?php

require_once "CartSingleton.php";
require_once "Pokemon.php";

$pikachu = new Pokemon();
$pikachu->setName("Pikachu");
$pikachu->setDesc("Hi, i'm pikachu!");
$pikachu->setImage("Link to pikachu's image");
$pikachu->setPrice(9.99);
$pikachu->setQuantity(4);
$pikachu->setSale(7.99);
$pikachu->setType(["Normal", "Electric"]);

$charizard = new Pokemon();
$charizard->setName("Charizard");
$charizard->setDesc("Hi, i'm Charizard!");
$charizard->setImage("Link to Charizard's image");
$charizard->setPrice(12.99);
$charizard->setQuantity(2);
$charizard->setSale(8.99);
$charizard->setType(["Flying", "Fire"]);


CartSingleton::addItem($pikachu);
CartSingleton::print();
echo CartSingleton::totalPrice();
echo "<hr>";

CartSingleton::addItem($pikachu);
CartSingleton::print();
echo CartSingleton::totalPrice();
echo "<hr>";

CartSingleton::addItem($charizard);
CartSingleton::print();
echo CartSingleton::totalPrice();
echo "<hr>";

CartSingleton::removeItem($charizard);
CartSingleton::print();
echo CartSingleton::totalPrice();