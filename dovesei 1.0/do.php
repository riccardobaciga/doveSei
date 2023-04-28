<?php
include_once("./admin/myApp.php");

mandatory("w");
mandatory("password");
if (createKey($password) === "nafefSL.a/.8Q"){
    
    switch ($w) {
        case "cancellaOggi":
            returnData(json_encode($myApp->gps->deleteToday(date("Ymd"))));
        break;
          
        break;
        default:
            returnError("azione $w non corretta");
    }
    
}else{
    returnError("Password non corretta");
}
