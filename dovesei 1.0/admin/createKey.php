<?php
include_once(__DIR__."/myApp.php");
$orig = "YOU R KEY;
$crypted = createKey($orig);

echo " orig -->$orig<-- crypted -->$crypted<-- ";