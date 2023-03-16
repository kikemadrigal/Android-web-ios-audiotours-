<?php
class Comment{
    private $id;
    private $name;
	private $father;
    private $date;

    	/**
	 * CONSTRUCTOR
	 */
	function __construct($id){
		$this->id=$id;
	}
	

	/**
	 * SETTERS
	 */

    function setName($name){
		$this->name=$name;
	}
	function setFaher($father){
		$this->father=$father;
	}
    function setDate($date){
		$this->date=$date;
	}

    
	/**
	 * GETTERS
	 */
	function getId(){
		return $this->id;	
	}
	function getName(){
		return $this->name;
	}
	function getFather(){
		return $this->father;
	}
    function getDate(){
		return $this->date;
	}
}




?>