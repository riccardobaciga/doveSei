<?php
include_once("./admin/myApp.php");

mandatory("w");
checkInput("d",date("Ymd"));
checkInput("t",0);

    switch ($w) {
        case "getPosition":
            returnData(json_encode($myApp->gps->getPosition($t)));
        break;

        case "getTravel":
            returnData(json_encode($myApp->gps->getTravel($d)));
        break;
        
        case "getDates":
            returnData(json_encode($myApp->gps->getDates()));
        break;
        
        case "getUsers":
            returnData(json_encode($myApp->user->getUsers()));
        break;

        default:
        returnError("azione $w non corretta");

    }
