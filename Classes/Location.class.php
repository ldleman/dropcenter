<?php

/*
	@nom: Location
	@auteur: Valentin CARRUESCO (valentincarruesco@yahoo.fr)
	@date de création: 23/12/2011 05:27:29
	@description: Gestion des adresses utilisateurs
	Les attributs de la classe sont les suivants :
	<li>Town</li>
	<li>ZipCode</li>
	<li>Country</li>
	<li>Street</li>
*/

class Location
{
	
	private $town;
	private $zipCode;
	private $country;
	private $street;
	private $debug = 0;
	private $id;
	//Ces deux constantes définissent le type de retour pour les fonction loadAll, load, populate ...
	const OBJECT = 'OBJECT';
	const JSON = 'JSON';
	
	public function __construct($town=null, $zipCode=null, $country=null, $street=null ){
		//Opérations du constructeur...
		if($town!=null) $this->town=$town;
		if($zipCode!=null) $this->zipCode=$zipCode;
		if($country!=null) $this->country=$country;
		if($street!=null) $this->street=$street;
	}
	
	
	public function __call($methode, $attributs){
		//Action sur appel d'une méthode inconnue
	}
	
	
	public function __destruct(){
		//Action lors du unset de l'objet
	}
	
	
	public function __toString(){
		$retour = "instance de la classe Location : <br/>";
		$retour .= '$id : '.$this->getId().'<br/>';
		$retour .= '$debug : '.$this->getDebug().'<br/>';
		$retour .= 'Town : '.$this->town.'<br/>';
		$retour .= 'ZipCode : '.$this->zipCode.'<br/>';
		$retour .= 'Country : '.$this->country.'<br/>';
		$retour .= 'Street : '.$this->street.'<br/>';
		return $retour;
	}
	
	
	public  function __clone(){
		//Action lors du clonage de l'objet Location
	}
	
	
	/**
	* Methode de mise en session de l'objet Location
	* @author Valentin CARRUESCO
	* @category SESSION
	* @param <String> $name=nom de la classe, definis la clé de l'objet en session
	* @return Aucun retour
	*/
	public function session($name="Location"){
		$_SESSION[$name] = serialize($this);
	}
	
	
	/**
	* Methode de traduction de l'objet Location en json (necessite au minimum de PHP 5.2 et de l'extension l'extension JSON de PECL)
	* @author Valentin CARRUESCO
	* @category SESSION
	* @require PHP 5.2
	* @require extension JSON de PECL
	* @require encodage UTF-8
	* @return code json
	*/
	public function toJson(){
		$jsonArray['id']= $this->id;
		$jsonArray['debug']= $this->debug;
		$jsonArray['town']= $this->town;
		$jsonArray['zipCode']= $this->zipCode;
		$jsonArray['country']= $this->country;
		$jsonArray['street']= $this->street;
		return json_encode($jsonArray);
	}
	
	
	// GESTION SQL

