<?php
//é
require_once('config.php');

function rewindPath($path){
	$path = str_replace('/..','',$path);
	$path =substr($path,0,strrpos($path,'/'));
	return $path;
}

/**
 *
 * Scanne un dossier et retourne ses fichiers sous forme d'une liste de tableaux contenant le nom, l'extension et l'url du fichier
 * @author Idleman
 * @param string $folder
 * @return array<array<>> $realFiles
 */

function scanFolder($folder){

	$folder = utf8_decode($folder);

	$noFolders = array(
	$folder.'.dc',
	$folder.'.'
	);

	$folder = str_replace('//','/',$folder);
	$root = getConfig('ROOT');


	if(realpath($folder)==realpath('../'.UPLOAD_FOLDER))$noFolders []=$folder.'..';
	$filteredFiles = array();


	//if($folder!='../uploads/') var_dump(mb_detect_encoding($folder),$folder);
	$files = scandir($folder);
	$realFiles = array();
	foreach($files as $file){
		$fileArray = array();
		//echo var_dump($folder.$file);
		if(DISPLAY_DOTFILES || (substr($file,0,1)!='.' || $file=='..')   ){
		if(is_file($folder.$file)){
			if(!isset($filter) || in_array(str_replace('../','',utf8_encode($folder.$file)),$filteredFiles)){
				$fileArray['type'] = 'file';
				$fileArray['toolTipName'] =wordwrap(utf8_encode($file),29,'<br/>',true);
				$fileArray['name'] = utf8_encode($file);
				$fileArray['shortname'] =utf8_encode(short($file,NAME_LIMIT,get_extension($file)));
				$fileArray['extension'] =get_extension($file);
				$fileArray['url'] = utf8_encode(str_replace('../','',$folder).$file);
				$fileArray['absoluteUrl'] = $root.'php/action.php?action=openFile&file=../'.$fileArray['url'];
				$fileArray['size'] = getSize($folder.$file);
				$fileArray['published'] = isPublished($folder.$file);
				$mtime = filemtime ($folder.$file);
				$fileArray['mtimeDate'] = date('d/m/Y',$mtime);
				$fileArray['mtimeHour'] = date('h\hi\m',$mtime);
				$realFiles[]=$fileArray;
				unset($fileArray);
			}
		}else{
			if(!in_array($folder.$file, $noFolders) && ( !DISPLAY_AVATAR_FOLDER && realpath($folder.$file)!=realpath('../'.AVATARFOLDER)) ){

				
				$fileArray['type'] = 'folder';
				$fileArray['name'] = utf8_encode($file);
				$fileArray['shortname'] =utf8_encode(short($file,NAME_LIMIT,get_extension($file)));
				$fileArray['url'] = utf8_encode(str_replace('//','/',$folder.'/'.$file));
				if($file=='..')$fileArray['url'] =rewindPath($fileArray['url']);
					
				$fileArray['size'] ='10ko';
				$realFiles[]=$fileArray;
				unset($fileArray);
			}
		}
		}
		
		
		
	}

	return $realFiles;
}




/**
 * Retourne le resume d'une chaine $string au bout de $limit caracteres en ne prenant par compte de l'extension $ext (si c'est un fichier)
 * Enter description here ...
 * @param $string
 * @param $limit
 * @param $ext
 * @author Idleman
 * @return string $shortName
 */

function short($string,$limit,$ext){
	return (strlen($string)>$limit?substr($string,0,$limit-3).NAME_LIMIT_BORDER.$ext:$string);
}


/**
 *
 * Retourne l'extension d'un fichier a partir de son nom
 * @param $file_name
 * @author Idleman
 * @return string $extension
 */

function get_extension($file_name){
	$ext = explode('.', $file_name);
	$ext = (count($ext)==1?null:array_pop($ext));
	return strtolower($ext);
}

function getEvents(){
	if(!file_exists('../'.DCFOLDER.EVENTFILE)) @touch('../'.DCFOLDER.EVENTFILE);
	return file('../'.DCFOLDER.EVENTFILE);
}

/**
 *
 * Lit le fichier JSON des evenements, le parse et les retourne sous forme d'une liste d'objets JSON
 * @author Idleman
 * @return array<JSONObject> $events
 */

