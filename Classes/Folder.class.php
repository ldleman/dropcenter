<?php
class Folder extends JSONEntity{

	protected $id,$name,$parent,$isopen;
	protected $TABLE_NAME = 'folder';
	protected $CLASS_NAME = 'Folder';
	protected $object_fields = 
	array(
		'id'=>'key',
		'name'=>'string',
		'parent'=>'integer'
	);

	function __construct(){
		parent::__construct();
	}


	function getFolders(){
		$folderManager = new Folder();
		return $folderManager->loadAll(array('parent'=>$this->getId()));
	}


	function getId(){
		return $this->id;
	}

	function getName(){
		return $this->name;
	}

	function setName($name){
		$this->name = $name;
	}

	function getParent(){
		return $this->parent;
	}

	function setParent($parent){
		$this->parent = $parent;
	}

}

?>