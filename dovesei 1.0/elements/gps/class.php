<?php

class gps_Class extends myDb_Class {
    
    function insertGPSPoint($k,$x,$y,$z,$v,$t,$d){
        
        $sql = "SELECT idUser FROM user WHERE password = '".$k."' ";
        $idUser = $this->get_row($sql)['idUser'];
        
        $sql="INSERT INTO `gpsPosition` (`idUser`, `x`, `y`, `z`, `v`, `t`, `d`) 
              VALUES ('$idUser','$x','$y','$z','$v','$t','$d')";

        return $this->insertQuery($sql);
                
    }
    
    function deleteToday($d){
            
        $sql = "Select COUNT(*) AS totale FROM gpsPosition WHERE D = $d";
        $totale = $this->get_row($sql)['totale'];
        
        $sql = "DELETE FROM gpsPosition WHERE D = $d";
        $this->query($sql);
         
        return "Sono state cancellate $totale righe.";
    }
    function getDates(){
         $sql = "SELECT d, count(*) AS n FROM gpsPosition GROUP BY d ORDER BY d DESC";
         
        return $this->get_results($sql);
    }
    
    function getTravel($d){
        $sql = "SELECT idUser, nome, colore FROM user WHERE idUser IN (SELECT distinct(idUser) FROM gpsPosition A  WHERE d = $d)";
        $users = $this->get_results($sql);
        foreach($users as $key => $user){
            $sql = "SELECT * FROM gpsPosition WHERE d = $d AND idUser = ".$user['idUser']." ORDER BY t ASC";
            $travel = $this->get_results($sql);
            $users[$key]["travel"] = $travel;
        }
        
        return $users;
    }
    
    
    
    function getPosition($t){
        $sql = "SELECT idUser, nome, colore FROM user WHERE idUser IN (SELECT distinct(idUser) FROM gpsPosition A  WHERE t > $t)";
        $users = $this->get_results($sql);
        
        foreach($users as $key => $user){
            $sql = "SELECT * FROM gpsPosition WHERE t >= $t AND idUser = ".$user['idUser']." ORDER BY t ASC";
            // echo ($sql);
            $travel = $this->get_results($sql);
            $users[$key]["travel"] = $travel;
        }
        
        return $users;
    }
    
}
$myApp->gps = new gps_Class();