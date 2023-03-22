<?php
class myDb_Class {
		var $db;
		var $insert_id;
		/*
			Connessione al database tramite i parametri indicati
		*/
	 
		function __construct(){
			$this->connetToDB();
		}

		private function connetToDB(){
			global $myApp;
			try{
				if ($myApp->database->typeDB === "mysql"){
					$dbhost = $myApp->database->hostDB;
					$dbusername = $myApp->database->userDB;   
					$dbpassword = $myApp->database->passwordDB;   
					$dbname = $myApp->database->databaseDB;
					$this->db = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
				}
				if ($myApp->config->type === "sqlite"){
					$nomeDB = $myApp->database->pathDB.$myApp->database->fileNameDB;
					$this->db = new PDO("sqlite:".$nomeDB);
				}
				
			}catch(PDOException $e) {
                $this->SQLError("__construct", "inizialize", $e->getMessage());
			}
		}
		
		function get_results ($query) {
			global $myApp;

			try{
				$this->connetToDB();
				$statement = $this->db->query($query);
				return $statement->fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e) {
                $this->SQLError("get_results", "$query", $e->getMessage());
			}
		}
	
		/*
			input: una query di tipo INSERT, UPDATE, DELETE
			output: se la query va a buon fine true, altrimenti false
		*/
		function query( $query ) {
			try{
			    
				$this->connetToDB();
			    $this->db->exec($query);
			}catch(PDOException $e) {
				$this->SQLError("query", "$query", $e->getMessage());
			}
			return true;
		}
		
        public function insertQuery ($query){
			
			try{
				$this->connetToDB();
				$statement = $this->db->query($query);
				return $this->db->lastInsertId();
			}catch(PDOException $e) {
				$this->SQLError("get_results", "$query", $e->getMessage());
			}
			
        }   

        public function get_row ($query){
			
			$items = $this->get_results ($query);
			
			if (count($items) > 0) {
				return $items[0];
			} else {
				return null;
			}
        }
 
        public function cleanString($quale)
        {
             $toReplace = ['à','è','é','ì','ò','ù',"'",'"'];
             $replaced = ['a','e','e','i','o','u'," ",' '];
             return str_replace($toReplace, $replaced, $quale);
        }

        private function SQLError($mehod, $query, $error){
            die ("{\"result\":\"KO\",\"description\":\"DB ERROR: Mehod $mehod executing<br> ->$query<- <br>$error\"}");
        }
}