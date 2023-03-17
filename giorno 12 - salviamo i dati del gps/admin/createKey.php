<?php
include_once(__DIR__."/myApp.php");
$orig = "riccardo";
$crypted = createKey($orig);

echo " orig -->$orig<-- crypted -->$crypted<-- ";