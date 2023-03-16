<?php

Class Tour {
	private $id;
	private $name;
	private $latitude;
	private $longitude;
	//Es el id de la tabla type que contiene un campo nombre="castillo, museo, etc"
	private $type;
	private $media;
	private $image;
	private $blogUrl;
	private $address;
	private $phone;
	private $web;
	private $description;
	private $date;
	//Es el id de la tabla de usuarios, el 1 es el administrador murcia
	private $userId;


	
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
	function setLatitude($latitude){
		$this->latitude=$latitude;
	}
	function setLongitude($longitude){
		$this->longitude=$longitude;
	}
	function setType($type){
		$this->type=$type;
	}
	function setMedia($media){
		$this->media=$media;
	}
	function setImage($image){
		$this->image=$image;
	}
	function setBlogUrl($blogUrl){
		$this->blogUrl=$blogUrl;
	}
	function setAddress($address){
		$this->address=$address;
	}
	function setPhone($phone){
		$this->phone=$phone;
	}
	function setWeb($web){
		$this->web=$web;
	}
	function setDescription($description){
		$this->description=$description;
	}
	
	function setDate($date){
		$this->date=$date;
	}
	function setUserId($userId){
		$this->userId=$userId;
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
	function getLatitude(){
		return $this->latitude;
	}
	function getLongitude(){
		return $this->longitude;
	}
	function getType(){
		return $this->type;
	}
	function getMedia(){
		return $this->media;
	}
	function getImage(){
		return $this->image;
	}
	function getBlogUrl(){
		return $this->blogUrl;
	}
	function getAddress(){
		return $this->address;
	}
	function getPhone(){
		return $this->phone;
	}
	function getWeb(){
		return $this->web;
	}
	function getDescription(){
		return $this->description;
	}
	function getDate(){
		return $this->date;
	}
	function getUserId(){
		return $this->userId;
	}
	
	
	
	
	/**
	 * TODTRING
	 */
	function toString(){
		return"<br>Tour id: ".$this->id.", name: ".$this->name.", latitude: ".$this->latitude.", longitude: ".$this->longitude.", type: ".$this->type.", media: ".$this->media.", description: ".$this->description.", date: ".$this->date.", userId: ".$this->userId;	
	}

	
	
}

?>