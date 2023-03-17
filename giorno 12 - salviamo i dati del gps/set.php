<?php
include_once("./admin/myApp.php");

mandatory("k");
mandatory("x");
mandatory("y");
mandatory("z");
mandatory("v");
mandatory("t");
checkInput("d",date("Ymd"));

$d = str_replace("-","",$d);
$z = round($z, 0);

$myApp->gps->insertGPSPoint($k,$x,$y,$z,$v,$t,$d);

