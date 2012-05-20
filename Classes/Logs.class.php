<?php

/*
	@nom: Logs
	@auteur: Valentin CARRUESCO (valentincarruesco@yahoo.fr)
	@date de création: 30/12/2011 10:38:13
	@description: Classe de gestion de l\'historique et du d&Atilde;&copy;bug
	Les attributs de la classe sont les suivants :
	<li>Date</li>
	<li>Page</li>
	<li>Ip</li>
	<li>Label</li>
	<li>Comment</li>
	<li>User</li>
	<li>Type</li>
*/

class Logs
{
	
	private $date;
	private $page;
	private $ip;
	private $label;
	private $comment;
	private $user;
	private $type;
	private $debug = 0;
	private $id;
	//Ces deux constantes définissent le type de retour pour les fonction loadAll, load, populate ...
	const OBJECT = 'OBJECT';
	const JSON = 'JSON';
	
	public function __construct($date=null, $page=null, $ip=null, $label=null, $comment=null, $user=null, $type=null ){
		//Opérations du constructeur...
		if($date!=null) $this->date=$date;
		if($page!=null) $this->page=$page;
		if($ip!=null) $this->ip=$ip;
		if($label!=null) $this->label=$label;
		if($comment!=null) $this->comment=$comment;
		if($user!=null) $this->user=$user;
		if($type!=null) $this->type=$type;
	}
	
	
	public function __call($methode, $attributs){
		//Action sur appel d'une méthode inconnue
	}
	
	
	public function __destruct(){
		//Action lors du unset de l'objet
	}
	
	
	public function __toString(){
		$retour = "instance de la classe Logs : <br/>";
		$retour .= '$id : '.$this->getId().'<br/>';
		$retour .= '$debug : '.$this->getDebug().'<br/>';
		$retour .= 'Date : '.$this->date.'<br/>';
		$retour .= 'Page : '.$this->page.'<br/>';
		$retour .= 'Ip : '.$this->ip.'<br/>';
		$retour .= 'Label : '.$this->label.'<br/>';
		$retour .= 'Comment : '.$this->comment.'<br/>';
		$retour .= 'User : '.$this->user.'<br/>';
		$retour .= 'Type : '.$this->type.'<br/>';
		return $retour;
	}
	
	
	public  function __clone(){
		//Action lors du clonage de l'objet Logs
	}
	
	
	/**
	* Methode de mise en session de l'objet Logs
	* @author Valentin CARRUESCO
	* @category SESSION
	* @param <String> $name=nom de la classe, definis la clé de l'objet en session
	* @return Aucun retour
	*/
	public function session($name="Logs"){
		$_SESSION[$name] = serialize($this);
	}
	
	
	/**
	* Methode de traduction de l'objet Logs en json (necessite au minimum de PHP 5.2 et de l'extension l'extension JSON de PECL)
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
		$jsonArray['date']= $this->date;
		$jsonArray['page']= $this->page;
		$jsonArray['ip']= $this->ip;
		$jsonArray['label']= $this->label;
		$jsonArray['comment']= $this->comment;
		$jsonArray['user']= $this->user;
		$jsonArray['type']= $this->type;
		return json_encode($jsonArray);
	}
	
	
	// GESTION SQL

	/**
	* Methode de suppression de la table Logs
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function destroy($debug=0)
	{
		$query = 'DROP TABLE IF EXISTS logs;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de nettoyage de la table Logs
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function truncate($debug=0)
	{
			$query = 'TRUNCATE TABLE logs;';
			if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de creation de la table Logs
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function create($debug=0){
		$query = 'CREATE TABLE IF NOT EXISTS `logs` (';
		$query .= '`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,';
		$query .='`date`    NOT NULL,';
		$query .='`page`    NOT NULL,';
		$query .='`ip`    NOT NULL,';
		$query .='`label`    NOT NULL,';
		$query .='`comment`    NOT NULL,';
		$query .='`user`    NOT NULL,';
		$query .='`type`    NOT NULL';
		$query .= ');';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode d'insertion ou de modifications d'elements de la table Logs
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param  Aucun
	* @return Aucun retour
	*/
	public function save(){
		if(isset($this->id)){
			$query = 'UPDATE `logs`'.
			' SET '.
			'`date`="'.$this->date.'",'.
			'`page`="'.$this->page.'",'.
			'`ip`="'.$this->ip.'",'.
			'`label`="'.$this->label.'",'.
			'`comment`="'.$this->comment.'",'.
			'`user`="'.$this->user.'",'.
			'`type`="'.$this->type.'"'.
			' WHERE `id`="'.$this->id.'";';
		}else{
			$query = 'INSERT INTO `logs`('.
			'`date`,'.
			'`page`,'.
			'`ip`,'.
			'`label`,'.
			'`comment`,'.
			'`user`,'.
			'`type`'.			
			')VALUES('.
			'"'.$this->date.'",'.
			'"'.$this->page.'",'.
			'"'.$this->ip.'",'.
			'"'.$this->label.'",'.
			'"'.$this->comment.'",'.
			'"'.$this->user.'",'.
			'"'.$this->type.'"'.
			');';
		}
		if($this->debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		mysql_query($query)or die(mysql_error());
		if(!isset($this->id)) $this->id = mysql_insert_id ();
	}

	/**
	* Méthode de modification d'éléments de la table Logs
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
		$query = 'UPDATE `logs` SET ';
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
	* Méthode de selection de tous les elements de la table Logs
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<Logs>> $Logss
	*/
	public static function populate($order=null,$limit=null,$return=Logs::OBJECT,$debug=0){
		return Logs::loadAll(array(),array(),$order,$limit,'=',$return,$debug);
	}

	/**
	* Méthode de selection multiple d'elements de la table Logs
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $operation="=" definis le type d'operateur pour la requete select
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<Logs>> $Logss
	*/
	public static function loadAll($columns,$values,$order=null,$limit=null,$operation="=",$return=Logs::OBJECT,$debug=0){
		$logss = array();
		$whereClause = '';
		if(sizeof($columns)==sizeof($values)){
			if(sizeof($columns)!=0){
			$whereClause .= ' WHERE ';
				for($i=0;$i<sizeof($columns);$i++){
					if($i!=0)$whereClause .= ' AND ';
					$whereClause .= '`'.$columns[$i].'`'.$operation.'"'.$values[$i].'"';
				}
			}
			$query = 'SELECT * FROM `logs` '.$whereClause.' ';
			if($order!=null) $query .='ORDER BY `'.$order.'` ';
			if($limit!=null) $query .='LIMIT '.$limit.' ';
			$query .=';';
			if($debug==1) echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$execQuery = mysql_query($query);
			while($queryReturn = mysql_fetch_assoc($execQuery)){
				$logs = new Logs();
				$logs->id= $queryReturn["id"];
				$logs->date= $queryReturn["date"];
				$logs->page= $queryReturn["page"];
				$logs->ip= $queryReturn["ip"];
				$logs->label= $queryReturn["label"];
				$logs->comment= $queryReturn["comment"];
				$logs->user= $queryReturn["user"];
				$logs->type= $queryReturn["type"];
				if($return==Logs::JSON) $logs = $logs->toJson();
				$logss[] = $logs;
				unset($logs);
			}
		}else{
			exit ('Logs.'.__METHOD__.') -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
			if($return==Logs::JSON) $logss = json_encode($logss);
			return $logss;
	}

	/**
	* Méthode de selection unique d'élements de la table Logs
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $operation="=" definis le type d'operateur pour la requete select
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Logs> $Logs ou false si aucun objet n'est trouvé en base
	*/
	public static function load($columns,$values,$operation='=',$return=Logs::OBJECT,$debug=0){
		$logss = Logs::loadAll($columns,$values,null,'1',$operation,$return,$debug);
		if(!isset($logss[0]))$logss[0] = false;
		return $logss[0];
	}

	/**
	* Methode de comptage des éléments de la table logs
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return<Integer> nombre de ligne dans la table des logs
	*/
	public static function rowCount($debug=0)
	{
		$query = 'SELECT COUNT(*) FROM logs';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
		$number = mysql_fetch_array($myQuery);
		return $number[0];
	}	
	
	/**
	* Méthode de supression d'elements de la table Logs
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
			$query = 'DELETE FROM `logs` WHERE '.$whereClause.' ;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			mysql_query($query);
		}else{
			exit ('Logs.'.__METHOD__.' -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
	}
	
	
	/**
	 * Ajoute une entrée dans le gestionnaire de logs
	 * type : <ul><li>0 => informations<li>
	 * 		      <li> 1 => erreur utilisateur<li>
	 * 		      <li>2 => erreur technique<li>
	 * 		      <li>3 => erreur securite<li>
	 *  </ul>
	 * @author Valentin
	 * 
	 */
	public static function put($type=null,$label=null,$comment=null){
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}elseif(isset($_SERVER['HTTP_CLIENT_IP'])){
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}else{ 
			$ip = $_SERVER['REMOTE_ADDR'];
		} 
		if(isset($_SESSION['user'])){
			$user = unserialize($_SESSION['user']);
			if(is_object($user)){
			$user = $user->getId();
			}else{
				$user = null;
			}
		}else{
			$user=null;
		}
		$comment = mysql_escape_string($comment);
		$journal = new Logs($type,$label,$comment,time(),$_SERVER['REQUEST_URI'],$ip,$user);
		$journal->save();
	}
	
	
	// ACCESSEURS

	/**
	* Méthode de récuperation de l'attribut id de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> id
	*/
	
	public function getId(){
		return $this->id;
	}
	
	/**
	* Méthode de définition de l'attribut id de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	*/

	public function setId($id){
		$this->id = $id;
	}
	
		/**
	* Méthode de récuperation de l'attribut debug de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> debug
	*/
	
	public function getDebug(){
		return $this->debug;
	}
	
	/**
	* Méthode de définition de l'attribut debug de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <boolean> $debug 
	*/

	public function setDebug($debug){
		$this->debug = $debug;
	}

	/**
	* Méthode de récuperation de l'attribut Date de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> date
	*/

	public function getDate(){
		return $this->date;
	}
	
	/**
	* Méthode de récuperation de l'attribut date formaté de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> date
	*/
	
	public function getDateFormat($pattern='d/m/Y h:i:s'){
		return date($pattern,$this->date);
	}
	
	/**
	* Méthode de définition de l'attribut Date de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $date
	* @return Aucun retour
	*/

	public function setDate($date){
		$this->date = $date;
	}

	/**
	* Méthode de récuperation de l'attribut Page de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> page
	*/

	public function getPage(){
		return $this->page;
	}

	/**
	* Méthode de définition de l'attribut Page de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $page
	* @return Aucun retour
	*/

	public function setPage($page){
		$this->page = $page;
	}

	/**
	* Méthode de récuperation de l'attribut Ip de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> ip
	*/

	public function getIp(){
		return $this->ip;
	}

	/**
	* Méthode de définition de l'attribut Ip de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $ip
	* @return Aucun retour
	*/

	public function setIp($ip){
		$this->ip = $ip;
	}

	/**
	* Méthode de récuperation de l'attribut Label de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> label
	*/

	public function getLabel(){
		return $this->label;
	}

	/**
	* Méthode de définition de l'attribut Label de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $label
	* @return Aucun retour
	*/

	public function setLabel($label){
		$this->label = $label;
	}

	/**
	* Méthode de récuperation de l'attribut Comment de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> comment
	*/

	public function getComment(){
		return $this->comment;
	}

	/**
	* Méthode de définition de l'attribut Comment de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $comment
	* @return Aucun retour
	*/

	public function setComment($comment){
		$this->comment = $comment;
	}

	/**
	* Méthode de récuperation de l'attribut User de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> user
	*/

	public function getUserId(){
		return $this->user;
	}
	
		/**
	* Méthode de récuperation de l'attribut utilisateur de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> utilisateur
	*/

	public function getUser(){
		if($this->user!='' && $this->user!=null && $this->user!=0 ){
			$user = User::load(array('id'),array($this->user));
		}else{
			$user = new User();
			$user->setName('Anonyme');
		}
		return $user;
	}

	/**
	* Méthode de définition de l'attribut User de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $user
	* @return Aucun retour
	*/

	public function setUser($user){
		$this->user = $user;
	}

	/**
	* Méthode de récuperation de l'attribut Type de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> type
	*/

	public function getType(){
		return $this->type;
	}

	/**
	* Méthode de définition de l'attribut Type de la classe Logs
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $type
	* @return Aucun retour
	*/

	public function setType($type){
		$this->type = $type;
	}

}
?>
