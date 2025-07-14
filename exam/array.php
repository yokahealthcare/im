<?php


$a = array([1,2,3,4,5,6,7,8,9]);
$name = "Erwin Yonata";

$a = explode(" ", $name);
print_r($a);

echo "<br>";

$firstname = substr($name, strpos($name, "Yonata"));
printf($firstname);

echo "<br>";

print_r(str_split($name));

echo "<br>";

printf(strlen($name));