	/**
	* Methode de suppression de la table Location
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function destroy($debug=0)
	{
		$query = 'DROP TABLE IF EXISTS location;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de nettoyage de la table Location
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function truncate($debug=0)
	{
			$query = 'TRUNCATE TABLE location;';
			if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de creation de la table Location
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function create($debug=0){
		$query = 'CREATE TABLE IF NOT EXISTS `location` (';
		$query .= '`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,';
		$query .='`town`    NOT NULL,';
		$query .='`zipCode`    NOT NULL,';
		$query .='`country`    NOT NULL,';
		$query .='`street`    NOT NULL';
		$query .= ');';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode d'insertion ou de modifications d'elements de la table Location
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param  Aucun
	* @return Aucun retour
	*/
	public function save(){
		if(isset($this->id)){
			$query = 'UPDATE `location`'.
			' SET '.
			'`town`="'.$this->town.'",'.
			'`zipCode`="'.$this->zipCode.'",'.
			'`country`="'.$this->country.'",'.
			'`street`="'.$this->street.'"'.
			' WHERE `id`="'.$this->id.'";';
		}else{
			$query = 'INSERT INTO `location`('.
			'`town`,'.
			'`zipCode`,'.
			'`country`,'.
			'`street`'.			
			')VALUES('.
			'"'.$this->town.'",'.
			'"'.$this->zipCode.'",'.
			'"'.$this->country.'",'.
			'"'.$this->street.'"'.
			');';
		}
		if($this->debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		mysql_query($query)or die(mysql_error());
		if(!isset($this->id)) $this->id = mysql_insert_id ();
	}

	/**
	* Méthode de modification d'éléments de la table Location
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes
	* @param <Array> $valeurs
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $operation="=" definis le type d'operateur pour la requete select
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function change($keys,$values,$keys2,$values2,$operation='=',$debug=0){
		$query = 'UPDATE `location` SET ';
		for ($i=0;$i<sizeof($keys);$i++){
		$query .= '`'.$keys[$i].'`="'.$values[$i].'" ';
		if($i<sizeof($keys)-1)$query .=',';
		}
		$query .=' WHERE '; 
		for ($i=0;$i<sizeof($keys2);$i++){
		$query .= '`'.$keys2[$i].'`'.$operation.'"'.$values2[$i].'" ';
		if($i<sizeof($keys2)-1)$query .='AND ';
		}
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		mysql_query($query)or die(mysql_error());
	}

	/**
	* Méthode de selection de tous les elements de la table Location
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<Location>> $Locations
	*/
	public static function populate($order=null,$limit=null,$return=Location::OBJECT,$debug=0){
		return Location::loadAll(array(),array(),$order,$limit,'=',$return,$debug);
	}

	/**
	* Méthode de selection multiple d'elements de la table Location
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $operation="=" definis le type d'operateur pour la requete select
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<Location>> $Locations
	*/
	public static function loadAll($columns,$values,$order=null,$limit=null,$operation="=",$return=Location::OBJECT,$debug=0){
		$locations = array();
		$whereClause = '';
		if(sizeof($columns)==sizeof($values)){
			if(sizeof($columns)!=0){
			$whereClause .= ' WHERE ';
				for($i=0;$i<sizeof($columns);$i++){
					if($i!=0)$whereClause .= ' AND ';
					$whereClause .= '`'.$columns[$i].'`'.$operation.'"'.$values[$i].'"';
				}
			}
			$query = 'SELECT * FROM `location` '.$whereClause.' ';
			if($order!=null) $query .='ORDER BY `'.$order.'` ';
			if($limit!=null) $query .='LIMIT '.$limit.' ';
			$query .=';';
			if($debug==1) echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$execQuery = mysql_query($query);
			while($queryReturn = mysql_fetch_assoc($execQuery)){
				$location = new Location();
				$location->id= $queryReturn["id"];
				$location->town= $queryReturn["town"];
				$location->zipCode= $queryReturn["zipCode"];
				$location->country= $queryReturn["country"];
				$location->street= $queryReturn["street"];
				if($return==Location::JSON) $location = $location->toJson();
				$locations[] = $location;
				unset($location);
			}
		}else{
			exit ('Location.'.__METHOD__.') -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
			if($return==Location::JSON) $locations = json_encode($locations);
			return $locations;
	}

	/**
	* Méthode de selection unique d'élements de la table Location
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $operation="=" definis le type d'operateur pour la requete select
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Location> $Location ou false si aucun objet n'est trouvé en base
	*/
	public static function load($columns,$values,$operation='=',$return=Location::OBJECT,$debug=0){
		$locations = Location::loadAll($columns,$values,null,'1',$operation,$return,$debug);
		if(!isset($locations[0]))$locations[0] = false;
		return $locations[0];
	}

	/**
	* Methode de comptage des éléments de la table location
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return<Integer> nombre de ligne dans la table des location
	*/
	public static function rowCount($debug=0)
	{
		$query = 'SELECT COUNT(*) FROM location';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
		$number = mysql_fetch_array($myQuery);
		return $number[0];
	}	
	
	/**
	* Méthode de supression d'elements de la table Location
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $operation="=" definis le type d'operateur pour la requete select
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function delete($columns,$values,$operation='=',$debug=0){
		$whereClause = '';
		if(sizeof($columns)==sizeof($values)){
			for($i=0;$i<sizeof($columns);$i++){
				if($i!=0)$whereClause .= ' AND ';
				$whereClause .= '`'.$columns[$i].'`'.$operation.'"'.$values[$i].'"';
			}
			$query = 'DELETE FROM `location` WHERE '.$whereClause.' ;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			mysql_query($query);
		}else{
			exit ('Location.'.__METHOD__.' -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
	}
	
	
	// ACCESSEURS

	/**
	* Méthode de récuperation de l'attribut id de la classe Location
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> id
	*/
	
	public function getId(){
		return $this->id;
	}
	
	/**
	* Méthode de définition de l'attribut id de la classe Location
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	*/

	public function setId($id){
		$this->id = $id;
	}
	
		/**
	* Méthode de récuperation de l'attribut debug de la classe Location
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> debug
	*/
	
	public function getDebug(){
		return $this->debug;
	}
	
	/**
	* Méthode de définition de l'attribut debug de la classe Location
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <boolean> $debug 
	*/

	public function setDebug($debug){
		$this->debug = $debug;
	}

	/**
	* Méthode de récuperation de l'attribut Town de la classe Location
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> town
	*/

	public function getTown(){
		return $this->town;
	}

	/**
	* Méthode de définition de l'attribut Town de la classe Location
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $town
	* @return Aucun retour
	*/

	public function setTown($town){
		$this->town = $town;
	}

	/**
	* Méthode de récuperation de l'attribut ZipCode de la classe Location
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> zipCode
	*/

	public function getZipCode(){
		return $this->zipCode;
	}

	/**
	* Méthode de définition de l'attribut ZipCode de la classe Location
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $zipCode
	* @return Aucun retour
	*/

	public function setZipCode($zipCode){
		$this->zipCode = $zipCode;
	}

	/**
	* Méthode de récuperation de l'attribut Country de la classe Location
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> country
	*/

	public function getCountry(){
		return $this->country;
	}

	/**
	* Méthode de définition de l'attribut Country de la classe Location
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $country
	* @return Aucun retour
	*/

	public function setCountry($country){
		$this->country = $country;
	}

	/**
	* Méthode de récuperation de l'attribut Street de la classe Location
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> street
	*/

	public function getStreet(){
		return $this->street;
	}

	/**
	* Méthode de définition de l'attribut Street de la classe Location
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $street
	* @return Aucun retour
	*/

	public function setStreet($street){
		$this->street = $street;
	}

}
?>
