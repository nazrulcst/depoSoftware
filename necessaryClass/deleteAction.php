<?php
	class Database{
		public $host='localhost';
		public $dbName='depo_management';
		public $chatset='utf-8';
		public $userName='root';
		public $password='';

		public function dbCon(){
			try{
				$db= new PDO("mysql:host=".$this->host.';dbname='.$dbName.';charset='.$this->chatset,$this->userName,$this->password);
				echo"Database connection successfully";
			}catch(PDOException $error){
				echo "Database connection is faild".$error->getMessage();
			}

		}
	}



