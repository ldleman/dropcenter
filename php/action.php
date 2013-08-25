<?php
session_start();

require_once('config.php');
require_once('function.php');


mb_internal_encoding("UTF-8" );
mb_http_output("UTF-8" );
mb_http_input("UTF-8" );
 
iconv_set_encoding("internal_encoding", "UTF-8" );
iconv_set_encoding("output_encoding", "UTF-8" );
iconv_set_encoding("input_encoding", "UTF-8" );
 
header('Content-Type: text/html; charset=utf-8');

$user = (isset($_SESSION['user']) && $_SESSION['user']!=null ?@unserialize($_SESSION['user']):null);
$user = ($user?$user:null);
$event = array();
$event['date'] = time();
$javascript =  array();
$javascript['succes'] = false;

$_ = array();
foreach($_POST as $key=>$val){
	$_[$key]=htmlentities($val);
}
foreach($_GET as $key=>$val){
	$_[$key]=htmlentities($val);
}

if(isset($_['action'])){

	$event['action']=$_['action'];

	switch($_['action']){

		case 'addUser':
			if(file_exists('../'.DCFOLDER.USERFILE)){
				if(isset($user) && $user->rank=='admin'){

					if(isset($_['login']) && isset($_['password'])){
					//Vérifie que l'utilisateur n'existe pas déja
					
					if(!existLogin($_['login'])){
						$addedUser = array();
						$addedUser['login'] = $_['login'];
						$addedUser['avatar'] = (isset($_['avatar'])?$_['avatar']:'');
						$addedUser['password'] = $_['password'];
						$addedUser['rank'] = $_['rank'];
						$addedUser['mail'] = $_['mail'];
						$addedUser['notifMail'] = "off";
						$addedUser['lang'] = DC_LANG;
						addUser($addedUser);
						$event['user']=$user->login;
						$event['result'] = true;
						$event['addedUser'] = $_['login'];
						addEvent($event);	
					}
					$error = '?openUserPanel=true';
					}else{
						$error = '?error='.tt('Champs obligatoires non remplis');
					}

					header('location: ../index.php'.$error);
				}
			}else{
				
				$addedUser = array();
				$addedUser['login'] = $_['login'];
				$addedUser['avatar'] = (isset($_['avatar'])?$_['avatar']:'');
				$addedUser['password'] = $_['password'];
				$addedUser['rank'] = $_['rank'];
				$addedUser['mail'] = $_['mail'];
				$addedUser['notifMail'] = "off";
				$addedUser['lang'] = DC_LANG;
				addUser($addedUser);

				addConfig('ROOT',(isset($_['root'])?$_['root']:''));
				
				$event['user']=$_['login'];
				$event['result'] = true;
				$event['addedUser'] = $_['login'];
				$event['action']= 'install';
				addEvent($event);
				header('location: ./action.php?action=login&login='.$_['login'].'&password='.$_['password']);
			}

			break;

		case 'openFile':
			

			$file = stripslashes(utf8_decode(html_entity_decode($_['file'])));
			$file ='../'.UPLOAD_FOLDER.str_replace(array('../'.UPLOAD_FOLDER,UPLOAD_FOLDER),'',$file);

			if(
				(READ_FOR_ANONYMOUS || (isset($user) && ($user->rank=='admin' || $user->rank=='user')))
				|| (isPublished($_['file']))

				){

				
				header('Content-Description: File Transfer');
	    		header('Content-Type: application/octet-stream');
	    		header('Content-Disposition: attachment; filename='.str_replace(' ','-',basename($file)));
	    		header('Content-Transfer-Encoding: binary');
	    		header('Expires: 0');
	   	 		header('Cache-Control: must-revalidate');
	    		header('Pragma: public');
	    		//header('Content-Length: ' . $file);
	    		ob_clean();
	    		flush();
				readfile($file);
				exit();
			}else{
				exit('Fichier priv&eacute;, acc&egrave;s interdit');
			}
		break;


		case 'publishFile':
		if(isset($user) && ($user->rank=='admin' || $user->rank=='user')){
					
				$file = stripslashes(utf8_decode(html_entity_decode("../".$_['file'])));

				addPublish($file);
				$javascript['succes'] = true;
				$javascript['status'] =  'Fichier rendu public';
				
				
			}else{
				$javascript['status'] = tt('Vous n\'avez pas les droits pour publier ce fichier');
			}
		break;

		case 'unpublishFile':
		if(isset($user) && ($user->rank=='admin' || $user->rank=='user')){
					
				$file = stripslashes(utf8_decode(html_entity_decode("../".$_['file'])));

				deletePublish($file);
				$javascript['succes'] = true;
				$javascript['status'] =  'Fichier rendu privé';
				
				
			}else{
				$javascript['status'] = tt('Vous n\'avez pas les droits pour publier ce fichier');
			}
		break;

		case 'getFiles':
			if(READ_FOR_ANONYMOUS || (isset($user) && ($user->rank=='admin' || $user->rank=='user'))){
				
				if(isset($_['folder'])){		
					$_['folder'] = html_entity_decode($_['folder']);
					$requiredFolder = $_['folder'].'/';
				}else{
					$requiredFolder = '../'.UPLOAD_FOLDER;
				}
				
				if($requiredFolder =='//CURRENT/'){
					$requiredFolder =$_SESSION['currentFolder'];
				}else{

					$_SESSION['currentFolder'] = $requiredFolder;
				}

				$scan = scanFolder($requiredFolder,(isset($_['keywords'])?$_['keywords']:null));

				if(count($scan)==0){
					$javascript['status'] = tt('aucun fichier');
				}else{
					$javascript['succes'] = true;
					$javascript['currentFolder'] = $requiredFolder;
					$javascript['status'] = $scan;
				}
			}
		break;
		
		case 'saveSettings':
		if(isset($user) && ($user->rank=='admin' || ($user->rank=='user' && $user->login==$_['user']) )){
			if(file_exists('../'.DCFOLDER.USERFILE)){
				$_['notifMail'] = (isset($_['notifMail'])?'true':'false');
				$values = array(
						'password'=>$_['password'],
						'mail'=>$_['mail'],
						'avatar'=>$_['avatar'],
						'notifMail'=>$_['notifMail'],
						'lang'=>$_['lang']
					);
				updateUser($_['user'], $values);
				$javascript['succes'] = true;
				header('location: ../index.php');	
			}	
		}
		break;



		
		case 'zipFile':
			if(isset($user) && $user->rank=='admin'){
				require_once('zip.class.php');
				
				
				$tempDir = '../'.DCFOLDER.'temp/';
				if(!file_exists($tempDir)) mkdir($tempDir);
				$filesTemp = scandir($tempDir);
				foreach($filesTemp as $file){
					if(is_file($tempDir.$file))unlink($tempDir.$file);
				}
				
				$file = stripslashes(utf8_decode(html_entity_decode("../".$_['file'])));
				$zipName = $tempDir.'.dropFile-'.date('d-m-Y h\hi\ms').'.zip';
				$archive = new PclZip($zipName);
				$v_list = $archive->create($file, PCLZIP_OPT_REMOVE_PATH,'..\\'.DCFOLDER);
				if ($v_list != 0){
					$javascript['succes'] = true;

					$javascript['status'] =  str_replace('../','','./php/action.php?action=openFile&file='.$zipName);
				}else{
					$javascript['status'] = tt('Impossible de zipper le fichier, nom incorrect ou fichier inexistant :').$archive->errorInfo(true);
				}
			}else{
				$javascript['status'] = tt('Vous n\'avez pas les droits pour zipper ce fichier');
			}
			break;	
			
		
		case 'moveFile':
			if(isset($user)){
				$file = stripslashes(utf8_decode(html_entity_decode($_['fileUrl'])));
				$fileName = stripslashes(utf8_decode(html_entity_decode($_['fileName'])));
				$folder = utf8_decode(html_entity_decode($_['folder']));
				if(is_dir($folder)){
					if(is_file('../'.$file)){
						if(@rename('../'.$file,$folder.'/'.$fileName)){

							deletePublish('../'.$file);
							addPublish($folder.'/'.$fileName);

							$javascript['succes'] = true;

							$javascript['status'] = tt('Fichier correctement deplace');
						}else{
							$javascript['status'] = tt('Impossible de deplacer le fichier');
						}
					}else{
					$javascript['status'] = tt('Impossible de deplacer le fichier, fichier incorrect ou inexistant');
					}
				}else{
					$javascript['status'] = tt('Impossible de d&eacute;placer le fichier, dossier incorrect ou inexistant');
				}
			}else{
				$javascript['status'] = tt('Vous n\'avez pas les droits pour deplacer ce fichier');
			}
		break;

		case 'deleteFiles':
			if(isset($user) && $user->rank=='admin'){
			$file = stripslashes(utf8_decode(html_entity_decode($_['file'])));
				
				if(is_file('../'.$file)){
				if(unlink('../'.$file)){
				$event['user']=$user->login;
				$event['result'] = true;
				$event['file'] = $_['file'];
				$event['type'] = 'file';
				deletePublish('../'.$file);
				addEvent($event);
				$javascript['succes'] = true;
				$javascript['status'] = tt('Fichier correctement supprime');
				}else{
					$javascript['status'] = tt('Impossible de supprimer le fichier, nom incorrect ou fichier inexistant');
				}
				}else if(is_dir($file)){
				
					if(recursiveDelete($file)){
					$event['user']=$user->login;
					$event['result'] = true;
					$event['file'] = $_['file'];
					$event['type'] = 'folder';
					addEvent($event);
					$javascript['succes'] = true;
					$javascript['status'] = tt('Dossier correctement supprime');
					}else{
						$javascript['status'] = tt('Impossible de supprimer le dossier, nom incorrect ou dossier inexistant');
					}
				}
			}else{
				$javascript['status'] = tt('Vous n\'avez pas les droits pour supprimer ce fichier');
			}
			
			break;

		case 'deleteUser':
			if(isset($user) && $user->rank=='admin'){
				deleteUser($_['user']);
				$event['user']=$user->login;
				$event['result'] = true;
				$event['deletedUser'] = $_['user'];
				addEvent($event);
				if($_['user']==$user->login){
					header('location: ./action.php?action=logout');
				}else{
					header('location: ../index.php');
				}
			}
			break;


		case 'backup':
			if(isset($user) && $user->rank=='admin'){
				require_once('zip.class.php');
				$zipName = '../'.UPLOAD_FOLDER.'dropFiles-'.date('d-m-Y-H\hi').'.zip';
				$archive = new PclZip($zipName);

				$v_list = $archive->create('../'.UPLOAD_FOLDER, PCLZIP_OPT_REMOVE_PATH,'..');
				if ($v_list == 0) {die("Error : ".$archive->errorInfo(true));}


				$_SESSION['backup']= file_get_contents($zipName);
				$fileSize = filesize($zipName);
				unlink($zipName);

				header('Content-Description: File Transfer');
	    		header('Content-Type: application/octet-stream');
	    		header('Content-Disposition: attachment; filename='.basename($zipName));
	    		header('Content-Transfer-Encoding: binary');
	    		header('Expires: 0');
	   	 		header('Cache-Control: must-revalidate');
	    		header('Pragma: public');
	    		header('Content-Length: ' . $fileSize);
	    		ob_clean();
	    		flush();
	    		echo $_SESSION['backup'];


				$javascript = null;
			}
			//header('location: ../index.php');
			break;
		
		case 'login':
			if(isset($_['token'])){
				$user = existToken($_['token']);
				$_SESSION['user'] = (!$user?null:serialize($user));
				if(!$user){
					header('location: ../index.php?error=Mauvais identifiant ou mot de passe');
				}else{
					header('location: ../php/action.php?action=rss');
				}
				
			}else{
				$user = exist($_['login'],$_['password']);
				$_SESSION['user'] = (!$user?null:serialize($user));
				header('location: ../index.php'.(!$user?'?error=Mauvais identifiant ou mot de passe':''));
			}
			
		break;

		case 'logout':
			$_SESSION = array();
			session_unset();
			session_destroy();
			header('location: ../index.php');
			break;

		case 'renameFile':
			if(isset($user) && ($user->rank=='admin' || $user->rank=='user')){
			
				$file = stripslashes(utf8_decode(html_entity_decode($_['file'])));
				$newPath = substr($file,0,strrpos ($file,'/')+1);
				$newFileName = stripslashes(utf8_decode(html_entity_decode($_['newName'])));

				$forbidenFormats = explode(',',FORBIDEN_FORMAT);
				if(in_array(get_extension($_['newName']),$forbidenFormats)) $newFileName .='.txt';


				if(!file_exists($newPath.$newFileName)){
				if(is_file('../'.$file)){
				if(@rename('../'.$file,'../'.$newPath.$newFileName)){
					$event['user']=$user->login;
					$event['result'] = true;
					$event['file'] = $file;
					$event['type'] = 'file';
					$event['rename'] = $_['newName'];
					addEvent($event);
					$javascript['succes'] = true;
				}else{
					$javascript['status'] = tt('Impossible de renommer le fichier, nom incorrect ou fichier inexistant');
				}
				}else{
					if(@rename($file,$newPath.$newFileName)){
					$event['user']=$user->login;
					$event['result'] = true;
					$event['file'] = $file;
					$event['type'] = 'folder';
					$event['rename'] = $_['newName'];
					addEvent($event);
					$javascript['succes'] = true;
					}else{
						$javascript['status'] = tt('Impossible de renommer le dossier, nom incorrect ou dossier inexistant');
					}
				}
				
				}else{
					$javascript['status'] = tt('Impossible de renommer l element % en %, l element % existe deja',array($file,$newFileName,$newFileName));
					
				}
				
			}else{
				$javascript['status'] = tt('Vous n\'avez pas les droits pour renommer ce fichier');
			}
			break;

		case 'checkVersion':				
				echo DC_VERSION_NUMBER;
				$javascript = null;
		break;
			
		case 'rss':
			if(READ_FOR_ANONYMOUS || (isset($user) && ($user->rank=='admin' || $user->rank=='user'))){
				header('Content-Type: text/xml; charset=utf-8');
				echo  rssHeader('http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?action=rss');
				$allEvents = array_reverse(parseEvents());
				$root = getConfig('ROOT');
				if(isset($allEvents) && count($allEvents)!=0){
					foreach($allEvents as $event){
						$event = describeEvent($event,$root);
						$user = $event['user'];
						echo rssItem($event['title'],$event['lien'],$event['date'],$event['description'],$event['action'],$user->login,$root.$user->avatar);
					}
				}
				echo rssFooter();
				$javascript = null;
			}
		break;

		case 'addFolder':
		if(isset($user) && ($user->rank=='admin' || $user->rank=='user')){
			$_['name'] = stripslashes(utf8_decode(html_entity_decode($_['name'])));

			if(isset($_['name']) && trim($_['name'])!=''  && !file_exists($_SESSION['currentFolder'].'/'.$_['name'])){
				$tempName = utf8_decode($_SESSION['currentFolder']).'/'.$_['name'];
			}else{
				$tempName = makeName(utf8_decode($_SESSION['currentFolder']),str_replace(array("\r","\n"),'',tt('Nouveau dossier (%)')));
			}
			
			if(!in_array(trim($_['name']),array('/','\\',':','?','"','<','>'))){
				if(mkdir($tempName)){
					@chmod( utf8_decode($_SESSION['currentFolder']).$tempName , 0755);
					
					$javascript['succes'] = true;
					$javascript['tempName'] = $tempName;
					$javascript['tempNameUrl'] = utf8_decode($_SESSION['currentFolder']).$tempName;
				}else{
					$javascript['status'] = tt('Erreur, impossible de cr&eacute;er le dossier');
				}
			}else{
				$javascript['status'] = 'Erreur, un nom de fichier/dossier ne peux contenir les caractères suivants : /,\,:,?,",<,>';
			}



			}else{
				$javascript['status'] = tt('Vous ne pouvez rien envoyer car vous n\'avez aucun droits d\'ajout sur le dropCenter');
			}
		break;
		
		case 'addEventForUpload':
			if(isset($user) && ($user->rank=='admin' || $user->rank=='user')){
				$event['user']=$user->login;
				$event['result'] = true;
				$event['files'] = $_['files'];
				addEvent($event);
				
				$user = getUser($event['user']);

				if (MAIL){
					$files = json_decode(stripslashes(html_entity_decode($event['files'])));
					
					foreach(parseUsers('../') as $userInfos){
						if($userInfos->notifMail=="true"){
							$mailmembre = $userInfos->mail;
							$messageMail ='';
							$messageMail .='<img src="'.getConfig('ROOT').AVATARFOLDER.$user->login . '.jpg'.'" align="absmiddle" border="0" />&nbsp;<a href="mailto: '.$user->mail.'">'.$event['user'].'</a> '.tt('a ajoute % fichier%',array(count($files),(count($files)>1?'s':''))).' : <ul>';
							foreach($files as $file){
								$messageMail .='<li><a href="'.$file[1].'">'.$file[0].'</a></li>';
							}
							$messageMail .= '</ul>';
							@mail ($mailmembre . ',', 'DropCenter: '.mb_encode_mimeheader(tt('Ajout d\'un ou plusieurs fichiers par').' '.$event['user']), $messageMail.'<br/>'.tt('Ceci est un message automatique du').' '.'<a href="'.getConfig('ROOT').'">Dropcenter</a>, '.tt('ne pas repondre').'.','Content-type: text/html; charset=UTF-8');
						}
					}
				}
				$javascript['succes'] = true;
			}else{
				$javascript['status'] = tt('Vous ne pouvez rien notifier car vous n\'avez aucun droits d\'ajout sur le dropCenter');
			}

		break;

		case 'upload':
			if(isset($user) && ($user->rank=='admin' || $user->rank=='user')){

				if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
					$javascript['status'] = tt('Erreur, mauvaise m&eacute;thode http');
				}

				if(array_key_exists('files',$_FILES) && $_FILES['files']['error'][0] == 0 ){
					$pic = $_FILES['files'];
					$pic['name'] = utf8_decode($pic['name'][0]);
					$pic['tmp_name'] = $pic['tmp_name'][0];
					$forbidenFormats = explode(',',FORBIDEN_FORMAT);
					$pic['name'] = stripslashes($pic['name']);
					if(in_array(get_extension($pic['name']),$forbidenFormats)){
						$pic['name'] = $pic['name'].'.txt';
					}
					$size = filesize($pic['tmp_name']);
					if($size<=(MAX_SIZE*1048576)){
						
						$destination = (isset($_SESSION['currentFolder'])?utf8_decode($_SESSION['currentFolder']):'../'.UPLOAD_FOLDER).$pic['name'];
						
						if(move_uploaded_file($pic['tmp_name'], $destination)){
		
							$javascript['status'] = tt('Fichier envoy&eacute; avec succ&egrave;s!');
							$javascript['extension'] = get_extension($pic['name']);
							$javascript['succes'] = true;
							$javascript['filePath'] = getConfig('ROOT').str_replace('../','',$destination);
							$javascript['file'] = $pic['name'];
							
						}
					}else{
						$javascript['status'] = tt('Taille maximale : %Mo d&eacute;pass&eacute;e',array(MAX_SIZE));
					}
				}else{
				$javascript['status'] = tt('Probl&egrave;me rencontr&eacute; lors de l\'upload');
				}
			}else{
				$javascript['status'] = tt('Vous ne pouvez rien envoyer car vous n\'avez aucun droits d\'ajout sur le dropCenter');
			}
			break;
	}
}
echo (isset($javascript)?json_encode($javascript):'');

?>
