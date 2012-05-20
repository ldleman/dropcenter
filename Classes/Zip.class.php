<?php

/*
 @nom: Zip
 @auteur: Valentin CARRUESCO (valentincarruesco@yahoo.fr)
 @date de création: 14/11/2011 12:12:46
 @description: &gt;Classe de gestion des fichiers compress&Atilde;&copy;s (zip,rar...)
 @language :
 */

class Zip
{

	private $name;
	private $path;
	private $comment;
	private $filesNumber;
	private $size;
	private $files;
	private $zip;
	private $debug = 0;

	public function __construct($name=null, $path=null, $comment=null, $filesNumber=null, $size=null, $files=null ){
		//Opérations du constructeur...

		if($name!=null) $this->name=$name;
		if($path!=null) $this->path=$path;
		if($comment!=null) $this->comment=$comment;
		if($filesNumber!=null) $this->filesNumber=$filesNumber;
		if($size!=null) $this->size=$size;
		if($files!=null) $this->files=$files;
	}

	public function addFile($file){
	  $this->zip->addFile($file, $file);
	}
	
	public function open($file){
		$return = false;
		$this->path=$path = $file;

		$this->zip = new ZipArchive();
		if($this->zip->open($file)){
			
		$this->name = $this->zip->filename;
		$this->comment = $this->zip->comment;
		$this->filesNumber = $this->zip->numFiles;
		$files = array();
		for ($i=0; $i<$this->zip->numFiles;$i++) {
			$stats = $this->zip->statIndex($i);
			$file = array(
		'name'=>$stats['name'],
		'date'=>$stats['mtime'],
		'size'=>$stats['size'],
		'zip_size'=>$stats['comp_size'],
		'content'=>$this->zip->getFromIndex($i)
			);
			$files[$i] = $file;
		}
		$this->setFiles($files);
		$return = true;
		}
		return $return;
	}

	public function __call($methode, $attributs){
		//Action sur appel d'une méthode inconnue
	}

	public function close(){
		$this->zip->close();
		$this->zip=null;
	}
	public function __destruct(){
		if($this->zip!=null){
		$this->zip->close();
		$this->zip=null;
		}
	}


	public function extract($destination){
		$this->zip->extractTo($destination);
	}


	public function __toString(){
		$retour = "instance de la classe Zip : <br/>";
		$retour .= '$id : '.$this->getId().'<br/>';

		$retour .= '$name : '.$this->name.'<br/>';
		$retour .= '$path : '.$this->path.'<br/>';
		$retour .= '$comment : '.$this->comment.'<br/>';
		$retour .= '$filesNumber : '.$this->filesNumber.'<br/>';
		$retour .= '$size : '.$this->size.'<br/>';
		$retour .= '$files : '.$this->files.'<br/>';
		return $retour;
	}


	public  function __clone(){
		//Action lors du clonage de l'objet Zip
	}


	/**
	 * Methode de mise en session de l'objet Zip
	 * @author Valentin CARRUESCO
	 * @category SESSION
	 * @param <String> $name=nom de la classe, definis la clé de l'objet en session
	 * @return Aucun retour
	 */
	public function session($name="Zip"){
		$_SESSION[$name] = serialize($this);
	}


