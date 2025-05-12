<?php 

class Connection{
	const host="localhost";
	const username="root";
	const password="";
	const dbname="momo";
	private $conn=null;

	
	public function connect(){

		$options=[
			PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
			PDO::ATTR_PERSISTENT=>true


		];

		try{


		if($this->conn==null){
			$this->conn=new PDO("mysql:host=".self::host.";dbname=".self::dbname,self::username,self::password,$options);
			
		}
        return $this->conn;

	}
	catch(PDOException $e){
		echo "Error:".$e->getMessage();
	}
	}



}

 ?>