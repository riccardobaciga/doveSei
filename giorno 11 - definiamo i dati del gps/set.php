<?php
foreach ($_GET as $k => $v)
{
   debug ("variabile GET ->$k<- -->$v<-- <br>\n"); // $k la "chiave", $v  il valore
}

debug ("<hr>\n");

function debug($msg){
    $nomeFile = "./positionLog.debug";
    $debugFile = fopen($nomeFile, "a") or die("Unable to open file! $nomeFile");
    fwrite($debugFile, $msg);
    fclose($debugFile);
}