	/**
	 * Methode de traduction de l'objet Zip en json (necessite au minimum de PHP 5.2 et de l'extension l'extension JSON de PECL)
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
	 * Methode de suppression de la table Zip
	 * @author Valentin CARRUESCO
	 * @category manipulation SQL
	 * @param <String> $debug=0 active le debug mode (0 ou 1)
	 * @return Aucun retour
	 */
	public static function destroy($debug=0)
	{
		$query = 'DROP TABLE IF EXISTS zip;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	 * Methode de nettoyage de la table Zip
	 * @author Valentin CARRUESCO
	 * @category manipulation SQL
	 * @param <String> $debug=0 active le debug mode (0 ou 1)
	 * @return Aucun retour
	 */
	public static function truncate($debug=0)
	{
		$query = 'TRUNCATE TABLE zip;';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	 * Methode de creation de la table Zip
	 * @author Valentin CARRUESCO
	 * @category manipulation SQL
	 * @param <String> $debug=0 active le debug mode (0 ou 1)
	 * @return Aucun retour
	 */
	public static function create($debug=0){
		$query = 'CREATE TABLE IF NOT EXISTS `zip` (';
		$query .= '`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,';

		$query .='`name` $   NOT NULL,';
		$query .='`path` $   NOT NULL,';
		$query .='`comment` $   NOT NULL,';
		$query .='`filesNumber` $   NOT NULL,';
		$query .='`size` $   NOT NULL,';
		$query .='`files` $   NOT NULL';
		$query .= ');';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
	}

	/**
	 * Methode d'insertion ou de modifications d'elements de la table Zip
	 * @author Valentin CARRUESCO
	 * @category manipulation SQL
	 * @param  Aucun
	 * @return Aucun retour
	 */

	public function save(){
		if(isset($this->id)){
			$query = 'UPDATE `zip`'.
			' SET '.
				
			'`name`="'.$this->name.'",'.
			'`path`="'.$this->path.'",'.
			'`comment`="'.$this->comment.'",'.
			'`filesNumber`="'.$this->filesNumber.'",'.
			'`size`="'.$this->size.'",'.
			'`files`="'.$this->files.'"'.
			' WHERE `id`="'.$this->id.'";';
		}else{
			$query = 'INSERT INTO `zip`('.
				
			'`name`,'.
			'`path`,'.
			'`comment`,'.
			'`filesNumber`,'.
			'`size`,'.
			'`files`'.			
			')VALUES("'.
				
			$this->name.'",'.
			$this->path.'",'.
			$this->comment.'",'.
			$this->filesNumber.'",'.
			$this->size.'",'.
			$this->files.'"'.
			');';
		}
		if($this->debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		mysql_query($query)or die(mysql_error());
	}

	/**
	 * Méthode de modification d'éléments de la table Zip
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
		$query = 'UPDATE `zip`'.
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
	 * Méthode de selection de tous les elements de la table Zip
	 * @author Valentin CARRUESCO
	 * @category manipulation SQL
	 * @param <String> $ordre=null
	 * @param <String> $limite=null
	 * @param <String> $debug=0 active le debug mode (0 ou 1)
	 * @return <Array<Zip>> $Zips
	 */

	public static function populate($order=null,$limit=null,$debug=0){
		return Zip::loadAll(array(),array(),$order,$limit,$debug);
	}

	/**
	 * Méthode de selection multiple d'elements de la table Zip
	 * @author Valentin CARRUESCO
	 * @category manipulation SQL
	 * @param <Array> $colonnes (WHERE)
	 * @param <Array> $valeurs (WHERE)
	 * @param <String> $ordre=null
	 * @param <String> $limite=null
	 * @param <String> $debug=0 active le debug mode (0 ou 1)
	 * @return <Array<Zip>> $Zips
	 */

	public static function loadAll($columns,$values,$order=null,$limit=null,$debug=0){
		$Zips = array();
		$whereClause = '';
		if(sizeof($columns)==sizeof($values)){
			if(sizeof($columns)!=0){
				$whereClause .= ' WHERE ';
				for($i=0;$i<sizeof($columns);$i++){
					if($i!=0)$whereClause .= ' AND ';
					$whereClause .= '`'.$columns[$i].'`="'.$values[$i].'"';
				}
			}
			$query = 'SELECT * FROM `zip` '.$whereClause.' ';
			if($order!=null) $query .='ORDER BY `'.$order.'` ';
			if($limit!=null) $query .='LIMIT '.$limit.' ';
			$query .=';';
			if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			$execQuery = mysql_query($query);
			while($queryReturn = mysql_fetch_assoc($execQuery)){
				$zip = new Zip();
				$zip->id= $queryReturn["id"];

				$zip->name= $queryReturn["name"];
				$zip->path= $queryReturn["path"];
				$zip->comment= $queryReturn["comment"];
				$zip->filesNumber= $queryReturn["filesNumber"];
				$zip->size= $queryReturn["size"];
				$zip->files= $queryReturn["files"];
				$zips[] = $zip;
				unset($zip);
			}
		}else{
			exit ('Zip.'.__METHOD__.') -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
		return $zips;
	}

	/**
	 * Méthode de selection unique d'elements de la table Zip
	 * @author Valentin CARRUESCO
	 * @category manipulation SQL
	 * @param <Array> $colonnes (WHERE)
	 * @param <Array> $valeurs (WHERE)
	 * @param <String> $debug=0 active le debug mode (0 ou 1)
	 * @return <Zip> $Zip
	 */

	public static function load($columns,$values,$debug=0){
		$zips = Zip::loadAll($columns,$values,null,'1',$debug);
		return $zips[0];
	}

	/**
	 * Methode de comptage des éléments de la table zip
	 * @author Valentin CARRUESCO
	 * @category manipulation SQL
	 * @param <String> $debug=0 active le debug mode (0 ou 1)
	 * @return<Integer> nombre de ligne dans la table des zip
	 */
	public static function rowCount($debug=0)
	{
		$query = 'SELECT COUNT(*) FROM zip';
		if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
		$myQuery = mysql_query($query) or die(mysql_error());
		$number = mysql_fetch_array($myQuery);
		return $number[0];
	}

	/**
	 * Méthode de supression d'elements de la table Zip
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
			$query = 'DELETE FROM `zip` WHERE '.$whereClause.' ;';
			if($debug==1)echo '<br>'.__METHOD__.' : Requete --> '.$query.'<br>';
			mysql_query($query);
		}else{
			exit ('Zip.'.__METHOD__.' -> Le nombre de colonnes ne correspond pas au nombre de valeurs');
		}
	}




	// ACCESSEURS

	/**
	 * Méthode de récuperation de l'attribut id de la classe Zip
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> id
	 */

	public function getId(){
		return $this->id;
	}

	/**
	 * Méthode de définition de l'attribut id de la classe Zip
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> id
	 */

	public function setId($id){
		$this->id = $id;
	}

	/**
	 * Méthode de récuperation de l'attribut Name de la classe Zip
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> name
	 */

	public function getName(){
		return $this->name;
	}

	/**
	 * Méthode de définition de l'attribut Name de la classe Zip
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $name
	 * @return Aucun retour
	 */

	public function setName($name){
		$this->name = $name;
	}

	/**
	 * Méthode de récuperation de l'attribut Path de la classe Zip
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> path
	 */

	public function getPath(){
		return $this->path;
	}

	/**
	 * Méthode de définition de l'attribut Path de la classe Zip
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $path
	 * @return Aucun retour
	 */

	public function setPath($path){
		$this->path = $path;
	}

	/**
	 * Méthode de récuperation de l'attribut Comment de la classe Zip
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> comment
	 */

	public function getComment(){
		return $this->comment;
	}

	/**
	 * Méthode de définition de l'attribut Comment de la classe Zip
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $comment
	 * @return Aucun retour
	 */

	public function setComment($comment){
		$this->comment = $comment;
	}

	/**
	 * Méthode de récuperation de l'attribut FilesNumber de la classe Zip
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> filesNumber
	 */

	public function getFilesNumber(){
		return $this->filesNumber;
	}

	/**
	 * Méthode de définition de l'attribut FilesNumber de la classe Zip
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $filesNumber
	 * @return Aucun retour
	 */

	public function setFilesNumber($filesNumber){
		$this->filesNumber = $filesNumber;
	}

	/**
	 * Méthode de récuperation de l'attribut Size de la classe Zip
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> size
	 */

	public function getSize(){
		return $this->size;
	}

	/**
	 * Méthode de définition de l'attribut Size de la classe Zip
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $size
	 * @return Aucun retour
	 */

	public function setSize($size){
		$this->size = $size;
	}

	/**
	 * Méthode de récuperation de l'attribut Files de la classe Zip
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> files
	 */

	public function getFiles(){
		return $this->files;
	}

	/**
	 * Méthode de définition de l'attribut Files de la classe Zip
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $files
	 * @return Aucun retour
	 */

	public function setFiles($files){
		$this->files = $files;
	}


	public function getZip(){
		return $this->zip;
	}


	public function setZip($files){
		$this->zip = $zip;
	}


}
?>