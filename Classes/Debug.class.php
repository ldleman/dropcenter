<?php

/*
	@nom: debug
	@auteur: Valentin CARRUESCO (valentin.carruesco@sys1.fr)
	@date de création: 07/10/2011 à 23:06
	@description: Classe de gestion des informations de debug
*/

class Debug
{
	private $id;
	private $conteneur;
	public  $debug=0;

	public function __construct($conteneur=null){
		//Opérations du constructeur...
		if($conteneur!=null) $this->conteneur=$conteneur;
	}

	public function __call($methode, $attributs){
		//Action sur appel d'une méthode inconnue
	}

	public function __toString(){
		$retour = "";
		$retour .= "instance de la classe Debug : <br/>";
		$retour .= '$conteneur : '.$this->conteneur.'<br/>';
		return $retour;
	}

	public  function __clone(){
		//Action lors du clonage de l'objet
	}

	/**
	* Methode de mise en session de l'objet debug
	* @author Valentin CARRUESCO
	* @category SESSION
	* @param <String> $name=nom de la classe, definis la clé de l'objet en session
	* @return Aucun retour
	*/

	public function session($name=debug){
		$_SESSION[$name] = serialize($this);
	}


	// ACCESSEURS

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	/**
	* Méthode de récuperation de l'attribut conteneur de la classe Debug
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> conteneur
	*/

	public function get(){
		return $this->conteneur;
	}


		/**
	* Méthode de définition de l'attribut conteneur de la classe Debug
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $conteneur
	* @return Aucun retour
	*/
	public function put($msg){
		$this->conteneur.= "<br/>";
		$this->conteneur.= $msg;
		$this->conteneur.= "-------------------------";
		$this->conteneur.= "<br/>";
	}


}
?>