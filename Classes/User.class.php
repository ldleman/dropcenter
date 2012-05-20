<?php

/*
	@nom: User
	@auteur: Valentin CARRUESCO (valentincarruesco@yahoo.fr)
	@date de création: 23/12/2011 05:11:41
	@description: Classe de gestion des utilisateurs
	Les attributs de la classe sont les suivants :
	<li>Name</li>
	<li>FirstName</li>
	<li>Birth</li>
	<li>Sex</li>
	<li>Location</li>
	<li>Phone</li>
	<li>CellPhone</li>
	<li>Mail</li>
	<li>Login</li>
	<li>Password</li>
	<li>LastIp</li>
	<li>CreationDate</li>
	<li>ModificationDate</li>
	<li>Picture</li>
	<li>State</li>
	<li>Rank</li>
	<li>Group</li>
	<li>Description</li>
	<li>Pseudonyme</li>
	<li>Configuration</li>
*/

class User
{
	
	private $name;
	private $firstName;
	private $birth;
	private $sex;
	private $location;
	private $phone;
	private $cellPhone;
	private $mail;
	private $login;
	private $password;
	private $lastIp;
	private $creationDate;
	private $modificationDate;
	private $picture;
	private $state;
	private $rank;
	private $group;
	private $description;
	private $pseudonyme;
	private $configuration;
	private $debug = 0;
	private $id;
	//Ces deux constantes définissent le type de retour pour les fonction loadAll, load, populate ...
	const OBJECT = 'OBJECT';
	const JSON = 'JSON';
	
