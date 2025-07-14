<?php

setcookie("name1", "erwinyonata", time() + (86400), "/");

if(isset($_COOKIE['name1'])) {
    echo "Cookie name : " . $_COOKIE['name1'];
} else {
    echo "not seen cookie";
}