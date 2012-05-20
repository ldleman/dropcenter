<?php

/*
	@nom: Configuration
	@auteur: Valentin CARRUESCO (valentin.carruesco@sys1.fr)
	@date de création: 12/12/2011 09:18:18
	@description: Classe de gestion des configurations personnelles de chaque utilisateurs.
	Les attributs de la classe sont les suivants :
	<li>Key</li>
	<li>Value</li>
	<li>Date</li>
	<li>User</li>
*/

class Configuration
{
	
	private $key;
	private $value;
	private $date;
	private $user;
	private $debug = 0;
	private $id;
	//Ces deux constantes définissent le type de retour pour les fonction loadAll, load, populate ...
	const OBJECT = 'OBJECT';
	const JSON = 'JSON';
	
	public function __construct($key=null, $value=null, $date=null, $user=null ){
		//Opérations du constructeur...
		if($key!=null) $this->key=$key;
		if($value!=null) $this->value=$value;
		if($date!=null) $this->date=$date;
		if($user!=null) $this->user=$user;
	}
	
	
	public function __call($methode, $attributs){
		//Action sur appel d'une méthode inconnue
	}
	
	
	public function __destruct(){
		//Action lors du unset de l'objet
	}
	
	
	public function __toString(){
		$retour = "instance de la classe Configuration : <br/>";
		$retour .= '$id : '.$this->getId().'<br/>';
		$retour .= '$debug : '.$this->getDebug().'<br/>';
		$retour .= 'Key : '.$this->key.'<br/>';
		$retour .= 'Value : '.$this->value.'<br/>';
		$retour .= 'Date : '.$this->date.'<br/>';
		$retour .= 'User : '.$this->user.'<br/>';
		return $retour;
	}
	
	
	public  function __clone(){
		//Action lors du clonage de l'objet Configuration
	}
	
	
	/**
	* Methode de mise en session de l'objet Configuration
	* @author Valentin CARRUESCO
	* @category SESSION
	* @param <String> $name=nom de la classe, definis la clé de l'objet en session
	* @return Aucun retour
	*/
	public function session($name="Configuration"){
		$_SESSION[$name] = serialize($this);
	}
	
	
	/**
	* Methode de traduction de l'objet Configuration en json (necessite au minimum de PHP 5.2 et de l'extension l'extension JSON de PECL)
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
		$jsonArray['key']= $this->key;
		$jsonArray['value']= $this->value;
		$jsonArray['date']= $this->date;
		$jsonArray['user']= $this->user;
		return json_encode($jsonArray);
	}
	
	
	// GESTION SQL

	/**
	* Methode de suppression de la table Configuration
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function destroy($debug=0)
	{
		$query = 'DROP TABLE IF EXISTS configuration;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de nettoyage de la table Configuration
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function truncate($debug=0)
	{
			$query = 'TRUNCATE TABLE configuration;';
			if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de creation de la table Configuration
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function create($debug=0){
		$query = 'CREATE TABLE IF NOT EXISTS `configuration` (';
		$query .= '`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,';
		$query .='`key`    NOT NULL,';
		$query .='`value`    NOT NULL,';
		$query .='`date`    NOT NULL,';
		$query .='`user`    NOT NULL';
		$query .= ');';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode d'insertion ou de modifications d'elements de la table Configuration
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param  Aucun
	* @return Aucun retour
	*/
	public function save(){
		if(isset($this->id)){
			$query = 'UPDATE `configuration`'.
			' SET '.
			'`key`="'.$this->key.'",'.
			'`value`="'.$this->value.'",'.
			'`date`="'.$this->date.'",'.
			'`user`="'.$this->user.'"'.
			' WHERE `id`="'.$this->id.'";';
		}else{
			$query = 'INSERT INTO `configuration`('.
			'`key`,'.
			'`value`,'.
			'`date`,'.
			'`user`'.			
			')VALUES('.
			'"'.$this->key.'",'.
			'"'.$this->value.'",'.
			'"'.$this->date.'",'.
			'"'.$this->user.'"'.
			');';
		}
		if($this->debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		mysql_query($query)or die(mysql_error());
	}

	/**
	* Méthode de modification d'éléments de la table Configuration
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
		$query = 'UPDATE `configuration` SET ';
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
	* Méthode de selection de tous les elements de la table Configuration
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<Configuration>> $Configurations
	*/
	public static function populate($order=null,$limit=null,$return=Configuration::OBJECT,$debug=0){
		return Configuration::loadAll(array(),array(),$order,$limit,'=',$return,$debug);
	}

	/**
	* Méthode de selection multiple d'elements de la table Configuration
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $operation="=" definis le type d'operateur pour la requete select
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<Configuration>> $Configurations
	*/
	public static function loadAll($columns,$values,$order=null,$limit=null,$operation="=",$return=Configuration::OBJECT,$debug=0){
		$configurations = array();
		$whereClause = '';
		if(sizeof($columns)==sizeof($values)){
			if(sizeof($columns)!=0){
			$whereClause .= ' WHERE ';
				for($i=0;$i<sizeof($columns);$i++){
					if($i!=0)$whereClause .= ' AND ';
					$whereClause .= '`'.$columns[$i].'`'.$operation.'"'.$values[$i].'"';
				}
			}
			$query = 'SELECT * FROM `configuration` '.$whereClause.' ';
			if($order!=null) $query .='ORDER BY `'.$order.'` ';
			if($limit!=null) $query .='LIMIT '.$limit.' ';
			$query .=';';
			if($debug==1) echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$execQuery = mysql_query($query);
			while($queryReturn = mysql_fetch_assoc($execQuery)){
				$configuration = new Configuration();
				$configuration->id= $queryReturn["id"];
				$configuration->key= $queryReturn["key"];
				$configuration->value= $queryReturn["value"];
				$configuration->date= $queryReturn["date"];
				$configuration->user= $queryReturn["user"];
				if($return==Configuration::JSON) $configuration = $configuration->toJson();
				$configurations[] = $configuration;
				unset($configuration);
			}
		}else{
			exit ('Configuration.'.__METHOD__.') -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
			if($return==Configuration::JSON) $configurations = json_encode($configurations);
			return $configurations;
	}

	public function initConfig($userId){
		$defaultConfigTab = array(
			'planning_hidden_users'=>''
		);
		foreach($defaultConfigTab as $key=>$value){
			$conf = new Configuration($key, $value, time(), $userId);
			$conf->save();
		}
		
	}
	
	public static function loadConfig($userId){
		$configurations = Configuration::loadAll(array('user'),array($userId));
	
		$finalConfigurations = array();
		if($configurations!=false){
		foreach($configurations as $configuration){
			$finalConfigurations[$configuration->getKey()]= $configuration;
		}
		}
		return $finalConfigurations;
	}
	
	/**
	* Méthode de selection unique d'élements de la table Configuration
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $operation="=" definis le type d'operateur pour la requete select
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Configuration> $Configuration ou false si aucun objet n'est trouvé en base
	*/
	public static function load($columns,$values,$operation='=',$return=Configuration::OBJECT,$debug=0){
		$configurations = Configuration::loadAll($columns,$values,null,'1',$operation,$return,$debug);
		if(!isset($configurations[0]))$configurations[0] = false;
		return $configurations[0];
	}

	/**
	* Methode de comptage des éléments de la table configuration
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return<Integer> nombre de ligne dans la table des configuration
	*/
	public static function rowCount($debug=0)
	{
		$query = 'SELECT COUNT(*) FROM configuration';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
		$number = mysql_fetch_array($myQuery);
		return $number[0];
	}	
	
	/**
	* Méthode de supression d'elements de la table Configuration
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
			$query = 'DELETE FROM `configuration` WHERE '.$whereClause.' ;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			mysql_query($query);
		}else{
			exit ('Configuration.'.__METHOD__.' -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
	}
	
	
	// ACCESSEURS

	/**
	* Méthode de récuperation de l'attribut id de la classe Configuration
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> id
	*/
	
	public function getId(){
		return $this->id;
	}
	
	/**
	* Méthode de définition de l'attribut id de la classe Configuration
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	*/

	public function setId($id){
		$this->id = $id;
	}
	
		/**
	* Méthode de récuperation de l'attribut debug de la classe Configuration
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> debug
	*/
	
	public function getDebug(){
		return $this->debug;
	}
	
	/**
	* Méthode de définition de l'attribut debug de la classe Configuration
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <boolean> $debug 
	*/

	public function setDebug($debug){
		$this->debug = $debug;
	}

	/**
	* Méthode de récuperation de l'attribut Key de la classe Configuration
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> key
	*/

	public function getKey(){
		return $this->key;
	}

	/**
	* Méthode de définition de l'attribut Key de la classe Configuration
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $key
	* @return Aucun retour
	*/

	public function setKey($key){
		$this->key = $key;
	}

	/**
	* Méthode de récuperation de l'attribut Value de la classe Configuration
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> value
	*/

	public function getValue(){
		return $this->value;
	}

	/**
	* Méthode de définition de l'attribut Value de la classe Configuration
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $value
	* @return Aucun retour
	*/

	public function setValue($value){
		$this->value = $value;
	}

	/**
	* Méthode de récuperation de l'attribut Date de la classe Configuration
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> date
	*/

	public function getDate(){
		return $this->date;
	}

	/**
	* Méthode de définition de l'attribut Date de la classe Configuration
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $date
	* @return Aucun retour
	*/

	public function setDate($date){
		$this->date = $date;
	}

	/**
	* Méthode de récuperation de l'attribut User de la classe Configuration
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> user
	*/

	public function getUser(){
		return $this->user;
	}

	/**
	* Méthode de définition de l'attribut User de la classe Configuration
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $user
	* @return Aucun retour
	*/

	public function setUser($user){
		$this->user = $user;
	}

}
?>