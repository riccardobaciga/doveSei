<?php
class meteo_Class extends myDb_Class
{
	function getMeteo($posX, $posY, $idUser, $precisione, $debug=false)
	{
		$timeSpam = date('YmdH');
		$posX = round($posX, $precisione);
		$posY = round($posY, $precisione);
		$result = [];
        // chiave
		$result["x"] = $posX;
		$result["y"] = $posY;
        $result["d"] = date("YmdH");
        // output
		$result["idUser"] = $idUser;

        $result["localita"] = "";
		$result["ico"] = "";
		$result["description"] = "";
		$result["ventoIco"];
		$result["vento"] = "";
		$result["temperatura"] = "";
        $rows = [];

		if ($posX == 0 || $posY == 0) {
		    $rows[0]["icon"] = "";
		}else {
		    $sql = "SELECT * FROM meteo where x = $posX AND y = $posY AND d = $timeSpam";
            $rows = $this->get_row($sql)['totale'];
		}
		
		if (count($rows) === 0) {
            
            $json_string = "http://api.openweathermap.org/data/2.5/weather?lat=$posX&lon=$posY&APPID={your applid}";
			
			$jsondata = file_get_contents($json_string);
            $obj = json_decode($jsondata, true);
  
            if ($debug){
                echo "<pre>";
                print_r($obj);
                echo "</pre>";
            }
            
			$now = date('U'); //get current time
  
            if($now > $obj['sys']['sunrise'] and $now < $obj['sys']['sunset']){
                $suffix = '-day-';
            }else{
                $suffix = '-night-';
            }

			$icon = $suffix.$obj['weather'][0]['id'];
            
            $localita = $obj['name'];
            $ico = "wi wi-owm". $icon;
			$description = $obj['weather'][0]["description"];
            $ventoIco = "wi wi-wind-beaufort-".$this->calcolaVento($obj['wind']['speed'])[1];
            $vento = $this->calcolaVento($obj['wind']['speed'])[0];
            $temperatura = $obj['main']['temp']."&#8451;";

			$result["localita"] = $obj['name'];
			$result["ico"] = "wi wi-owm". $icon;
		    $result["description"] = $obj['weather'][0]["description"];
			$result["ventoIco"] = "wi wi-wind-beaufort-".$this->calcolaVento($obj['wind']['speed'])[1];
			$result["vento"] = $this->calcolaVento($obj['wind']['speed'])[0];
			$result["temperatura"] = $obj['main']['temp']."&#8451;";
			
            
            
            $sql = "INSERT INTO `meteo` (`x`, `y`, `d`, `localita`, `ico`, `description`, `ventoIco`, `vento`, `temperatura`) VALUES ('$posX', '$posY', '$timeSpam', '$localita', '$ico', '$description', '$ventoIco', '$vento', '$temperatura');";
            
            $this->insertQuery($sql);
		}else{
			$result["localita"] = $rows["localita"] ;
			$result["ico"] = $rows["ico"];
		    $result["description"] = $rows["description"];
			$result["ventoIco"] = $rows["ventoIco"];
			$result["vento"] = $rows["vento"];
			$result["temperatura"] = $rows["temperatura"];
        }

		return $result;
	}

	function  calcolaVento($velocitaStr)
	{
		$result = "";
		$velocita = floatval($velocitaStr);
		if ($velocita < 0.2) $result = ["assenza di vento",0];
		else if ($velocita < 1.5) $result = ["bava di vento",1];
		else if ($velocita < 3.3) $result = ["brezza leggera",2];
		else if ($velocita < 5.4) $result = ["brezza leggera",3];
		else if ($velocita < 7.9) $result = ["vento moderato",4];
		else if ($velocita < 10.7) $result = ["vento teso",5];
		else if ($velocita < 13.8) $result = ["vento fresco",6];
		else if ($velocita < 17.1) $result = ["vento forte",7];
		else if ($velocita < 20.7) $result = ["burrasca",8];
		else if ($velocita < 24.4) $result = ["burrasca forte",9];
		else if ($velocita < 28.4) $result = ["forti tempeste",10];
		else if ($velocita < 32.6) $result = ["tempesta violenta",11];
		else if ($velocita >= 32.7) $result = ["uragano",12];
		return $result;
	}
}

$myApp->meteo = new meteo_Class();