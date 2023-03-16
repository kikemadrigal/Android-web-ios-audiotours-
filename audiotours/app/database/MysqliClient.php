<?php
class MysqliClient{
	private $servidor;
	private $usuario;
	private $password;
	private $base_de_datos;
	private $resultado;
	private $mysqli_result;
	public $msqli;

	public function __construct(){
		$this->servidor=SERVER;
		$this->usuario=USER;
		$this->password=PASSWORD;
		$this->base_de_datos=DATABASE;
	}
	/* Realliza la conexión a la base de datos */
	public function conectar_mysql(){
        	$this->msqli = new mysqli($this->servidor, $this->usuario, $this->password,$this->base_de_datos);
        	$this->msqli->query("SET NAMES 'utf8'");
			//$this->mysqli_result=new mysqli_result();
			if($this->msqli->connect_errno){
				echo "<p>Error al conectar con el servidor.</p>";
				throw new Exception("Exception to connect Mysqli");
			}

	}

	public function getMysqliObject(){
		return $this->msqli;
	}

	public function getTables(){
		$tables=array();
		$resultado = $this->msqli->query("SHOW TABLES");
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$tables[]= $linea[0];
		}
		return $tables;
	}

	public function checkExitsToursTable(){
		$tables=$this->getTables();
		foreach($tables as $posicion=>$table){
			if ($table=="tours" || $table=="Tours"){
				return true;
			}
		}
		return false;
	}

	/*metodo para ejecutar una secuencia sql, retorna*/
	public function ejecutar_sql($sql){
		//envía una única consulta a la base de datos actualmente activa en el servidor 
		$this->resultado=$this->msqli->query($sql);
		if (!$this->resultado) {
			echo "<p>Error al ejecutar la consulta</p>";
			$this->resultado=NULL;
		}
		return $this->resultado;
	}






	public function insert($sql){
		//envía una única consulta a la base de datos actualmente activa en el servidor 
		//$sql=$this->msqli->real_escape_string($sql);
		$this->resultado=$this->msqli->query($sql);
		if (!$this->resultado) {
			echo "<p>Error al ejecutar la consulta</p>";
			$this->resultado=NULL;
		}
		return $this->resultado;
	}


	public function getLastId(){
		return mysqli_insert_id($this->msqli);
	}

	public function deleteTableGames(){
		if($this->msqli->query("DROP TABLE games")){
			echo "<p>tabla borrada</p>";
		}else{
			echo "<p>no se pudo borrar</p>";
		}
	}



	public function getStringInsertTableGamesUsers(){
		$contador=0;
		$consulta="INSERT INTO 'gamesUsers' VALUES ";
		$resultado2 = $this->msqli->query("SELECT * FROM gamesUsers");
		$rows=$this->msqli->affected_rows;
		if($rows<=0) return "";
		while ($linea = mysqli_fetch_array($resultado2)) 
		{
			$contador++;
			$consulta .="<br>&nbsp;&nbsp;&nbsp;&nbsp;(";
			$consulta .=$linea['id'].",";
			$consulta .="'".$linea['title']."',";
			$consulta .="".$linea['cover'].",";
			$consulta .="'".$linea['instructions']."',";
			$consulta .="'".$linea['country']."',";
			$consulta .="'".$linea['publisher']."',";
			$consulta .="'".$linea['developer']."',";
			$consulta .="".$linea['year'].",";
			$consulta .="'".$linea['format']."',";
			$consulta .="'".$linea['genre']."',";
			$consulta .="'".$linea['system']."',";
			$consulta .="'".$linea['programming']."',";
			$consulta .="'".$linea['sound']."',";
			$consulta .="'".$linea['control']."',";
			$consulta .="".$linea['players'].",";
			$consulta .="'".$linea['languages']."',";
			$consulta .="".$linea['iGoIt'].",";
			$consulta .="".$linea['broken'].",";
			if($contador==$rows) $consulta .="'".$linea['observations']."');<br><br>";
			else $consulta .="'".$linea['observations']."'),";
		}        
		return $consulta;	
	}
	
		
	
	
	//Desconectar y liberar
	public function desconectar(){
		//$this->resultado->free();
		$this->msqli->close();
	}

}

?>