<?php
include_once("./admin/myApp.php");
// debug("parametri ->".inputVariables()."<-");

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
        
        case "getMeteo":
            mandatory("x");
            mandatory("y");
            checkInput("idUser",0);
            checkInput("p",1);
            returnData(json_encode($myApp->meteo->getMeteo($x,$y,$idUser,$p)));
        break;

        case "getMeteoD":
            // https://dovesei.altervista.org/get.php?w=getMeteoD&x=undefined&y=9.94195&p=1
            mandatory("x");
            mandatory("y");
            checkInput("idUser",0);
            checkInput("p",1);
            returnData(json_encode($myApp->meteo->getMeteo($x,$y,$idUser,$p,true)));
        break;


        default:
            returnError("azione $w non corretta");

    }
