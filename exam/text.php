<?php

printf("Hellow <br>");

$price = 1234.56;
$formattedPrice = sprintf("The price is: $%08.2f", $price);
echo $formattedPrice;

echo "<br>";

$haystack = "Lorem Ipsum, next Ipsum statement";

printf(strchr($haystack, "Ipsum"));

echo "<br>";

printf(strrchr($haystack, "Ipsum"));

echo "<br>";








