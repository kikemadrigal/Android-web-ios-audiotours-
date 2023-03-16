<?php
class CommentRepositoty{
    public static function getAll($start, $end){
		$scores=array();
		$basededatos= new MysqliClient();
		$basededatos->conectar_mysql();
		$consulta  = "SELECT * FROM coments ORDER BY score DESC LIMIT ".$start .", ".$end." ";
		$resultado=$basededatos->ejecutar_sql($consulta);
		while ($linea = mysqli_fetch_array($resultado)) 
		{
			$score=new Comment($linea['id']);
			$score->setName($linea['name']);
			$score->setScore($linea['score']);
			$score->setDate($linea['date']);
			$scores[]=$score;
		}
		$basededatos->desconectar();
		return $scores;
	}
}



?>