function parseEvents(){
	$events = getEvents();
	$parsedEvents = array();
	foreach($events as $event){
		$parsedEvents [] = json_decode($event);
	}
	return $parsedEvents;
}

/**
 *
 * Ajoute un Evenement au fichier JSON de stockage des evenements
 * @author Idleman
 * @param array<> $event
 */

function addEvent($event){
	file_put_contents('../'.DCFOLDER.EVENTFILE,json_encode($event)."\r\n",FILE_APPEND);
}

/**
 *
 * Ajoute un parametre au fichier securise JSON de configuration
 * @author Idleman
 * @param array<> $user
 */
function addConfig($key,$value){
	$config = array($key => $value);
	file_put_contents('../'.DCFOLDER.CONFIGFILE,SECURE_DELIMITER_BEGIN.json_encode($config).SECURE_DELIMITER_END."\r\n",FILE_APPEND);
}




/**
 *
 * Encode le mot de passe fournis en sha1 et md5
 * @param string password
 * @author Idleman
 */

function encode($str){
	return md5(sha1($str));
}

/**
 *
 * Teste l'existence d'un compte utilisateur dans la base.
 * @param string $login
 * @param string $password
 * @author Idleman
 * @return si l'utilisateur existe, il le retourne dans le cas contraire : boolean faux
 */
function exist($login,$password){
	$user = getUser($login);
	return ($user!=false && $user->password==encode($password)?$user:false);
}

/**
 *
 * Teste l'existence d'un compte utilisateur dans la base en fonction de son authToken.
 * @param string $token
 * @author Idleman
 * @return boolean vrai ou faux
 */
function existToken($token){
	$users = parseUsers();
	$target = false;
	foreach($users as $user){
		if(strcasecmp(getToken($user),$token)==0)$target=$user;
	}
	return ($target!=false?$target:false);
}

function getToken($user){
	return sha1(LEFT_HASH.$user->login.$user->password.RIGHT_HASH);
}

function existLogin($login){
	$user = getUser($login);
	return ($user!=false?$user:false);
}



/**
 *
 * Retourne les infos liees a un parametre de configuration sous la forme d'un objet JSON a partir de sa cle
 * @param $login
 * @return JSONObject $target
 * @author Idleman
 */

function getConfig($key){
	$configs = parseConfigs();
	$target = false;
	foreach($configs as $config){
		$config = get_object_vars($config);
		if(isset($config[$key])){
			$target=$config[$key];
		}
	}
	return $target;
}





/**
 *
 * Ajoute un utilisateur au fichier securise JSON de stockage des utilisateurs
 * @author Idleman
 * @param array<> $user
 */
function addUser($user,$encodePassword = true){
	if($encodePassword) $user['password'] = encode($user['password']);
	file_put_contents('../'.DCFOLDER.USERFILE,SECURE_DELIMITER_BEGIN.json_encode($user).SECURE_DELIMITER_END."\r\n",FILE_APPEND);
}

/**
 *
 * Retourne les infos d'un utilisateur sous la forme d'un objet JSON a partir de son login
 * @param $login
 * @return JSONObject $target
 * @author Idleman
 */

function getUser($login){
	$users = parseUsers();
	$target = false;
	foreach($users as $user){
		if(strcasecmp($user->login,$login)==0)$target=$user;
	}
	return $target;
}

/**
 *
 * update les params d'un user à partir de son login
 * @param $login
 * @return JSONObject $target
 * @author H3
 * @edit [21/03/2012] Idleman -> Cryptage du mdp, non modification du mdp si nouveaux mdp vide
 */

function updateUser($login,$values){
	$user = get_object_vars(getUser($login));

	foreach($values as $attr=>$value){
		if ($attr != 'action' && $attr != 'user') {
			if(!($attr == 'password' && ($value =="") || !isset($value))) $user[$attr] = ($attr=='password'?encode($value):$value);
		}
	}
	deleteUser($login);
	addUser($user,false);
	$_SESSION['user'] = serialize((object)$user);
}

/**
 * Supprime une utilisateur de la base a partir de son login
 * @param string $login
 * @author Idleman
 */

