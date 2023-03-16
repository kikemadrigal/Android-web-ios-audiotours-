<?php
Class Media {
	private $id;
	private $name;
    private $path;
	private $isHeader;
    private $date;
    private $typeId;
    private $userId;
	private $tourId;

	function __construct($id){
		$this->id=$id;
	}

	function setName($name){
		$this->name=$name;
	}
	function setPath($path){
		$this->path=$path;
	}
	function setIsHeader($isHeader){
		$this->isHeader=$isHeader;
	}
	function setDate($date){
		$this->date=$date;
	}

    function setUserId($userId){
		$this->userId=$userId;
	}
	function setTypeId($typeId){
		$this->typeId=$typeId;
	}
    function setTourId($tourId){
		$this->tourId=$tourId;
	}
	

	
	function getId(){
		return $this->id;	
	}
	function getName(){
		return $this->name;
	}
	function getPath(){
		return $this->path;
	}
	function getIsHeader(){
		return $this->isHeader;
	}
    function getDate(){
		return $this->date;
	}

    function getTypeId(){
		return $this->typeId;
	}
	function getUserId(){
		return $this->userId;
	}
    function getTourId(){
		return $this->tourId;
	}


	
	function toString(){
		return "Media: Id: ".$this->id.", name: ".$this->name;	
	}
}