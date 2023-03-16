<?php
function createKey($string){
    $chiave = '< inserisci la tua chiave>';
    return crypt($string, $chiave );
}
echo createKey("nome");