function deleteUser($login){
	$users = parseUsers();
	$targets = array();
	unlink('../'.DCFOLDER.USERFILE);
	foreach($users as $currentUser){
		if($currentUser->login!=$login){
			file_put_contents('../'.DCFOLDER.USERFILE,SECURE_DELIMITER_BEGIN.json_encode($currentUser).SECURE_DELIMITER_END."\r\n",FILE_APPEND);
		}
	}
}

/**
 * Parse le fichiers des utilisateurs et les retourne sous forme d'une liste d'objets JSON
 * @param [OPTIONNAL] string $dir
 * @author Idleman
 * @return array<JSONOBject> $users
 */
function parseUsers($dir = '../'){
	$userLines = file($dir.DCFOLDER.USERFILE);
	$users = array();
	foreach($userLines as $userLine){
		if(trim($userLine)!=''){
			$catchedUser = json_decode(str_replace(array(SECURE_DELIMITER_BEGIN,SECURE_DELIMITER_END),'',$userLine));
			if(!isset($catchedUser->avatar) || trim($catchedUser->avatar)==''){

				//if($catchedUser->mail!=''){
				$catchedUser->avatar= getGravatar($catchedUser);

				//}else{
				//	$catchedUser->avatar =AVATARFOLDER.AVATAR_DEFAULT;
				//}
			}
			$users [] = $catchedUser;
		}
	}
	return $users;
}


function deletePublish($file){
	$publishes = parsePublishes();
	$targets = array();
	unlink('../'.DCFOLDER.PUBLISHFILE);
	foreach($publishes as $publish){
		if($publish!=$file){
			file_put_contents('../'.DCFOLDER.PUBLISHFILE,SECURE_DELIMITER_BEGIN.json_encode(utf8_encode($publish)).SECURE_DELIMITER_END."\r\n",FILE_APPEND);
		}
	}
}

/**
 *
 * Ajoute un fichier publié au fichier des publications
 * @author Idleman
 * @param <string> file
 */
function addPublish($file){
	if(!isPublished($file)){
		file_put_contents('../'.DCFOLDER.PUBLISHFILE,SECURE_DELIMITER_BEGIN.json_encode(utf8_encode($file)).SECURE_DELIMITER_END."\r\n",FILE_APPEND);
	}
}

/**
 *
 * Questionne le fichier des publications pour voir si le fichier est publié.
 * @param <string> $file chemin du fichier
 * @return true ou false
 * @author Idleman
 */

function isPublished($file){
	$publishes = parsePublishes();
	$target = false;
	foreach($publishes as $publish){
		if(strcasecmp($publish,$file)==0)$target = true;
	}
	return $target;
}

/**
 * Parse le fichiers des publication et les retourne sous forme d'une liste d'objets JSON
 * @param [OPTIONNAL] string $dir
 * @author Idleman
 * @return array<JSONOBject> $publishes
 */
function parsePublishes($dir = '../'){
	if(!file_exists($dir.DCFOLDER.PUBLISHFILE)) touch($dir.DCFOLDER.PUBLISHFILE);
	$publishesLines = file($dir.DCFOLDER.PUBLISHFILE);
	$publishes = array();
	foreach($publishesLines as $publishLine){
		if(trim($publishLine)!=''){
			$publishes [] = utf8_decode(json_decode(str_replace(array(SECURE_DELIMITER_BEGIN,SECURE_DELIMITER_END),'',$publishLine)));
		}
	}
	return $publishes;
}


/**
 * Parse le fichiers des configurations et les retourne sous forme d'une liste d'objets JSON
 * @param [OPTIONNAL] string $dir
 * @author Idleman
 * @return array<JSONOBject> $configs
 */
function parseConfigs($dir = '../'){
	$configLines = (file_exists($dir.DCFOLDER.CONFIGFILE)?@file($dir.DCFOLDER.CONFIGFILE):@file(DCFOLDER.CONFIGFILE));
	$configs = array();

	if($configLines!=false){
	foreach($configLines as $configLine){
		if(trim($configLine)!=''){
			$catchedConfig = json_decode(str_replace(array(SECURE_DELIMITER_BEGIN,SECURE_DELIMITER_END),'',$configLine));
			$configs [] = $catchedConfig;
		}
	}
	}
	return $configs;
}

