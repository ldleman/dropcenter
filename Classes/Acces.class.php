<?php

/*
	@nom: acces
	@auteur: Valentin CARRUESCO (valentin.carruesco@sys1.fr)
	@date de création: 07/10/2011 à 11:30
	@description: Gestion des acces aux differentes parties du site en fonction du rang utilisateur
*/

class Acces
{
	private $id;
	private $section;
	private $update;
	private $create;
	private $delete;
	private $read;
	public $debug=0;
	private $dateCreation;

	public function __construct($section=null,$update=null,$create=null,$delete=null,$read=null,$dateCreation=null){
		//Opérations du constructeur...
		if($section!=null) $this->section=$section;
		if($update!=null) $this->update=$update;
		if($create!=null) $this->create=$create;
		if($delete!=null) $this->delete=$delete;
		if($read!=null) $this->read=$read;
		if($dateCreation!=null) $this->$dateCreation=$dateCreation;
	}

	public function __call($methode, $attributs){
		//Action sur appel d'une méthode inconnue
	}

	public function __destruct(){
		//Action lors du unset de l'objet
	}

	public function __toString(){
		$retour = "";
		$retour .= "instance de la classe Acces : <br/>";
		$retour .= '$section : '.$this->section.'<br/>';
		$retour .= '$update : '.$this->update.'<br/>';
		$retour .= '$create : '.$this->create.'<br/>';
		$retour .= '$delete : '.$this->delete.'<br/>';
		$retour .= '$read : '.$this->read.'<br/>';
		$retour .= '$dateCreation : '.$this->dateCreation.'<br/>';
		return $retour;
	}

	public  function __clone(){
		//Action lors du clonage de l'objet
	}

	/**
	* Methode de mise en session de l'objet acces
	* @author Valentin CARRUESCO
	* @category SESSION
	* @param <String> $name=nom de la classe, definis la clé de l'objet en session
	* @return Aucun retour
	*/

	public function session($name=acces){
		$_SESSION[$name] = serialize($this);
	}

	// GESTION SQL

	/**
	* Methode de suppression de la table acces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function destroy($debug=0)
	{
		$query = 'DROP TABLE IF EXISTS acces;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de nettoyage de la table acces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function truncate($debug=0)
	{
			$query = 'TRUNCATE TABLE acces;';
			if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de creation de la table acces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function create($debug=0){
		$query = 'CREATE TABLE IF NOT EXISTS `acces` (';
		$query .= '`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,';
		$query .='`section` VARCHAR ( 225 )  NOT NULL';$query .=',';
		$query .='`update` VARCHAR ( 225 )  NOT NULL';$query .=',';
		$query .='`create` VARCHAR ( 225 )  NOT NULL';$query .=',';
		$query .='`dateCreation` VARCHAR ( 225 )  NOT NULL';$query .=',';
		$query .='`delete` VARCHAR ( 225 )  NOT NULL';$query .=',';
		$query .='`read` VARCHAR ( 225 )  NOT NULL';
		$query .= ');';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode d'insertion ou de modifications d'elements de la table acces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param  Aucun
	* @return Aucun retour
	*/

	public function save(){
		if(isset($this->id)){
			$query = 'UPDATE acces'.
			' SET '.
			'`section`="'.$this->section.'"'.','.
			'`update`="'.$this->update.'"'.','.
			'`create`="'.$this->create.'"'.','.
			'`delete`="'.$this->delete.'"'.','.
			'`dateCreation`="'.$this->dateCreation.'"'.','.
			'`read`="'.$this->read.'"'.			
			' WHERE id="'.$this->id.'";';
		}else{
			$query = 'INSERT INTO acces('.
			'`section`'.','.
			'`update`'.','.
			'`create`'.','.
			'`delete`'.','.
			'`dateCreation`'.','.
			'`read`'.			
			')VALUES("'.
			$this->section.'","'.
			$this->update.'","'.
			$this->create.'","'.
			$this->delete.'","'.
			$this->dateCreation.'","'.
			$this->read.			
			'");';
		}
		if($this->debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		mysql_query($query)or die(mysql_error());
	}

	/**
	* Méthode de modification d'éléments de la table acces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes
	* @param <Array> $valeurs
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/

	public static function change($keys,$values,$keys2,$values2,$debug=0){
		$query = 'UPDATE `acces`'.
				' SET ';
		for ($i=0;$i<sizeof($keys);$i++){
		$query .= '`'.$keys[$i].'`="'.$values[$i].'" ';
		if($i<sizeof($keys)-1)$query .=',';
		}
		$query .=' WHERE '; 
		for ($i=0;$i<sizeof($keys2);$i++){
		$query .= '`'.$keys2[$i].'`="'.$values2[$i].'" ';
		if($i<sizeof($keys2)-1)$query .='AND ';
		}
		/*if($debug==1)*/echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		mysql_query($query)or die(mysql_error());
	}

	/**
	* Méthode de selection de tous les elements de la table acces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<Acces>> $access
	*/

	public static function populate($order=null,$limit=null,$debug=0){
		return Acces::loadAll(array(),array(),$order,$limit,$debug);
	}

	/**
	* Méthode de selection multiple d'elements de la table acces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<Acces>> $access
	*/

