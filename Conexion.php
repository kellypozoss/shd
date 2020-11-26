<?php
	class Conexion {
		private $Host ="";
		private $User ="";
		private $Password ="";
		private $Database ="";
		private $Connection;
	
		public function __construct(){
			$this-> Host = "b2lxsiervngbrckn3vrq-mysql.services.clever-cloud.com";
            $this-> User = "ua0u8jilk1bobxhd";
            $this-> Password = "7k8XbL2I71gs6Y8prC14";
			$this-> Database = "b2lxsiervngbrckn3vrq";
		}

		public function OpenConnection() {
			try
			{
				$this-> Connection = new PDO("mysql:host={$this->Host}; dbname={$this->Database}" , $this->User , $this->Password);
				$this-> Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch(PDOException $e){
				$this-> Connection=false;
			}
		}

		public function CloseConnection(){
			mysql_close($this-> Connection);
		}

		public function GetConnection(){
			return $this-> Connection;
		}
	}
	/*$Obj = new Conexion();
    $Obj-> OpenConnection();
    if($Obj-> GetConnection())
        echo "Ok";
    else 
        echo "Error";*/
 ?>