function reductImage($image,$dest,$largeur = 0, $hauteur = 0,$proportions = TRUE){

	$dimensions=getimagesize($image);
	if ($proportions){
		if($dimensions[0]<$dimensions[1]){
			$largeur = ($hauteur / $dimensions[1]) * $dimensions[0] ;
		}else{
			$hauteur = ($largeur / $dimensions[0]) * $dimensions[1] ;
		}
	}
	$pats = pathinfo($image);

	switch (strtolower($pats['extension'])){
		case 'jpg':
			$imageFlux = imagecreatefromjpeg($image);
			break;
		case 'jpeg':
			$imageFlux = imagecreatefromjpeg($image);
			break;
		case 'png':
			$imageFlux = imagecreatefrompng($image);
			break;
		case 'gif':
			$imageFlux = imagecreatefromgif($image);
			break;
		case 'bmp':
			$imageFlux = imagecreatefrombmp($image);
			break;
	}

	$destination = imagecreatetruecolor($largeur, $hauteur);
	imagecopyresampled ($destination,$imageFlux,0,0,0,0,$largeur,$hauteur,$dimensions[0],$dimensions[1] ) ;

	switch (strtolower($pats['extension'])){
		case 'jpg':
			imagejpeg($destination, $dest);
			break;
		case 'jpeg':
			imagejpeg($destination, $dest);
			break;
		case 'png':
			imagepng($destination, $dest);
			break;
		case 'gif':
			imagegif($destination, $dest);
			break;
		case 'bmp':
			imagejpeg($destination, $dest);
			break;

	}
	imagedestroy($imageFlux);

}