	public static function loadAll($columns,$values,$order=null,$limit=null,$debug=0){
		$access = array();
		$whereClause = '';
		if(sizeof($columns)==sizeof($values)){
		if(sizeof($columns)!=0){
		$whereClause .= ' WHERE ';
			for($i=0;$i<sizeof($columns);$i++){
				if($i!=0)$whereClause .= ' AND ';
				$whereClause .= $columns[$i].'="'.$values[$i].'"';
			}
		}
			$query = 'SELECT * FROM acces '.$whereClause.' ';
			if($order!=null) $query .='ORDER BY '.$order.' ';
			if($limit!=null) $query .='LIMIT '.$limit.' ';
			$query .=';';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$execQuery = mysql_query($query);
			while($queryReturn = mysql_fetch_assoc($execQuery)){
				$acces = new Acces();
				$acces->id= $queryReturn["id"];
				$acces->section= $queryReturn["section"];
				$acces->update= $queryReturn["update"];
				$acces->create= $queryReturn["create"];
				$acces->dateCreation= $queryReturn["dateCreation"];
				$acces->delete= $queryReturn["delete"];
				$acces->read= $queryReturn["read"];
				$access[] = $acces;
				unset($acces);
			}
		}else{
			exit ('Acces.'.__METHOD__.') -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
			return $access;
	}


	public static function loadSection(){
		$sections = Section::populate();
		foreach($sections as $section){
			$acces = new Acces();
			$acces->section= $section->getId();
			$listeAcces[]=$acces;
			unset($acces);
		}
		return $listeAcces;
	}

	/**
	* Méthode de selection unique d'elements de la table acces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Acces> $acces
	*/

	public static function load($columns,$values,$debug=0){
		$whereClause = '';
		if(sizeof($columns)==sizeof($values)){
		if(sizeof($columns)!=0){
		$whereClause .= ' WHERE ';
			for($i=0;$i<sizeof($columns);$i++){
				if($i!=0)$whereClause .= ' AND ';
				$whereClause .= '`'.$columns[$i].'`="'.$values[$i].'"';
			}
		}
			$query = 'SELECT * FROM acces '.$whereClause.' ;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$queryReturn = mysql_fetch_assoc(mysql_query($query));
			$acces = new Acces();
			$acces->id= $queryReturn["id"];
			$acces->section= $queryReturn["section"];
			$acces->update= $queryReturn["update"];
			$acces->create= $queryReturn["create"];
			$acces->dateCreation= $queryReturn["dateCreation"];
			$acces->delete= $queryReturn["delete"];
			$acces->read= $queryReturn["read"];
		}else{
			exit ('Acces.'.__METHOD__.' -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
			return $acces;
	}

	/**
	* Méthode de supression d'elements de la table acces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/

	public static function delete($columns,$values,$debug=0){
		$whereClause = '';
		if(sizeof($columns)==sizeof($values)){
			for($i=0;$i<sizeof($columns);$i++){
				if($i!=0)$whereClause .= ' AND ';
				$whereClause .= $columns[$i].'="'.$values[$i].'"';
			}
			$query = 'DELETE FROM acces WHERE '.$whereClause.' ;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			mysql_query($query);
		}else{
			exit ('Acces.'.__METHOD__.' -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
	}

	// ACCESSEURS

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	/**
	* Méthode de récuperation de l'attribut section de la classe Acces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> section
	*/

	public function getSectionId(){
		return $this->section;
	}
	public function getSection(){
		return Section::load(array('id'),array($this->section));
	}

	/**
	* Méthode de définition de l'attribut section de la classe Acces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $section
	* @return Aucun retour
	*/

	public function setSection($section){
		$this->section = $section;
	}

	/**
	* Méthode de récuperation de l'attribut update de la classe Acces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> update
	*/

	public function getUpdate(){
		return $this->update;
	}

	/**
	* Méthode de définition de l'attribut update de la classe Acces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $update
	* @return Aucun retour
	*/

	public function setUpdate($update){
		$this->update = $update;
	}

	/**
	* Méthode de récuperation de l'attribut create de la classe Acces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> create
	*/

	public function getCreate(){
		return $this->create;
	}

	/**
	* Méthode de définition de l'attribut create de la classe Acces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $create
	* @return Aucun retour
	*/

	public function setCreate($create){
		$this->create = $create;
	}

	/**
	* Méthode de récuperation de l'attribut delete de la classe Acces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> delete
	*/

	public function getDelete(){
		return $this->delete;
	}

	/**
	* Méthode de définition de l'attribut delete de la classe Acces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $delete
	* @return Aucun retour
	*/

	public function setDelete($delete){
		$this->delete = $delete;
	}

	/**
	* Méthode de récuperation de l'attribut read de la classe Acces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> read
	*/

	public function getRead(){
		return $this->read;
	}

	/**
	* Méthode de définition de l'attribut read de la classe Acces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $read
	* @return Aucun retour
	*/

	public function setRead($read){
		$this->read = $read;
	}
	
	public function getDateCreation(){
		return $this->dateCreation;
	}
	public function setDateCreation($date){
		$this->dateCreation = $date;
	}
	
}
?>