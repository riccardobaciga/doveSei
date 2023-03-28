<?php
class meteo_Class extends myDb_Class
{
	function getMeteo($posX, $posY, $precisione = 1, $debug=false)
	{
		$timeSpam = date('YmdH');
		$posX = round($posX, $precisione);
		$posY = round($posY, $precisione);
		$result = [];
		$result["x"] = $posX;
		$result["y"] = $posY;
		$result["ico"] = "";
		$result["description"] = "";
		$result["wind"] = "";
		$result["temperature"] = "";

		if ($posX == 0 || $posY == 0) {
		    $rows[0]["icon"] = "";
		}else {
		    // echo "SELECT icon FROM meteo WHERE user = '$user' AND X = $posX AND Y = $posY AND T = '$timeSpam'";
		    $rows = [];
		}

		if (count($rows) === 0) {

            $json_string = "http://api.openweathermap.org/data/2.5/weather?lat=$posX&lon=$posY&APPID=< your appl id>";

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

			$ico = $suffix.$obj['weather'][0]['id'];


			$result["ico"] = "wi wi-owm". $ico;
		    $result["description"] = $obj['weather'][0]["description"];
			$result["wind"] = $this->calcolaVento($obj['wind']['speed'])[0];
			$result["windIco"] = "wi wi-wind-beaufort-".$this->calcolaVento($obj['wind']['speed'])[1];
			$result["temperature"] = $obj['main']['temp']."&#8451;";
			$result["nome"] = $obj['name'];

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
