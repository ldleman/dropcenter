<?php

/*
	@nom: Configuration
	@auteur: Idleman
	@description: Classe de gestion des configurations dynamique du script
	Les attributs de la classe sont les suivants :
	<li>Key</li>
	<li>Value</li>
*/

class Configuration extends JSONEntity{
{
	
	protected $key,$value,$id;
	protected $TABLE_NAME = 'configuration';
	protected $CLASS_NAME = 'Configuration';
	protected $object_fields = 
	array(
		'id'=>'key',
		'key'=>'string',
		'value'=>'longstring'
	);
	
	function __construct(){
		parent::__construct();
	}

	
	// ACCESSEURS

	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getKey(){
		return $this->key;
	}

	public function setKey($key){
		$this->key = $key;
	}

	public function getValue(){
		return $this->value;
	}

	public function setValue($value){
		$this->value = $value;
	}

}
?>