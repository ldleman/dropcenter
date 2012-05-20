<?php

/*
	@nom: Rank
	@auteur: Valentin CARRUESCO (valentincarruesco@yahoo.fr)
	@date de création: 26/12/2011 09:20:52
	@description: Classe de gestion des rangs utilisateurs
	Les attributs de la classe sont les suivants :
	<li>Label</li>
	<li>Description</li>
	<li>CreationDate</li>
	<li>UpdateDate</li>
*/

class Rank
{
	
	private $label;
	private $description;
	private $creationDate;
	private $updateDate;
	private $debug = 0;
	private $id;
	//Ces deux constantes définissent le type de retour pour les fonction loadAll, load, populate ...
	const OBJECT = 'OBJECT';
	const JSON = 'JSON';
	
	public function __construct($label=null, $description=null, $creationDate=null, $updateDate=null ){
		//Opérations du constructeur...
		if($label!=null) $this->label=$label;
		if($description!=null) $this->description=$description;
		if($creationDate!=null) $this->creationDate=$creationDate;
		if($updateDate!=null) $this->updateDate=$updateDate;
	}
	
	
	public function __call($methode, $attributs){
		//Action sur appel d'une méthode inconnue
	}
	
	
	public function __destruct(){
		//Action lors du unset de l'objet
	}
	
	
	public function __toString(){
		$retour = "instance de la classe Rank : <br/>";
		$retour .= '$id : '.$this->getId().'<br/>';
		$retour .= '$debug : '.$this->getDebug().'<br/>';
		$retour .= 'Label : '.$this->label.'<br/>';
		$retour .= 'Description : '.$this->description.'<br/>';
		$retour .= 'CreationDate : '.$this->creationDate.'<br/>';
		$retour .= 'UpdateDate : '.$this->updateDate.'<br/>';
		return $retour;
	}
	
	
	public  function __clone(){
		//Action lors du clonage de l'objet Rank
	}
	
	
	/**
	* Methode de mise en session de l'objet Rank
	* @author Valentin CARRUESCO
	* @category SESSION
	* @param <String> $name=nom de la classe, definis la clé de l'objet en session
	* @return Aucun retour
	*/
	public function session($name="Rank"){
		$_SESSION[$name] = serialize($this);
	}
	
	
	/**
	* Methode de traduction de l'objet Rank en json (necessite au minimum de PHP 5.2 et de l'extension l'extension JSON de PECL)
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
		$jsonArray['label']= $this->label;
		$jsonArray['description']= $this->description;
		$jsonArray['creationDate']= $this->creationDate;
		$jsonArray['updateDate']= $this->updateDate;
		return json_encode($jsonArray);
	}
	
	
	// GESTION SQL

	/**
	* Methode de suppression de la table Rank
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function destroy($debug=0)
	{
		$query = 'DROP TABLE IF EXISTS rank;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de nettoyage de la table Rank
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function truncate($debug=0)
	{
			$query = 'TRUNCATE TABLE rank;';
			if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de creation de la table Rank
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function create($debug=0){
		$query = 'CREATE TABLE IF NOT EXISTS `rank` (';
		$query .= '`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,';
		$query .='`label`    NOT NULL,';
		$query .='`description`    NOT NULL,';
		$query .='`creationDate`    NOT NULL,';
		$query .='`updateDate`    NOT NULL';
		$query .= ');';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode d'insertion ou de modifications d'elements de la table Rank
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param  Aucun
	* @return Aucun retour
	*/
	public function save(){
		if(isset($this->id)){
			$query = 'UPDATE `rank`'.
			' SET '.
			'`label`="'.$this->label.'",'.
			'`description`="'.$this->description.'",'.
			'`creationDate`="'.$this->creationDate.'",'.
			'`updateDate`="'.$this->updateDate.'"'.
			' WHERE `id`="'.$this->id.'";';
		}else{
			$query = 'INSERT INTO `rank`('.
			'`label`,'.
			'`description`,'.
			'`creationDate`,'.
			'`updateDate`'.			
			')VALUES('.
			'"'.$this->label.'",'.
			'"'.$this->description.'",'.
			'"'.$this->creationDate.'",'.
			'"'.$this->updateDate.'"'.
			');';
		}
		if($this->debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		mysql_query($query)or die(mysql_error());
		if(!isset($this->id)) $this->id = mysql_insert_id ();
	}

	/**
	* Méthode de modification d'éléments de la table Rank
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
		$query = 'UPDATE `rank` SET ';
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
	* Méthode de selection de tous les elements de la table Rank
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<Rank>> $Ranks
	*/
	public static function populate($order=null,$limit=null,$return=Rank::OBJECT,$debug=0){
		return Rank::loadAll(array(),array(),$order,$limit,'=',$return,$debug);
	}

	/**
	* Méthode de selection multiple d'elements de la table Rank
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $operation="=" definis le type d'operateur pour la requete select
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<Rank>> $Ranks
	*/
	public static function loadAll($columns,$values,$order=null,$limit=null,$operation="=",$return=Rank::OBJECT,$debug=0){
		$ranks = array();
		$whereClause = '';
		if(sizeof($columns)==sizeof($values)){
			if(sizeof($columns)!=0){
			$whereClause .= ' WHERE ';
				for($i=0;$i<sizeof($columns);$i++){
					if($i!=0)$whereClause .= ' AND ';
					$whereClause .= '`'.$columns[$i].'`'.$operation.'"'.$values[$i].'"';
				}
			}
			$query = 'SELECT * FROM `rank` '.$whereClause.' ';
			if($order!=null) $query .='ORDER BY `'.$order.'` ';
			if($limit!=null) $query .='LIMIT '.$limit.' ';
			$query .=';';
			if($debug==1) echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$execQuery = mysql_query($query);
			while($queryReturn = mysql_fetch_assoc($execQuery)){
				$rank = new Rank();
				$rank->id= $queryReturn["id"];
				$rank->label= $queryReturn["label"];
				$rank->description= $queryReturn["description"];
				$rank->creationDate= $queryReturn["creationDate"];
				$rank->updateDate= $queryReturn["updateDate"];
				if($return==Rank::JSON) $rank = $rank->toJson();
				$ranks[] = $rank;
				unset($rank);
			}
		}else{
			exit ('Rank.'.__METHOD__.') -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
			if($return==Rank::JSON) $ranks = json_encode($ranks);
			return $ranks;
	}

	/**
	* Méthode de selection unique d'élements de la table Rank
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $operation="=" definis le type d'operateur pour la requete select
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Rank> $Rank ou false si aucun objet n'est trouvé en base
	*/
	public static function load($columns,$values,$operation='=',$return=Rank::OBJECT,$debug=0){
		$ranks = Rank::loadAll($columns,$values,null,'1',$operation,$return,$debug);
		if(!isset($ranks[0]))$ranks[0] = false;
		return $ranks[0];
	}

	/**
	* Methode de comptage des éléments de la table rank
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return<Integer> nombre de ligne dans la table des rank
	*/
	public static function rowCount($debug=0)
	{
		$query = 'SELECT COUNT(*) FROM rank';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
		$number = mysql_fetch_array($myQuery);
		return $number[0];
	}	
	
	/**
	* Méthode de supression d'elements de la table Rank
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
			$query = 'DELETE FROM `rank` WHERE '.$whereClause.' ;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			mysql_query($query);
		}else{
			exit ('Rank.'.__METHOD__.' -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
	}
	
	
	// ACCESSEURS

	/**
	* Méthode de récuperation de l'attribut id de la classe Rank
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> id
	*/
	
	public function getId(){
		return $this->id;
	}
	
	/**
	* Méthode de définition de l'attribut id de la classe Rank
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	*/

	public function setId($id){
		$this->id = $id;
	}
	
		/**
	* Méthode de récuperation de l'attribut debug de la classe Rank
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> debug
	*/
	
	public function getDebug(){
		return $this->debug;
	}
	
	/**
	* Méthode de définition de l'attribut debug de la classe Rank
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <boolean> $debug 
	*/

	public function setDebug($debug){
		$this->debug = $debug;
	}

	/**
	* Méthode de récuperation de l'attribut Label de la classe Rank
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> label
	*/

	public function getLabel(){
		return $this->label;
	}

	/**
	* Méthode de définition de l'attribut Label de la classe Rank
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $label
	* @return Aucun retour
	*/

	public function setLabel($label){
		$this->label = $label;
	}

	/**
	* Méthode de récuperation de l'attribut Description de la classe Rank
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> description
	*/

	public function getDescription(){
		return $this->description;
	}

	public function getDescriptionFormat($limit=50){
		return Fonction::tronquer($this->description,$limit);
	}
	
	/**
	* Méthode de définition de l'attribut Description de la classe Rank
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $description
	* @return Aucun retour
	*/

	public function setDescription($description){
		$this->description = $description;
	}

	/**
	* Méthode de récuperation de l'attribut CreationDate de la classe Rank
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> creationDate
	*/

	public function getCreationDate(){
		return $this->creationDate;
	}

	public function getDatecreationFormat($pattern=null){
		if($pattern==null)$pattern = 'd/m/Y h:i:s';
		return date($pattern,$this->dateCreation);
	}
	/**
	* Méthode de définition de l'attribut CreationDate de la classe Rank
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $creationDate
	* @return Aucun retour
	*/

	public function setCreationDate($creationDate){
		$this->creationDate = $creationDate;
	}

	/**
	* Méthode de récuperation de l'attribut UpdateDate de la classe Rank
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> updateDate
	*/

	public function getUpdateDate(){
		return $this->updateDate;
	}

	public function getUpdateDateFormat($pattern=null){
		if($pattern==null)$pattern = 'd/m/Y h:i:s';
		return date($pattern,$this->updateDate);
	}
	/**
	* Méthode de définition de l'attribut UpdateDate de la classe Rank
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $updateDate
	* @return Aucun retour
	*/

	public function setUpdateDate($updateDate){
		$this->updateDate = $updateDate;
	}

}
?>
