<?php

/*
	@nom: group
	@auteur: Valentin CARRUESCO (valentin.carruesco@sys1.fr)
	@date de création: 10/10/2011 03:00:18
	@description: Classe de gestion des groupes d\'utilisateurs
	@language : 
*/

class Group
{
	
	private $name;
	private $description;
	
	public function __construct($name=null, $description=null ){
		//Opérations du constructeur...
		
		if($name!=null) $this->name=$name;
		if($description!=null) $this->description=$description;
	}
	
	
	public function __call($methode, $attributs){
		//Action sur appel d'une méthode inconnue
	}
	
	
	public function __destruct(){
		//Action lors du unset de l'objet
	}
	
	
	public function __toString(){
		$retour = "instance de la classe group : <br/>";
		$retour .= '$id : '.$this->getId().'<br/>';
		
		$retour .= '$name : '.$this->name.'<br/>';
		$retour .= '$description : '.$this->description.'<br/>';
		return $retour;
	}
	
	
	public  function __clone(){
		//Action lors du clonage de l'objet group
	}
	
	
	/**
	* Methode de mise en session de l'objet group
	* @author Valentin CARRUESCO
	* @category SESSION
	* @param <String> $name=nom de la classe, definis la clé de l'objet en session
	* @return Aucun retour
	*/
	public function session($name="group"){
		$_SESSION[$name] = serialize($this);
	}
	
	
	/**
	* Methode de traduction de l'objet group en json (necessite au minimum de PHP 5.2 et de l'extension l'extension JSON de PECL)
	* @author Valentin CARRUESCO
	* @category SESSION
	* @require PHP 5.2
	* @require extension JSON de PECL
	* @require encodage UTF-8
	* @return code json
	*/
	public function json(){
		return json_encode($this);
	}
	
	
	// GESTION SQL

	/**
	* Methode de suppression de la table group
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function destroy($debug=0)
	{
		$query = 'DROP TABLE IF EXISTS group;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de nettoyage de la table group
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function truncate($debug=0)
	{
			$query = 'TRUNCATE TABLE group;';
			if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de creation de la table group
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function create($debug=0){
		$query = 'CREATE TABLE IF NOT EXISTS `group` (';
		$query .= '`` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,';
		
		$query .='`name` $   NOT NULL,';
		$query .='`description` $   NOT NULL';
		$query .= ');';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode d'insertion ou de modifications d'elements de la table group
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param  Aucun
	* @return Aucun retour
	*/

	public function save(){
		if(isset($this->id)){
			$query = 'UPDATE `group`'.
			' SET '.
			
			'`name`="'.$this->name.'",'.
			'`description`="'.$this->description.'"'.
			' WHERE `id`="'.$this->id.'";';
		}else{
			$query = 'INSERT INTO `group`('.
			
			'`name`,'.
			'`description`'.			
			')VALUES("'.
			
			$this->name.'","'.
			$this->description.'""'.
			'");';
		}
		if($this->debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		mysql_query($query)or die(mysql_error());
		if(!isset($this->id)) $this->id = mysql_insert_id ();
	}

	/**
	* Méthode de modification d'éléments de la table group
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
		$query = 'UPDATE `group`'.
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
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		mysql_query($query)or die(mysql_error());
	}

	/**
	* Méthode de selection de tous les elements de la table group
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<group>> $groups
	*/

	public static function populate($order=null,$limit=null,$debug=0){
		return group::loadAll(array(),array(),$order,$limit,$debug);
	}

	/**
	* Méthode de selection multiple d'elements de la table group
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<group>> $groups
	*/

	public static function loadAll($columns,$values,$order=null,$limit=null,$debug=0){
		$groups = array();
		$whereClause = '';
		if(sizeof($columns)==sizeof($values)){
		if(sizeof($columns)!=0){
		$whereClause .= ' WHERE ';
			for($i=0;$i<sizeof($columns);$i++){
				if($i!=0)$whereClause .= ' AND ';
				$whereClause .= '`'.$columns[$i].'`="'.$values[$i].'"';
			}
		}
			$query = 'SELECT * FROM `group` '.$whereClause.' ';
			if($order!=null) $query .='ORDER BY `'.$order.'` ';
			if($limit!=null) $query .='LIMIT '.$limit.' ';
			$query .=';';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$execQuery = mysql_query($query);
			while($queryReturn = mysql_fetch_assoc($execQuery)){
				$group = new group();
				$group->id= $queryReturn["id"];
				
				$group->name= $queryReturn["name"];
				$group->description= $queryReturn["description"];
				$groups[] = $group;
				unset($group);
			}
		}else{
			exit ('group.'.__METHOD__.') -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
			return $groups;
	}

	/**
	* Méthode de selection unique d'elements de la table group
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <group> $group
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
			$query = 'SELECT * FROM `group` '.$whereClause.' ;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$queryReturn = mysql_fetch_assoc(mysql_query($query));
			$group = new group();
			$group->id= $queryReturn["id"];
			
			$group->name= $queryReturn["name"];
			$group->description= $queryReturn["description"];
		}else{
			exit ('group.'.__METHOD__.' -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
			return $group;
	}

	/**
	* Methode de comptage des éléments de la table group
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return<Integer> nombre de ligne dans la table des group
	*/
	public static function rowCount($debug=0)
	{
		$query = 'SELECT COUNT(*) FROM group';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
		$number = mysql_fetch_array($myQuery);
		return $number[0];
	}	
	
	/**
	* Méthode de supression d'elements de la table group
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
				$whereClause .= '`'.$columns[$i].'`="'.$values[$i].'"';
			}
			$query = 'DELETE FROM `group` WHERE '.$whereClause.' ;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			mysql_query($query);
		}else{
			exit ('group.'.__METHOD__.' -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
	}
	
	
	
	/**
	* Méthode de serialisation des attributs de la classe group pour le transfert javascript
	* @author Valentin CARRUESCO
	* @category Transport language
	* @return<String> chaine serialisée
	*/
	public function forJavascript(){
		$retour = "";
		
		$retour .= 'name[*:*]'.$this->name.'[*-*]';
		$retour .= 'description[*:*]'.$this->description;
		return $retour;
	}
	
	
	
	// ACCESSEURS

	/**
	* Méthode de récuperation de l'attribut  de la classe group
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> 
	*/
	
	public function getId(){
		return $this->id;
	}
	
	/**
	* Méthode de définition de l'attribut  de la classe group
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> 
	*/

	public function setId($id){
		$this->id = $id;
	}

	/**
	* Méthode de récuperation de l'attribut Name de la classe group
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> name
	*/

	public function getName(){
		return $this->name;
	}

	/**
	* Méthode de définition de l'attribut Name de la classe group
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $name
	* @return Aucun retour
	*/

	public function setName($name){
		$this->name = $name;
	}

	/**
	* Méthode de récuperation de l'attribut Description de la classe group
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> description
	*/

	public function getDescription(){
		return $this->description;
	}

	/**
	* Méthode de définition de l'attribut Description de la classe group
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $description
	* @return Aucun retour
	*/

	public function setDescription($description){
		$this->description = $description;
	}

}
?>