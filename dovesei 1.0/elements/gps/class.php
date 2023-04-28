<?php

class gps_Class extends myDb_Class {
    
    function insertGPSPoint($k,$x,$y,$z,$v,$t,$d){
        global $myApp;

        $sql = "SELECT idUser FROM user WHERE password = '".$k."' ";
        $idUser = $this->get_row($sql)['idUser'];
        
        $sql="INSERT INTO `gpsPosition` (`idUser`, `x`, `y`, `z`, `v`, `t`, `d`, `l`) 
              VALUES ('$idUser','$x','$y','$z','$v','$t','$d','0')";
              
        $this->insertQuery($sql);
        
        $this->updateDistance ($d,$idUser);
        
        
        return true;
                
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
    
    function updateDistance ($d, $idUser, $limit = 500){
        
        $sql = "SELECT * FROM gpsPosition WHERE d = $d AND idUser = $idUser ORDER BY t ASC LIMIT $limit";
        $tmp = $this->get_results($sql);
        
        $prev = null;
        foreach($tmp as $point){
            
            if ($prev !== null){
                $oldDistance = $point["l"];
                $point["l"] = round($prev["l"] + $this->lung($point["x"], $point["y"], $prev["x"], $prev["y"]), 2);
                if ($oldDistance !== $point["l"]){
                    $this->query("UPDATE gpsPosition SET l = ".$point["l"]." WHERE t = ".$point["t"]);
                }
            }
            
            $prev = $point;
            
        }
        
    }
    
    function lung($Lat1, $Lng1, $Lat2, $Lng2) {
            // echo "$Lat1, $Lng1, $Lat2, $Lng2 ".(6371 * 3.1415926 * sqrt(($Lat1 - $Lat2) * ($Lat1 - $Lat2) + cos($Lng1 / 57.29578) * cos($Lng2 / 57.29578) * ($Lng1 - $Lng2) * ($Lng1 - $Lng2)) / 180)."<br>"; 
			return (6371 * 3.1415926 * sqrt(($Lat1 - $Lat2) * ($Lat1 - $Lat2) + cos($Lng1 / 57.29578) * cos($Lng2 / 57.29578) * ($Lng1 - $Lng2) * ($Lng1 - $Lng2)) / 180);
	}
    
}
$myApp->gps = new gps_Class();