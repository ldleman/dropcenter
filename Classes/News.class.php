<?php

/*
	@nom: News
	@auteur: Valentin CARRUESCO (valentin.carruesco@sys1.fr)
	@date de création: 05/10/2011 à 16:04
	@description: Classe de gestion des actualités
*/

class News
{
	private $id;
	private $titre;
	private $date;
	private $message;
	private $auteur;
	private $image;
	private $tags;
	private $etat;
	private $source;
	public $debug=0;

	public function __construct($titre=null,$date=null,$message=null,$auteur=null,$image=null,$tags=null,$etat=null,$source=null){
		//Opérations du constructeur...
		if($titre!=null) $this->titre=$titre;
		if($date!=null){ $this->date=$date;}else{$this->date = time();}
		if($message!=null) $this->message=$message;
		if($auteur!=null) $this->auteur=$auteur;
		if($image!=null) $this->image=$image;
		if($tags!=null) $this->tags=$tags;
		if($etat!=null) $this->etat=$etat;
		if($source!=null) $this->source=$source;
	}

	public function __call($methode, $attributs){
		//Action sur appel d'une méthode inconnue
	}

	public function __destruct(){
		//Action lors du unset de l'objet
	}

	public function __toString(){
		$retour = "";
		$retour .= "instance de la classe News : <br/>";
		$retour .= '$titre : '.$this->titre.'<br/>';
		$retour .= '$date : '.$this->date.'<br/>';
		$retour .= '$message : '.$this->message.'<br/>';
		$retour .= '$auteur : '.$this->auteur.'<br/>';
		$retour .= '$image : '.$this->image.'<br/>';
		$retour .= '$tags : '.$this->tags.'<br/>';
		$retour .= '$etat : '.$this->etat.'<br/>';
		$retour .= '$source : '.$this->source.'<br/>';
		return $retour;
	}

	public  function __clone(){
		//Action lors du clonage de l'objet
	}

	/**
	* Methode de mise en session de l'objet news
	* @author Valentin CARRUESCO
	* @category SESSION
	* @param <String> $name=nom de la classe, definis la clé de l'objet en session
	* @return Aucun retour
	*/

	public function session($name=news){
		$_SESSION[$name] = serialize($this);
	}

	// GESTION SQL
	
	/**
	* Methode de comptage des éléments visibles (etat=1) de la table news
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return<Integer> nombre de ligne dans la table des news
	*/
	public static function rowCountVisible($debug=0)
	{
		$query = 'SELECT COUNT(*) FROM news WHERE etat = 1;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
		$number = mysql_fetch_array($myQuery);
		return $number[0];
	}

	

