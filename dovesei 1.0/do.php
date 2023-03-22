<?php
include_once("./admin/myApp.php");

mandatory("w");
mandatory("password");
if (createKey($password) === "<your password cripted>'"){

    switch ($w) {
        case "cancellaOggi":
            returnData(json_encode($myApp->gps->deleteToday(date("Ymd"))));
        break;

        default:
            returnError("azione $w non corretta");
    }

}else{
    returnError("Password non corretta");
}