/**
 * Retourne l'url de l'image d'avatar correspondant au mail donne en parametre
 * @author Site de Gravatar
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 512 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
function getGravatar( $user, $s = 50, $d = 'mm', $r = 'g') {
	$email =  $user->mail;
	$url = AVATARFOLDER.$user->login.'.jpg';

	if(!file_exists('../'.$url) && !file_exists($url)){

		@copy('http://www.gravatar.com/avatar/'.md5( strtolower( trim( $email ) ) ).".jpg?s=$s&d=$d&r=$r",'../'.$url);
		//@copy(file_get_contents('http://DropCenter.idleman.fr/services/avatar/index.php?code=nobot&key='.strtolower( trim( $email ))),$url);
	}
	return $url;
}

function describeEvent($event,$root){
	
	$user = getUser($event->user);
	$describedEvent['user'] = $user;
	$describedEvent['date'] = $event->date;
	$describedEvent['action'] = $event->action;
	$avatar = $root.'php/action.php?action=openFile&file='.$user->avatar;
	switch($event->action){

		case 'addEventForUpload':
			$describedEvent['title'] = $event->user.' '.tt('a ajoute un ou plusieurs fichiers');
			$files = json_decode(stripslashes(html_entity_decode($event->files)));
			$describedEvent['lien'] = $root.'#'.urlencode(count($files)).'files-added-'.date('d-m-Y-h\hi\ms\s',$event->date);
			$describedEvent['description'] = '<img src="'.$avatar.'" align="absmiddle" border="0" /> <a href="mailto: '.$user->mail.'">'.$event->user.'</a> '.tt('a ajoute % fichier%',array(count($files),(count($files)>1?'s':''))).' : <ul>';
			if(count($files)!=0){
				foreach($files as $file){
					$describedEvent['description'] .='<li><a href="'.$file[1].'">'.$file[0].'</a></li>';
				}
			}

			$describedEvent['description'] .='</ul>  le '.date('d/m/Y \- h:i:s',$event->date);
		break;
		case 'upload':
			$describedEvent['title'] = $event->user.' '.tt('a ajoute un fichier');
			$describedEvent['lien'] = $event->filePath;
			$describedEvent['description'] = '<img src="'.$avatar.'" align="absmiddle" border="0" /> <a href="mailto: '.$user->mail.'">'.$event->user.'</a> '.tt('a ajoute le fichier <a target="_blank" href="%">%</a> le %',array($describedEvent['lien'],$event->file,date('d/m/Y \- h:i:s',$event->date)));
			break;
		case 'deleteFiles':
			
			if($event->type=='folder'){
				$describedEvent['title'] = $event->user.' '.tt('a supprime un dossier');
				$describedEvent['description'] = '<img src="'.$avatar.'" align="absmiddle" border="0" /> <a href="mailto: '.$user->mail.'">'.$event->user.'</a> '.tt('a supprime le dossier % le %',array(str_replace(UPLOAD_FOLDER,'',$event->file),date('d/m/Y \- h:i:s',$event->date)));
				$describedEvent['lien'] = $root.'#'.urlencode($event->file).'-'.date('d-m-Y-h\hi\ms\s',$event->date).'-deleted';
			}else{
				$describedEvent['title'] = $event->user.' '.tt('a supprime un fichier');
				$describedEvent['description'] = '<img src="'.$avatar.'" align="absmiddle" border="0" /> <a href="mailto: '.$user->mail.'">'.$event->user.'</a> '.tt('a supprime le fichier % le %',array(str_replace(UPLOAD_FOLDER,'',$event->file),date('d/m/Y \- h:i:s',$event->date)));
				$describedEvent['lien'] = $root.'#'.(isset($event->filePath)?$event->filePath:'').urlencode($event->file).'-'.date('d-m-Y-h\hi\ms\s',$event->date).'-deleted';
			}

			break;
		case 'renameFile':
			$describedEvent['title'] = $event->user.' '.tt('a renomme un '.($event->type=='folder'?'dossier':'fichier'));
			$describedEvent['lien'] = $root.UPLOAD_FOLDER.urlencode($event->rename);
			$describedEvent['description'] = '<img src="'.$avatar.'" align="absmiddle" border="0" /> <a href="mailto: '.$user->mail.'">'.$event->user.'</a> '.tt('a renomme le '.($event->type=='folder'?'dossier':'fichier').' % en <a target="_blank" href="%">%</a> le %',array(str_replace(UPLOAD_FOLDER,'',$event->file),$describedEvent['lien'],$event->rename,date('d/m/Y \- h:i:s',$event->date)));
			break;
		case 'addUser':
			$describedEvent['title'] = $event->user.' '.tt('a ajoute l\'utilisateur').' '.$event->addedUser;
			$describedEvent['description'] = '<img src="'.$avatar.'" align="absmiddle" border="0" /> <a href="mailto: '.$user->mail.'">'.$event->user.'</a> '.tt('a ajoute l\'utilisateur % le %',array($event->addedUser,date('d/m/Y \- h:i:s',$event->date)));
			$describedEvent['lien'] = $root.'#'.date('d-m-Y-h\hi\ms\s',$event->date).'-'.$event->addedUser.'-added';
			break;
		case 'install':
			$describedEvent['title'] = $event->user.' '.tt('a installe le dropCenter');
			$describedEvent['description'] = '<img src="'.$avatar.'" align="absmiddle" border="0" /> <a href="mailto: '.$user->mail.'">'.$event->user.'</a> '.tt('a installe le dropCenter le %',array(date('d/m/Y \- h:i:s',$event->date)));
			$describedEvent['lien'] = $root.'#-install';
			break;
		case 'deleteUser':
			$describedEvent['title'] = $event->user.' '.tt('a supprime l\'utilisateur').' '.$event->deletedUser;
			$describedEvent['description'] = '<img src="'.$avatar.'" align="absmiddle" border="0" /> <a href="mailto: '.$user->mail.'">'.$event->user.'</a> '.tt('a supprime l\'utilisateur % le %',array($event->deletedUser,date('d/m/Y \- h:i:s',$event->date)));
			$describedEvent['lien'] = $root.'#'.date('d-m-Y-h\hi\ms\s',$event->date).'-'.$event->deletedUser.'-deleted';
			break;
		/*case 'backup':
			$describedEvent['title'] = $event->user.' '.tt('a fait un backup des fichiers');
			$describedEvent['lien'] = $event->filePath;
			$describedEvent['description'] = '<img src="'.$avatar.'" align="absmiddle" border="0" /> <a href="mailto: '.$user->mail.'">'.$event->user.'</a>  '.tt('a fait un backup des fichiers disponible sur <a target="_blank" href="%">%</a> le %',array($describedEvent['lien'],$event->file,date('d/m/Y \- h:i:s',$event->date)));
		break;*/
	}
	return $describedEvent;
}

function chuckQuote($path = null){
	$path = (isset($path)?$path:'../'.DCFOLDER.CHUCKFILE);
	$stream = explode('%',file_get_contents(UPLOAD_FOLDER.$path));
	return utf8_encode($stream[rand(0,count($stream)-1)]);
}




