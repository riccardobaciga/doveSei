<?php
    debug("UNO");
    echo '{"message":"Ciao"}';
    
function debug($msg){
    $nomeFile = "./myApp.debug";
    $debugFile = fopen($nomeFile, "a") or die("Unable to open file! $nomeFile");
    fwrite($debugFile, $msg);
    fclose($debugFile);
}