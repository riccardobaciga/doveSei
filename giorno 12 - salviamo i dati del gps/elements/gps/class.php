<?php

class gps_Class extends myDb_Class {
    
    function insertGPSPoint($k,$x,$y,$z,$v,$t,$d){
        
        $sql = "SELECT idUser FROM user WHERE password = '".$k."' ";
        $idUser = $this->get_row($sql)['idUser'];
        
        $sql="INSERT INTO `gpsPosition` (`idUser`, `x`, `y`, `z`, `v`, `t`, `d`) 
              VALUES ('$idUser','$x','$y','$z','$v','$t','$d')";

        return $this->insertQuery($sql);
                
    }
    
    function getTravel($d){
        return true;
    }
    
    
    
    function getPosition($d, $t){
        return true;
    }
    
}
$myApp->gps = new gps_Class();