function getSize($file)
{
	$size = filesize($file);
	return convertSize($size);
}

function convertSize($size){

	if ($size < 1024) {
		return ($size==0?'0 ':$size) .' o';
	} elseif ($size < 1048576) {
		return round($size / 1024, 2) .' Ko';
	} elseif ($size < 1073741824) {
		return round($size / 1048576, 2) . ' Mo';
	} elseif ($size < 1099511627776) {
		return round($size / 1073741824, 2) . ' Go';
	} elseif ($size < 1125899906842624) {
		return round($size / 1099511627776, 2) .' To';
	} elseif ($size < 1152921504606846976) {
		return round($size / 1125899906842624, 2) .' Po';
	} elseif ($size < 1180591620717411303424) {
		return round($size / 1152921504606846976, 2) .' Eo';
	} elseif ($size < 1208925819614629174706176) {
		return round($size / 1180591620717411303424, 2) .' Zo';
	} else {
		return round($size / 1208925819614629174706176, 2) .' Yo';
	}
}






function countFiles($folder = UPLOAD_FOLDER){

	$fileInfos = array();
	$files = scanDir($folder);

	foreach($files as $file){
		if($file!='.' && $file!='..'){
			if(is_dir($folder.'/'.$file)){
				$fileInfos = array_merge($fileInfos,countFiles($folder.'/'.$file));

			}else{
				$fileInfos [$folder.$file]['size'] = filesize($folder.'/'.$file);
			}
		}
	}

	return $fileInfos;
}


/**
 * Convertis une cle de traduction en langage traduit
 * @param string $key : cle de traduction
 * @param [OPTIONNAL] array $parameters, parametres dynamiques e inclure dans la traduction (remplace respectivement les signes [%%])
 * @param [OPTIONNAL] string $lang
 * @author Idleman
 * @return String $traduction
 */
function tt($key,$parameters=null,$langage=DC_LANG){

	$user = (isset($_SESSION['user']) && $_SESSION['user']!=null ?@unserialize($_SESSION['user']):null);
	if(isset($user->lang) && isset($user->lang)) $langage =$user->lang;


	$lang = getLang($langage);
	//$return = (isset($lang[$key])?$lang[$key]:"<span style='color:red;font-weight:bold'>TRADUCTION MISS : '$key' for langage '$langage']</span>");
	$return = (isset($lang[utf8_encode($key)])?$lang[utf8_encode($key)]:'<span style=\'color:red;font-weight:bold\'>'.$key.'[::->]</span>');

	if(isset($parameters)){
		$parametersVars = explode('[%%]',$return);
		$return = '';
		$i=0;
		for($o = 0,$e= count($parametersVars);$o<$e;$o++){
			if($o!=0){
				$return .= (isset($parameters[$i])?$parameters[$i]:'').$parametersVars[$o];
				$i++;
			}else{
				$return .= $parametersVars[$o];
			}
		}
	}
	return utf8_decode($return);
}
/**
 * Convertis une cle de traduction en langage traduit
 * @param string $key : cle de traduction
 * @param [OPTIONNAL] array $parameters, parametres dynamiques e inclure dans la traduction (remplace respectivement les signes [%%])
 * @param [OPTIONNAL] string $lang
 * @author Idleman
 * @echo String $traduction
 */
function t($key,$parameters=null,$langage=DC_LANG){

	$user = (isset($_SESSION['user']) && $_SESSION['user']!=null ?unserialize($_SESSION['user']):null);
	if(isset($user->lang) && isset($user->lang))$langage=$user->lang;
	$lang = getLang($langage);
	$return = (isset($lang[utf8_encode($key)])?$lang[utf8_encode($key)]:"<span style='color:red;font-weight:bold'>TRADUCTION MISS : '$key' for langage '$langage']</span>");
	//$return = (isset($lang[$key])?$lang[$key]:'<span style=\'color:red;font-weight:bold\'>'.$key.'[::->]</span>');

	if(isset($parameters)){
		$parametersVars = explode('[%%]',$return);
		$return = '';
		$i=0;
		for($o = 0,$e = count($parametersVars);$o<$e;$o++){
			if($o!=0){
				$return .= (isset($parameters[$i])?$parameters[$i]:'').$parametersVars[$o];
				$i++;
			}else{
				$return .= $parametersVars[$o];
			}
		}
	}
	echo $return;
}