	public function __construct($name=null, $firstName=null, $birth=null, $sex=null, $location=null, $phone=null, $cellPhone=null, $mail=null, $login=null, $password=null, $lastIp=null, $creationDate=null, $modificationDate=null, $picture=null, $state=null, $rank=null, $group=null, $description=null, $pseudonyme=null, $configuration=null ){
		//Opérations du constructeur...
		if($name!=null) $this->name=$name;
		if($firstName!=null) $this->firstName=$firstName;
		if($birth!=null) $this->birth=$birth;
		if($sex!=null) $this->sex=$sex;
		if($location!=null) $this->location=$location;
		if($phone!=null) $this->phone=$phone;
		if($cellPhone!=null) $this->cellPhone=$cellPhone;
		if($mail!=null) $this->mail=$mail;
		if($login!=null) $this->login=$login;
		if($password!=null) $this->password=$password;
		if($lastIp!=null) $this->lastIp=$lastIp;
		if($creationDate!=null) $this->creationDate=$creationDate;
		if($modificationDate!=null) $this->modificationDate=$modificationDate;
		if($picture!=null) $this->picture=$picture;
		if($state!=null) $this->state=$state;
		if($rank!=null) $this->rank=$rank;
		if($group!=null) $this->group=$group;
		if($description!=null) $this->description=$description;
		if($pseudonyme!=null) $this->pseudonyme=$pseudonyme;
		if($configuration!=null) $this->configuration=$configuration;
	}
	
	
	public function __call($methode, $attributs){
		//Action sur appel d'une méthode inconnue
	}
	
	
	public function __destruct(){
		//Action lors du unset de l'objet
	}
	
	
	public function __toString(){
		$retour = "instance de la classe User : <br/>";
		$retour .= '$id : '.$this->getId().'<br/>';
		$retour .= '$debug : '.$this->getDebug().'<br/>';
		$retour .= 'Name : '.$this->name.'<br/>';
		$retour .= 'FirstName : '.$this->firstName.'<br/>';
		$retour .= 'Birth : '.$this->birth.'<br/>';
		$retour .= 'Sex : '.$this->sex.'<br/>';
		$retour .= 'Location : '.$this->location.'<br/>';
		$retour .= 'Phone : '.$this->phone.'<br/>';
		$retour .= 'CellPhone : '.$this->cellPhone.'<br/>';
		$retour .= 'Mail : '.$this->mail.'<br/>';
		$retour .= 'Login : '.$this->login.'<br/>';
		$retour .= 'Password : '.$this->password.'<br/>';
		$retour .= 'LastIp : '.$this->lastIp.'<br/>';
		$retour .= 'CreationDate : '.$this->creationDate.'<br/>';
		$retour .= 'ModificationDate : '.$this->modificationDate.'<br/>';
		$retour .= 'Picture : '.$this->picture.'<br/>';
		$retour .= 'State : '.$this->state.'<br/>';
		$retour .= 'Rank : '.$this->rank.'<br/>';
		$retour .= 'Group : '.$this->group.'<br/>';
		$retour .= 'Description : '.$this->description.'<br/>';
		$retour .= 'Pseudonyme : '.$this->pseudonyme.'<br/>';
		$retour .= 'Configuration : '.$this->configuration.'<br/>';
		return $retour;
	}
	
	
	public  function __clone(){
		//Action lors du clonage de l'objet User
	}
	
	
	/**
	* Methode de mise en session de l'objet User
	* @author Valentin CARRUESCO
	* @category SESSION
	* @param <String> $name=nom de la classe, definis la clé de l'objet en session
	* @return Aucun retour
	*/
	public function session($name="User"){
		$_SESSION[$name] = serialize($this);
	}
	
	
	/**
	* Methode de traduction de l'objet User en json (necessite au minimum de PHP 5.2 et de l'extension l'extension JSON de PECL)
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
		$jsonArray['name']= $this->name;
		$jsonArray['firstName']= $this->firstName;
		$jsonArray['birth']= $this->birth;
		$jsonArray['sex']= $this->sex;
		$jsonArray['location']= $this->location;
		$jsonArray['phone']= $this->phone;
		$jsonArray['cellPhone']= $this->cellPhone;
		$jsonArray['mail']= $this->mail;
		$jsonArray['login']= $this->login;
		$jsonArray['password']= $this->password;
		$jsonArray['lastIp']= $this->lastIp;
		$jsonArray['creationDate']= $this->creationDate;
		$jsonArray['modificationDate']= $this->modificationDate;
		$jsonArray['picture']= $this->picture;
		$jsonArray['state']= $this->state;
		$jsonArray['rank']= $this->rank;
		$jsonArray['group']= $this->group;
		$jsonArray['description']= $this->description;
		$jsonArray['pseudonyme']= $this->pseudonyme;
		$jsonArray['configuration']= $this->configuration;
		return json_encode($jsonArray);
	}
	
	
	// GESTION SQL

	/**
	* Methode de suppression de la table User
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function destroy($debug=0)
	{
		$query = 'DROP TABLE IF EXISTS user;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de nettoyage de la table User
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function truncate($debug=0)
	{
			$query = 'TRUNCATE TABLE user;';
			if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de creation de la table User
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function create($debug=0){
		$query = 'CREATE TABLE IF NOT EXISTS `user` (';
		$query .= '`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,';
		$query .='`name`    NOT NULL,';
		$query .='`firstName`    NOT NULL,';
		$query .='`birth`    NOT NULL,';
		$query .='`sex`    NOT NULL,';
		$query .='`location`    NOT NULL,';
		$query .='`phone`    NOT NULL,';
		$query .='`cellPhone`    NOT NULL,';
		$query .='`mail`    NOT NULL,';
		$query .='`login`    NOT NULL,';
		$query .='`password`    NOT NULL,';
		$query .='`lastIp`    NOT NULL,';
		$query .='`creationDate`    NOT NULL,';
		$query .='`modificationDate`    NOT NULL,';
		$query .='`picture`    NOT NULL,';
		$query .='`state`    NOT NULL,';
		$query .='`rank`    NOT NULL,';
		$query .='`group`    NOT NULL,';
		$query .='`description`    NOT NULL,';
		$query .='`pseudonyme`    NOT NULL,';
		$query .='`configuration`    NOT NULL';
		$query .= ');';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode d'insertion ou de modifications d'elements de la table User
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param  Aucun
	* @return Aucun retour
	*/
	public function save(){
		if(isset($this->id)){
			$query = 'UPDATE `user`'.
			' SET '.
			'`name`="'.$this->name.'",'.
			'`firstName`="'.$this->firstName.'",'.
			'`birth`="'.$this->birth.'",'.
			'`sex`="'.$this->sex.'",'.
			'`location`="'.$this->location.'",'.
			'`phone`="'.$this->phone.'",'.
			'`cellPhone`="'.$this->cellPhone.'",'.
			'`mail`="'.$this->mail.'",'.
			'`login`="'.$this->login.'",'.
			'`password`="'.Functions::crypt($this->password).'",'.
			'`lastIp`="'.$this->lastIp.'",'.
			'`creationDate`="'.$this->creationDate.'",'.
			'`modificationDate`="'.$this->modificationDate.'",'.
			'`picture`="'.$this->picture.'",'.
			'`state`="'.$this->state.'",'.
			'`rank`="'.$this->rank.'",'.
			'`group`="'.$this->group.'",'.
			'`description`="'.$this->description.'",'.
			'`pseudonyme`="'.$this->pseudonyme.'",'.
			'`configuration`="'.$this->configuration.'"'.
			' WHERE `id`="'.$this->id.'";';
		}else{
			$query = 'INSERT INTO `user`('.
			'`name`,'.
			'`firstName`,'.
			'`birth`,'.
			'`sex`,'.
			'`location`,'.
			'`phone`,'.
			'`cellPhone`,'.
			'`mail`,'.
			'`login`,'.
			'`password`,'.
			'`lastIp`,'.
			'`creationDate`,'.
			'`modificationDate`,'.
			'`picture`,'.
			'`state`,'.
			'`rank`,'.
			'`group`,'.
			'`description`,'.
			'`pseudonyme`,'.
			'`configuration`'.			
			')VALUES('.
			'"'.$this->name.'",'.
			'"'.$this->firstName.'",'.
			'"'.$this->birth.'",'.
			'"'.$this->sex.'",'.
			'"'.$this->location.'",'.
			'"'.$this->phone.'",'.
			'"'.$this->cellPhone.'",'.
			'"'.$this->mail.'",'.
			'"'.$this->login.'",'.
			'"'.Functions::crypt($this->password).'",'.
			'"'.$this->lastIp.'",'.
			'"'.$this->creationDate.'",'.
			'"'.$this->modificationDate.'",'.
			'"'.$this->picture.'",'.
			'"'.$this->state.'",'.
			'"'.$this->rank.'",'.
			'"'.$this->group.'",'.
			'"'.$this->description.'",'.
			'"'.$this->pseudonyme.'",'.
			'"'.$this->configuration.'"'.
			');';
		}
		if($this->debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		mysql_query($query)or die(mysql_error());
		if(!isset($this->id)) $this->id = mysql_insert_id ();
	}

	/**
	* Méthode de modification d'éléments de la table User
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
		$query = 'UPDATE `user` SET ';
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
	* Méthode de selection de tous les elements de la table User
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<User>> $Users
	*/
	public static function populate($order=null,$limit=null,$return=User::OBJECT,$debug=0){
		return User::loadAll(array(),array(),$order,$limit,'=',$return,$debug);
	}

	/**
	* Méthode de selection multiple d'elements de la table User
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $operation="=" definis le type d'operateur pour la requete select
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<User>> $Users
	*/
	public static function loadAll($columns,$values,$order=null,$limit=null,$operation="=",$return=User::OBJECT,$debug=0){
		$users = array();
		$whereClause = '';
		if(sizeof($columns)==sizeof($values)){
			if(sizeof($columns)!=0){
			$whereClause .= ' WHERE ';
				for($i=0;$i<sizeof($columns);$i++){
					if($i!=0)$whereClause .= ' AND ';
					$whereClause .= '`'.$columns[$i].'`'.$operation.'"'.$values[$i].'"';
				}
			}
			$query = 'SELECT * FROM `user` '.$whereClause.' ';
			if($order!=null) $query .='ORDER BY `'.$order.'` ';
			if($limit!=null) $query .='LIMIT '.$limit.' ';
			$query .=';';
			if($debug==1) echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$execQuery = mysql_query($query);
			while($queryReturn = mysql_fetch_assoc($execQuery)){
				$user = new User();
				$user->id= $queryReturn["id"];
				$user->name= $queryReturn["name"];
				$user->firstName= $queryReturn["firstName"];
				$user->birth= $queryReturn["birth"];
				$user->sex= $queryReturn["sex"];
				$user->location= $queryReturn["location"];
				$user->phone= $queryReturn["phone"];
				$user->cellPhone= $queryReturn["cellPhone"];
				$user->mail= $queryReturn["mail"];
				$user->login= $queryReturn["login"];
				$user->password= Functions::decrypt($queryReturn["password"]);
				$user->lastIp= $queryReturn["lastIp"];
				$user->creationDate= $queryReturn["creationDate"];
				$user->modificationDate= $queryReturn["modificationDate"];
				$user->picture= $queryReturn["picture"];
				$user->state= $queryReturn["state"];
				$user->rank= $queryReturn["rank"];
				$user->group= $queryReturn["group"];
				$user->description= $queryReturn["description"];
				$user->pseudonyme= $queryReturn["pseudonyme"];
				$user->configuration= $queryReturn["configuration"];
				if($return==User::JSON) $user = $user->toJson();
				$users[] = $user;
				unset($user);
			}
		}else{
			exit ('User.'.__METHOD__.') -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
			if($return==User::JSON) $users = json_encode($users);
			return $users;
	}

	/**
	* Méthode de selection unique d'élements de la table User
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $operation="=" definis le type d'operateur pour la requete select
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <User> $User ou false si aucun objet n'est trouvé en base
	*/
	public static function load($columns,$values,$operation='=',$return=User::OBJECT,$debug=0){
		$users = User::loadAll($columns,$values,null,'1',$operation,$return,$debug);
		if(!isset($users[0]))$users[0] = false;
		return $users[0];
	}

	/**
	* Methode de comptage des éléments de la table user
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return<Integer> nombre de ligne dans la table des user
	*/
	public static function rowCount($debug=0)
	{
		$query = 'SELECT COUNT(*) FROM user';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
		$number = mysql_fetch_array($myQuery);
		return $number[0];
	}	
	
	/**
	* Méthode de supression d'elements de la table User
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
			$query = 'DELETE FROM `user` WHERE '.$whereClause.' ;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			mysql_query($query);
		}else{
			exit ('User.'.__METHOD__.' -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
	}
	
	
	/**
	 * Verifie que l'utilisateur est présent en bdd et return l'objet utilisateur si c'est le cas
	 * @author Valentin CARRUESCO
	 * @category SQL/SESSION
	 * @param <String> identifiant
	 * @param <String> mot de passe
	 * @return <Object> objet utilisateur ou false
	 */

	public static function exist($login,$mdp){
		$utilisateur = User::load(array('login','password'),array($login,Functions::crypt($mdp)));
		if($utilisateur==false){
			Logs::put(0,'EXIST[ECHEC]','Verification d\'un utilisateur en bdd: id:'.$login);
		}else{
			Logs::put(0,'EXIST[REUSSITE]','Verification d\'un utilisateur en bdd, id:'.$login);
		}
		return $utilisateur;
	}
	
		/**
	 * Verifie que l'utilisateur dispose des droits crud pour acceder a la section $section
	 * @author Valentin CARRUESCO
	 * @category SQL/SESSION
	 * @param <String> $section
	 * @param <String> $droits ('c','r','u','d'))
	 * @return <Boolean> retourne true si l'utilisateur dispose du droit
	 */
	public function can($section,$droits,$debug=false){
		$retour = false;
		$droits = strtolower($droits);
		$rank = $this->getRank();

		$listeAcces = $rank->getAcces();
		if($debug)echo "Tests pour la section:".$section." du droit:".$droits;
		if(count($listeAcces)!=0){
			foreach($listeAcces as $key=>$value){
					
				if($value->getSection()->getName()==$section){
					switch($droits){
						case 'c':
							if($value->getCreate()==1){
								$retour = true;
							}
							break;
						case 'r':
							if($value->getRead()==1){
								$retour = true;
							}
							break;
						case 'u':
							if($value->getUpdate()==1){
								$retour = true;
							}
							break;
						case 'd':
							if($value->getDelete()==1){
								$retour = true;
							}
							break;
					}
				}
			}
		}


		return $retour;
	}

	/**
	 * Verifie que l'email utilisateur est correcte
	 * @author Valentin CARRUESCO
	 * @category STRING/EMAIL
	 * @return <Boolean> retourne true si l'email est correcte, et string error si l'email est incorrecte
	 */

	public function isRealEmail(){
		$retour = true;
		$Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
		if(preg_match($Syntaxe,$this->getEmail())) {
			$listeNoireDomaine = explode(';',BLACKLIST_DOMAIN);
			$domaine = substr($this->getEmail(),strrpos($this->getEmail(),'@')+1);
			foreach($listeNoireDomaine as $key=>$value){
				if($domaine==$value){
					$retour = 'Le domaine '.$domaine.' est sur liste noire car il s\'agit d\'une adresse jetable';
				}
			}
		}else {
			$retour = 'Mauvais format d\'email';
		}
		return $retour;
	}

	public function getInitials(){
		return strtoupper(substr($this->getFirstName(),0,1).substr($this->getName(),0,1));
	}
	
	// ACCESSEURS

	/**
	* Méthode de récuperation de l'attribut id de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> id
	*/
	
	public function getId(){
		return $this->id;
	}
	
	/**
	* Méthode de définition de l'attribut id de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	*/

	public function setId($id){
		$this->id = $id;
	}
	
		/**
	* Méthode de récuperation de l'attribut debug de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> debug
	*/
	
	public function getDebug(){
		return $this->debug;
	}
	
	/**
	* Méthode de définition de l'attribut debug de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <boolean> $debug 
	*/

	public function setDebug($debug){
		$this->debug = $debug;
	}

	/**
	* Méthode de récuperation de l'attribut Name de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> name
	*/

	public function getName(){
		return $this->name;
	}

	/**
	* Méthode de définition de l'attribut Name de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $name
	* @return Aucun retour
	*/

	public function setName($name){
		$this->name = strtoupper($name);
	}

	/**
	* Méthode de récuperation de l'attribut FirstName de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> firstName
	*/

	public function getFirstName(){
		return $this->firstName;
	}

	/**
	* Méthode de définition de l'attribut FirstName de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $firstName
	* @return Aucun retour
	*/

	public function setFirstName($firstName){
		$this->firstName = ucfirst(strtolower($firstName));
	}

	
	/**
	 * Méthode de récuperation du nom entier de l'utilisateur courant (ex : Valentin CARRUESCO)
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> $this->name + $this->prenom
	 */
	public function getFullName(){
		return $this->getFirstName().' '.$this->getName();
	}
	
	/**
	* Méthode de récuperation de l'attribut Birth de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> birth
	*/

	public function getBirth(){
		return $this->birth;
	}

	/**
	* Méthode de définition de l'attribut Birth de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $birth
	* @return Aucun retour
	*/

	public function setBirth($birth){
		$this->birth = $birth;
	}
	
	/**
	 * Méthode de récuperation de l'attribut datenaissance formaté de la classe Utilisateur
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param modèle de date (défaut='d/m/Y')
	 * @return <Attribute> dateNaissance (dd/mm/yyyy)
	 */

	public function getBirthFormat($pattern='d/m/Y'){
		return date($pattern,$this->birth);
	}

	/**
	* Méthode de récuperation de l'attribut Sex de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> sex
	*/

	public function getSex(){
		return $this->sex;
	}

	/**
	* Méthode de définition de l'attribut Sex de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $sex
	* @return Aucun retour
	*/

	public function setSex($sex){
		$this->sex = $sex;
	}
	
	/**
	 * Méthode de récuperation de l'attribut sexe formaté de la classe Utilisateur
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> sexe (homme-femme)
	 */

	public function getSexFormat(){
		if($this->sex=='H'){
			return 'Homme';
		}else{
			return 'Femme';
		}
	}

	/**
	* Méthode de récuperation de l'attribut Location de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> location
	*/

	
	public function getLocationId(){
		return $this->location;
	}
	
	public function getLocation(){
		return Location::load(array('id'),array($this->location));
	}

	/**
	* Méthode de définition de l'attribut Location de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $location
	* @return Aucun retour
	*/

	public function setLocation($location){
		$this->location = $location;
	}

	/**
	* Méthode de récuperation de l'attribut Phone de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> phone
	*/

	public function getPhone(){
		return $this->phone;
	}

	/**
	* Méthode de définition de l'attribut Phone de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $phone
	* @return Aucun retour
	*/

	public function setPhone($phone){
		$this->phone = $phone;
	}

	/**
	* Méthode de récuperation de l'attribut CellPhone de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> cellPhone
	*/

	public function getCellPhone(){
		return $this->cellPhone;
	}

	/**
	* Méthode de définition de l'attribut CellPhone de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $cellPhone
	* @return Aucun retour
	*/

	public function setCellPhone($cellPhone){
		$this->cellPhone = $cellPhone;
	}

	/**
	* Méthode de récuperation de l'attribut Mail de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> mail
	*/

	public function getMail(){
		return $this->mail;
	}

	/**
	* Méthode de définition de l'attribut Mail de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $mail
	* @return Aucun retour
	*/

	public function setMail($mail){
		$this->mail = $mail;
	}

	/**
	* Méthode de récuperation de l'attribut Login de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> login
	*/

	public function getLogin(){
		return $this->login;
	}

	/**
	* Méthode de définition de l'attribut Login de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $login
	* @return Aucun retour
	*/

	public function setLogin($login){
		$this->login = $login;
	}

	/**
	* Méthode de récuperation de l'attribut Password de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> password
	*/

	public function getPassword(){
		return $this->password;
	}

	/**
	* Méthode de définition de l'attribut Password de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $password
	* @return Aucun retour
	*/

	public function setPassword($password){
		$this->password = $password;
	}
	

	/**
	* Méthode de récuperation de l'attribut LastIp de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> lastIp
	*/

	public function getLastIp(){
		return $this->lastIp;
	}

	/**
	* Méthode de définition de l'attribut LastIp de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $lastIp
	* @return Aucun retour
	*/

	public function setLastIp($lastIp){
		$this->lastIp = $lastIp;
	}

	/**
	* Méthode de récuperation de l'attribut CreationDate de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> creationDate
	*/

	public function getCreationDate(){
		return $this->creationDate;
	}
	
	public function getCreationDateFormat($pattern='d/m/Y'){
		return date($pattern,$this->creationDate);
	}

	/**
	* Méthode de définition de l'attribut CreationDate de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $creationDate
	* @return Aucun retour
	*/

	public function setCreationDate($creationDate){
		$this->creationDate = $creationDate;
	}

	/**
	* Méthode de récuperation de l'attribut ModificationDate de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> modificationDate
	*/

	public function getModificationDate(){
		return $this->modificationDate;
	}
	
	public function getModificationDateFormat($pattern='d/m/Y'){
		return date($pattern,$this->modificationDate);
	}

	/**
	* Méthode de définition de l'attribut ModificationDate de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $modificationDate
	* @return Aucun retour
	*/

	public function setModificationDate($modificationDate){
		$this->modificationDate = $modificationDate;
	}

	/**
	* Méthode de récuperation de l'attribut Picture de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> picture
	*/

	public function getPicture(){
		return $this->picture;
	}

	/**
	* Méthode de définition de l'attribut Picture de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $picture
	* @return Aucun retour
	*/

	public function setPicture($picture){
		$this->picture = $picture;
	}

	/**
	* Méthode de récuperation de l'attribut State de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> state
	*/

	public function getState(){
		return $this->state;
	}

	/**
	* Méthode de définition de l'attribut State de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $state
	* @return Aucun retour
	*/

	public function setState($state){
		$this->state = $state;
	}

	/**
	* Méthode de récuperation de l'attribut Rank de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> rank
	*/
	
	public function getRankId(){
		return $this->rank;
	}
	
	/**
	* Méthode de récuperation de l'attribut Rank de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> rank
	*/

	public function getRank(){
		$rank = Rank::load(array('id'),array($this->rank));
		return $rank;
	}

	/**
	* Méthode de définition de l'attribut Rank de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $rank
	* @return Aucun retour
	*/

	public function setRank($rank){
		$this->rank = $rank;
	}

	/**
	* Méthode de récuperation de l'attribut Group de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> group
	*/

	public function getGroupId(){
		return $this->group;
	}
	
	public function getGroup(){
		return Group::load(array('id'),array($this->group));
	}

	/**
	* Méthode de définition de l'attribut Group de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $group
	* @return Aucun retour
	*/

	public function setGroup($group){
		$this->group = $group;
	}

	/**
	* Méthode de récuperation de l'attribut Description de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> description
	*/

	public function getDescription(){
		return $this->description;
	}
	
	public function getDescriptionFormat($limit=40){
		return Functions::truncate($this->description,$limit);
	}

	/**
	* Méthode de définition de l'attribut Description de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $description
	* @return Aucun retour
	*/

	public function setDescription($description){
		$this->description = $description;
	}

	/**
	* Méthode de récuperation de l'attribut Pseudonyme de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> pseudonyme
	*/

	public function getPseudonyme(){
		return $this->pseudonyme;
	}

	/**
	* Méthode de définition de l'attribut Pseudonyme de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $pseudonyme
	* @return Aucun retour
	*/

	public function setPseudonyme($pseudonyme){
		$this->pseudonyme = $pseudonyme;
	}

	/**
	* Méthode de récuperation de l'attribut Configuration de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> configuration
	*/

	public function getConfigurationId(){
		return $this->configuration;
	}
	
	public function getConfiguration(){
		return Configuration::loadConfig($this->getId());
	}

	/**
	* Méthode de définition de l'attribut Configuration de la classe User
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $configuration
	* @return Aucun retour
	*/

	public function setConfiguration($configuration){
		$this->configuration = $configuration;
	}

}
?>
