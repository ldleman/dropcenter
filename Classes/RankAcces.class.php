<?php

/*
	@nom: RankAcces
	@auteur: Valentin CARRUESCO (valentincarruesco@yahoo.fr)
	@date de création: 30/12/2011 10:33:57
	@description: Classe de liaison des acc&Atilde;&uml;s et des rangs
	Les attributs de la classe sont les suivants :
	<li>Rank</li>
	<li>Acces</li>
*/

class RankAcces
{
	
	private $rank;
	private $acces;
	private $debug = 0;
	private $id;
	//Ces deux constantes définissent le type de retour pour les fonction loadAll, load, populate ...
	const OBJECT = 'OBJECT';
	const JSON = 'JSON';
	
	public function __construct($rank=null, $acces=null ){
		//Opérations du constructeur...
		if($rank!=null) $this->rank=$rank;
		if($acces!=null) $this->acces=$acces;
	}
	
	
	public function __call($methode, $attributs){
		//Action sur appel d'une méthode inconnue
	}
	
	
	public function __destruct(){
		//Action lors du unset de l'objet
	}
	
	
	public function __toString(){
		$retour = "instance de la classe RankAcces : <br/>";
		$retour .= '$id : '.$this->getId().'<br/>';
		$retour .= '$debug : '.$this->getDebug().'<br/>';
		$retour .= 'Rank : '.$this->rank.'<br/>';
		$retour .= 'Acces : '.$this->acces.'<br/>';
		return $retour;
	}
	
	
	public  function __clone(){
		//Action lors du clonage de l'objet RankAcces
	}
	
	
	/**
	* Methode de mise en session de l'objet RankAcces
	* @author Valentin CARRUESCO
	* @category SESSION
	* @param <String> $name=nom de la classe, definis la clé de l'objet en session
	* @return Aucun retour
	*/
	public function session($name="RankAcces"){
		$_SESSION[$name] = serialize($this);
	}
	
	
	/**
	* Methode de traduction de l'objet RankAcces en json (necessite au minimum de PHP 5.2 et de l'extension l'extension JSON de PECL)
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
		$jsonArray['rank']= $this->rank;
		$jsonArray['acces']= $this->acces;
		return json_encode($jsonArray);
	}
	
	
	// GESTION SQL

	/**
	* Methode de suppression de la table RankAcces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function destroy($debug=0)
	{
		$query = 'DROP TABLE IF EXISTS rankacces;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de nettoyage de la table RankAcces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function truncate($debug=0)
	{
			$query = 'TRUNCATE TABLE rankacces;';
			if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de creation de la table RankAcces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function create($debug=0){
		$query = 'CREATE TABLE IF NOT EXISTS `rankacces` (';
		$query .= '`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,';
		$query .='`rank`    NOT NULL,';
		$query .='`acces`    NOT NULL';
		$query .= ');';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode d'insertion ou de modifications d'elements de la table RankAcces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param  Aucun
	* @return Aucun retour
	*/
	public function save(){
		if(isset($this->id)){
			$query = 'UPDATE `rankacces`'.
			' SET '.
			'`rank`="'.$this->rank.'",'.
			'`acces`="'.$this->acces.'"'.
			' WHERE `id`="'.$this->id.'";';
		}else{
			$query = 'INSERT INTO `rankacces`('.
			'`rank`,'.
			'`acces`'.			
			')VALUES('.
			'"'.$this->rank.'",'.
			'"'.$this->acces.'"'.
			');';
		}
		if($this->debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		mysql_query($query)or die(mysql_error());
		if(!isset($this->id)) $this->id = mysql_insert_id ();
	}

	/**
	* Méthode de modification d'éléments de la table RankAcces
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
		$query = 'UPDATE `rankacces` SET ';
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
	* Méthode de selection de tous les elements de la table RankAcces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<RankAcces>> $RankAccess
	*/
	public static function populate($order=null,$limit=null,$return=RankAcces::OBJECT,$debug=0){
		return RankAcces::loadAll(array(),array(),$order,$limit,'=',$return,$debug);
	}

	/**
	* Méthode de selection multiple d'elements de la table RankAcces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $operation="=" definis le type d'operateur pour la requete select
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<RankAcces>> $RankAccess
	*/
	public static function loadAll($columns,$values,$order=null,$limit=null,$operation="=",$return=RankAcces::OBJECT,$debug=0){
		$rankaccess = array();
		$whereClause = '';
		if(sizeof($columns)==sizeof($values)){
			if(sizeof($columns)!=0){
			$whereClause .= ' WHERE ';
				for($i=0;$i<sizeof($columns);$i++){
					if($i!=0)$whereClause .= ' AND ';
					$whereClause .= '`'.$columns[$i].'`'.$operation.'"'.$values[$i].'"';
				}
			}
			$query = 'SELECT * FROM `rankacces` '.$whereClause.' ';
			if($order!=null) $query .='ORDER BY `'.$order.'` ';
			if($limit!=null) $query .='LIMIT '.$limit.' ';
			$query .=';';
			if($debug==1) echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$execQuery = mysql_query($query);
			while($queryReturn = mysql_fetch_assoc($execQuery)){
				$rankacces = new RankAcces();
				$rankacces->id= $queryReturn["id"];
				$rankacces->rank= $queryReturn["rank"];
				$rankacces->acces= $queryReturn["acces"];
				if($return==RankAcces::JSON) $rankacces = $rankacces->toJson();
				$rankaccess[] = $rankacces;
				unset($rankacces);
			}
		}else{
			exit ('RankAcces.'.__METHOD__.') -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
			if($return==RankAcces::JSON) $rankaccess = json_encode($rankaccess);
			return $rankaccess;
	}

	/**
	* Méthode de selection unique d'élements de la table RankAcces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $operation="=" definis le type d'operateur pour la requete select
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <RankAcces> $RankAcces ou false si aucun objet n'est trouvé en base
	*/
	public static function load($columns,$values,$operation='=',$return=RankAcces::OBJECT,$debug=0){
		$rankaccess = RankAcces::loadAll($columns,$values,null,'1',$operation,$return,$debug);
		if(!isset($rankaccess[0]))$rankaccess[0] = false;
		return $rankaccess[0];
	}

	/**
	* Methode de comptage des éléments de la table rankacces
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return<Integer> nombre de ligne dans la table des rankacces
	*/
	public static function rowCount($debug=0)
	{
		$query = 'SELECT COUNT(*) FROM rankacces';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
		$number = mysql_fetch_array($myQuery);
		return $number[0];
	}	
	
	/**
	* Méthode de supression d'elements de la table RankAcces
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
			$query = 'DELETE FROM `rankacces` WHERE '.$whereClause.' ;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			mysql_query($query);
		}else{
			exit ('RankAcces.'.__METHOD__.' -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
	}
	
	
	// ACCESSEURS

	/**
	* Méthode de récuperation de l'attribut id de la classe RankAcces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> id
	*/
	
	public function getId(){
		return $this->id;
	}
	
	/**
	* Méthode de définition de l'attribut id de la classe RankAcces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	*/

	public function setId($id){
		$this->id = $id;
	}
	
		/**
	* Méthode de récuperation de l'attribut debug de la classe RankAcces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> debug
	*/
	
	public function getDebug(){
		return $this->debug;
	}
	
	/**
	* Méthode de définition de l'attribut debug de la classe RankAcces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <boolean> $debug 
	*/

	public function setDebug($debug){
		$this->debug = $debug;
	}

	/**
	* Méthode de récuperation de l'attribut Rank de la classe RankAcces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> rank
	*/

	public function getRank(){
		return $this->rank;
	}

	/**
	* Méthode de définition de l'attribut Rank de la classe RankAcces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $rank
	* @return Aucun retour
	*/

	public function setRank($rank){
		$this->rank = $rank;
	}

	/**
	* Méthode de récuperation de l'attribut Acces de la classe RankAcces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> acces
	*/

	public function getAcces(){
		return $this->acces;
	}

	/**
	* Méthode de définition de l'attribut Acces de la classe RankAcces
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $acces
	* @return Aucun retour
	*/

	public function setAcces($acces){
		$this->acces = $acces;
	}

}
?>