/**
 * Parse le fichiers des langues et retourne les traductions sous forme d'un tableau
 * @param [OPTIONNAL] string $lang
 * @author Idleman
 * @return array<String> $traductions
 */
function getLang($lang=DC_LANG){

	if(!isset($_SESSION['traductions'])){
		$path = (file_exists(LANGFOLDER.$lang)?LANGFOLDER.$lang:'../'.LANGFOLDER.$lang);
		$langLines = file($path,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
		
		$traductions = array();
		foreach($langLines as $langLine){
			if(trim($langLine)!=''){
				list($key,$traduction) = explode('[::->]',$langLine);
				$traductions[$key] = $traduction;
			}
		}
		//TODO, e decommenter en fin de dev  :
		//$_SESSION['traductions'] = serialize($traductions);
	}else{
		$traductions = unserialize($_SESSION['traductions']);
	}

	return $traductions;
}



//Suprime un dossier et tous son contenu
function recursiveDelete($folder){
	$open=@scandir($folder);
	if (!$open) return false;
	foreach($open as $file) {
		if ($file != '.' && $file != '..'){
			if (is_dir($folder."/".$file)) {
				$r=recursiveDelete($folder."/".$file);
				if (!$r) return false;
			}
			else if (is_file($folder."/".$file)){
					
				$r=@unlink($folder."/".$file);
				if (!$r) return false;
			}
		}
	}
	$r=@rmdir($folder);
	if (!$r) return false;
	return true;
}

//Convertit en bytes une chaîne au format texte
//Exemples de chaîne: "2 Mo", "5 Ko", ...
function toBytes($str)
	{
		$val = trim($str);
		$last = strtolower($str[strlen($str)-1]);
		switch($last)
			{
				case 'g': $val *= 1024;
				case 'm': $val *= 1024;
				case 'k': $val *= 1024;
			}
		return $val;
	}

//Récupère la taille maximale d'upload autorisée dans php.ini
function getUploadSize()
	{
		$postSize = ini_get('post_max_size');
		$uploadSize = ini_get('upload_max_filesize');
		return min(toBytes($postSize),toBytes($uploadSize));
	}

/* Constitue un nom lors de la creation des dossiers pour ne pas excraser les existantes (ex :nouveaux dossier (2)) */
function makeName($folder,$name,$number=1){
	$scan = scandir($folder);
	$exist = false;
	foreach($scan as $file){
		if($file==$name.' ('.$number.')') $exist = true;
	}
	if($exist){
		return makeName($folder,$name,$number+1);
	}else{
		return $name.' ('.$number.')';
	}

}

function rssHeader($link){
	return '<rss xmlns:media="http://search.yahoo.com/mrss/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
<channel>
<atom:link href="'.$link.'" rel="self" type="application/rss+xml"/>
<title>'.DC_TITLE.'</title>
<link>
'.$link.'
</link>
<description>'.DC_DESCRIPTION.'</description>
<language>fr-fr</language>
<copyright>'.DC_LICENCE.'</copyright>
<pubDate>'.date('r', gmstrftime(time())) .'</pubDate>
<lastBuildDate>'.date('r', gmstrftime(time())) .'</lastBuildDate>
<generator>'.DC_TITLE.' '.DC_VERSION.' '.DC_NAME.'</generator>';

}
function rssItem($title,$link,$date,$content,$action,$user,$image){
	return '<item>
<title><![CDATA['.html_entity_decode($title,ENT_QUOTES,'UTF-8').']]></title>
<link>'.$link.'</link>
<guid isPermaLink="true">'.$link.'</guid>
<media:hash algo="sha-1">'.sha1($date.$user.$action).'</media:hash>
<media:thumbnail time="'.$date.'" url="'.$image.'"/>
<description>
<![CDATA[
'.$content.'
]]>
</description>
<category>'.$action.'</category>
<dc:creator>'.$user.'</dc:creator>
</item>';

}
function rssFooter(){
	return '</channel></rss>';
}


function unicode2utf8($string){
	return html_entity_decode(preg_replace("/U\+([0-9A-F]{4})/", "&#x\\1;", $string), ENT_NOQUOTES, 'UTF-8');
}
?>