	/**
	* Methode de suppression de la table news
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function destroy($debug=0)
	{
		$query = 'DROP TABLE IF EXISTS news;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de nettoyage de la table news
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function truncate($debug=0)
	{
			$query = 'TRUNCATE TABLE news;';
			if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode de creation de la table news
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return Aucun retour
	*/
	public static function create($debug=0){
		$query = 'CREATE TABLE IF NOT EXISTS `news` (';
		$query .= '`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,';
		$query .='titre VARCHAR ( 225 )  NOT NULL';$query .=',';
		$query .='date VARCHAR ( 225 )  NOT NULL';$query .=',';
		$query .='message VARCHAR ( 225 )  NOT NULL';$query .=',';
		$query .='auteur VARCHAR ( 225 )  NOT NULL';$query .=',';
		$query .='image VARCHAR ( 225 )  NOT NULL';$query .=',';
		$query .='tags VARCHAR ( 225 )  NOT NULL';$query .=',';
		$query .='etat INT ( 11 )  NOT NULL';$query .=',';
		$query .='source TEXT  NOT NULL';
		$query .= ');';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	* Methode d'insertion ou de modifications d'elements de la table news
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param  Aucun
	* @return Aucun retour
	*/

	public function save(){
		if(isset($this->id)){
			$query = 'UPDATE news'.
			' SET '.
			'titre="'.$this->titre.'"'.','.
			'date="'.$this->date.'"'.','.
			'message="'.$this->message.'"'.','.
			'auteur="'.$this->auteur.'"'.','.
			'image="'.$this->image.'"'.','.
			'tags="'.$this->tags.'"'.','.
			'etat="'.$this->etat.'"'.','.
			'source="'.$this->source.'"'.			
			' WHERE id="'.$this->id.'";';
		}else{
			$query = 'INSERT INTO news('.
			'titre'.','.
			'date'.','.
			'message'.','.
			'auteur'.','.
			'image'.','.
			'tags'.','.
			'etat'.','.
			'source'.			
			')VALUES("'.
			$this->titre.'","'.
			$this->date.'","'.
			$this->message.'","'.
			$this->auteur.'","'.
			$this->image.'","'.
			$this->tags.'","'.
			$this->etat.'","'.
			$this->source.			
			'");';
		}
		if($this->debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		mysql_query($query)or die(mysql_error());
		if(!isset($this->id)) $this->id = mysql_insert_id ();
	}

	/**
	* Méthode de modification d'éléments de la table news
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
		$query = 'UPDATE news'.
				' SET ';
		for ($i=0;$i<sizeof($keys);$i++){
		$query .= $keys[$i].'="'.$values[$i].'" ';
		if($i<sizeof($keys)-1)$query .=',';
		}
		$query .=' WHERE '; 
		for ($i=0;$i<sizeof($keys2);$i++){
		$query .= $keys2[$i].'="'.$values2[$i].'" ';
		if($i<sizeof($keys2)-1)$query .='AND ';
		}
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		mysql_query($query)or die(mysql_error());
	}

	/**
	* Méthode de selection de tous les elements de la table news
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<News>> $newss
	*/

	public static function populate($order=null,$limit=null,$debug=0){
		return News::loadAll(array(),array(),$order,$limit,$debug);
	}

	/**
	* Méthode de selection multiple d'elements de la table news
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $ordre=null
	* @param <String> $limite=null
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <Array<News>> $newss
	*/

	public static function loadAll($columns,$values,$order=null,$limit=null,$debug=0){
		$newss = array();
		$whereClause = '';
		if(sizeof($columns)==sizeof($values)){
		if(sizeof($columns)!=0){
		$whereClause .= ' WHERE ';
			for($i=0;$i<sizeof($columns);$i++){
				if($i!=0)$whereClause .= ' AND ';
				$whereClause .= $columns[$i].'="'.$values[$i].'"';
			}
		}
			$query = 'SELECT * FROM news '.$whereClause.' ';
			if($order!=null) $query .='ORDER BY '.$order.' ';
			if($limit!=null) $query .='LIMIT '.$limit.' ';
			$query .=';';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$execQuery = mysql_query($query);
			$t = unserialize($_SESSION['traduction']);
			while($queryReturn = mysql_fetch_assoc($execQuery)){
				$news = new News();
				$news->id= $queryReturn["id"];
				$news->titre=$t->get($queryReturn["titre"]);
				$news->date= $queryReturn["date"];
				$news->message= $t->get($queryReturn["message"]);
				$news->auteur= $queryReturn["auteur"];
				$news->image= $queryReturn["image"];
				$news->tags= $queryReturn["tags"];
				$news->etat= $queryReturn["etat"];
				$news->source= $queryReturn["source"];
				$newss[] = $news;
				unset($news);
			}
		}else{
			exit ('News.'.__METHOD__.') -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
			return $newss;
	}

	/**
	* Méthode de selection unique d'elements de la table news
	* @author Valentin CARRUESCO
	* @category manipulation SQL
	* @param <Array> $colonnes (WHERE)
	* @param <Array> $valeurs (WHERE)
	* @param <String> $debug=0 active le debug mode (0 ou 1)
	* @return <News> $news
	*/

	public static function load($columns,$values,$debug=0){
		$whereClause = '';
		if(sizeof($columns)==sizeof($values)){
		if(sizeof($columns)!=0){
		$whereClause .= ' WHERE ';
			for($i=0;$i<sizeof($columns);$i++){
				if($i!=0)$whereClause .= ' AND ';
				$whereClause .= $columns[$i].'="'.$values[$i].'"';
			}
		}
			$query = 'SELECT * FROM news '.$whereClause.' ;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$queryReturn = mysql_fetch_assoc(mysql_query($query));
			$t = unserialize($_SESSION['traduction']);
			$news = new News();
			$news->id= $queryReturn["id"];
			$news->titre= $t->get($queryReturn["titre"]);
			$news->date= $queryReturn["date"];
			$news->message= $t->get($queryReturn["message"]);
			$news->auteur= $queryReturn["auteur"];
			$news->image= $queryReturn["image"];
			$news->tags= $queryReturn["tags"];
			$news->etat= $queryReturn["etat"];
			$news->source= $queryReturn["source"];
		}else{
			exit ('News.'.__METHOD__.' -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
			return $news;
	}

	/**
	* Méthode de supression d'elements de la table news
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
			$query = 'DELETE FROM news WHERE '.$whereClause.' ;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			mysql_query($query);
		}else{
			exit ('News.'.__METHOD__.' -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
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
	* Méthode de récuperation de l'attribut titre de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> titre
	*/

	public function getTitre(){
		return stripslashes($this->titre);
	}

	/**
	* Méthode de définition de l'attribut titre de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $titre
	* @return Aucun retour
	*/

	public function setTitre($titre){
		$this->titre = $titre;
	}

	/**
	* Méthode de récuperation de l'attribut date formate de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> date
	*/

	public function getDateFormat(){
		return date('d-m-Y h:i',$this->date);
	}
	
	/**
	* Méthode de récuperation de l'attribut date de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> date
	*/

	public function getDate(){
		return $this->date;
	}

	/**
	* Méthode de définition de l'attribut date de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $date
	* @return Aucun retour
	*/

	public function setDate($date){
		$this->date = $date;
	}

	/**
	* Méthode de récuperation de l'attribut message de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> message
	*/

	public function getMessage(){
		return stripslashes($this->message);
	}

	/**
	* Méthode de récuperation de l'attribut message limité a x caracteres de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> message
	*/

	public function getShortMessage(){
		return Fonction::tronquer($this->getMessage(),100);
	}

	/**
	* Méthode de définition de l'attribut message de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $message
	* @return Aucun retour
	*/

	public function setMessage($message){
		$this->message = $message;
	}

	/**
	* Méthode de récuperation de l'attribut auteur de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> auteur
	*/

	public function getAuteur(){
		return $this->auteur;
	}

	/**
	* Méthode de définition de l'attribut auteur de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $auteur
	* @return Aucun retour
	*/

	public function setAuteur($auteur){
		$this->auteur = $auteur;
	}

	/**
	* Méthode de récuperation de l'attribut image de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> image
	*/

	public function getImage(){
		return $this->image;
	}

	/**
	* Méthode de définition de l'attribut image de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $image
	* @return Aucun retour
	*/

	public function setImage($image){
		$this->image = $image;
	}

	/**
	* Méthode de récuperation de l'attribut tags de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> tags
	*/

	public function getTags(){
		return $this->tags;
	}

	/**
	* Méthode de définition de l'attribut tags de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $tags
	* @return Aucun retour
	*/

	public function setTags($tags){
		$this->tags = $tags;
	}

	/**
	* Méthode de récuperation de l'attribut etat de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> etat
	*/

	public function getEtat(){
		return $this->etat;
	}

	/**
	* Méthode de définition de l'attribut etat de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $etat
	* @return Aucun retour
	*/

	public function setEtat($etat){
		$this->etat = $etat;
	}

	/**
	* Méthode de récuperation de l'attribut source de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param Aucun
	* @return <Attribute> source
	*/

	public function getSource(){
		return $this->source;
	}

	/**
	* Méthode de définition de l'attribut source de la classe News
	* @author Valentin CARRUESCO
	* @category Accesseur
	* @param <Attribute> $source
	* @return Aucun retour
	*/

	public function setSource($source){
		$this->source = $source;
	}
}
?>