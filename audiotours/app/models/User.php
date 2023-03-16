<?php
/*
CREATE TABLE `usuarios` (
  `idusuario` smallint(6) UNSIGNED NOT NULL,
  `nombreusuario` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `claveusuario` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `nivelaccesousuario` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `correousuario` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `nombrerealusuario` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `apellidosusuario` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `webusuario` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `validadousuario` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `contadorusuario` int(100) NOT NULL,
  `fechaRegistroUsuario` varchar(500) COLLATE latin1_spanish_ci NOT NULL,
  `datosusuario` longtext COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
*/
Class User {
	private $id;
	private $name;
	private $password;
	private $role;
	private $email;
	private $realName;
	private $surname;
	private $web;
	private $validate;
	private $counter;
	private $date;
	private $view;
	private $observations;
	
	function __construct($id){
		$this->id=$id;
	}

	function setName($name){
		$this->name=$name;
	}
	function setPassword($password){
		$this->password=$password;
	}
	function setRole($role){
		$this->role=$role;	
	}
	
	function setEmail($email){
		$this->email=$email;
	}
	function setRealName($realName){
		$this->realName=$realName;
	}
	function setSurname($surname){
		$this->surname=$surname;
	}
	function setWeb($web){
		$this->web=$web;
	}
	function setValidate($validate){
		$this->validate=$validate;
	}
	function setCounter($counter){
		$this->counter=$counter;
	}
	function setDate($date){
		$this->date=$date;
	}
	function setView($view){
		$this->view=$view;
	}
	function setObservations($observations){
		$this->observations;
	}
	







	/**
	 * GETTERS
	 */
	function getId(){
		return $this->id;
	}
	function getIdUsuario(){
		return $this->idUsuario;	
	}
	function getName(){
		return $this->name;
	}
	function getPassword(){
		return $this->password;
	}
	function getRole(){
		return $this->role;
	}
	function getEmail(){
		return $this->email;
	}
	function getRealName(){
		return $this->realName;
	}
	function getSurname(){
		return $this->surname;
	}
	function getWeb(){
		return $this->web;
	}

	function getValidate(){
		return $this->validate;
	}
	function getCounter(){
		return $this->counter;
	}
	function getDate(){
		return $this->date;
	}
	function getView(){
		return $this->view;
	}
	function getObservations(){
		return $this->observations;
	}
	
	
	function toString(){
		return "Id: ".$this->id."User: ".$this->name;	
	}
	
	
}

?>