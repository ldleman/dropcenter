<?php
/*
 @nom: action
 @auteur: Valentin CARRUESCO (valentincarruesco@yahoo.fr)
 @date de création: 05/10/2011 à 14:19
 @description: Page executant les actions non liés a une vue (ex:appels ajax,supressions,ajout...)
 */

require_once("header.php");

//Instanciation de l'objet de connexion à la base de données
Mysql::getInstance();

//Execution du code en fonction de l'action
switch ($_['action']){


	case 'example':
		//action
	break;
	

	switch ($_['action']){
	
	case 'login':
		$user = User::exist($_['login'],$_['password']);
		if($user==false){
			exit("erreur identification : le compte est inexistant");
			Logs::put(1,'ERREUR IDENTIFICATION','Compte inexistant --> Login:'.$_['login'].' Mdp:'.$_['password']);
		}else{
			$user->session();
			Logs::put(0,'SUCCES IDENTIFICATION','Login:'.$_['identifiant']);
		}
		header('location: ../pages/index');
	break;

	case 'suscribe':
		$user = new user();
		$user->setName('CARRUESCO');
		$user->setFirstName('Valentin');
		$user->setBirth(strtotime('01/24/1988'));
		$user->setSex('H');
		$user->setLocation('1');
		$user->setPhone('');
		$user->setCellPhone('');
		$user->setMail('idleman@idleman.fr');
		$user->setLogin('idleman');
		$user->setPassword('idleman');
		$user->setCreationDate(time());
		$user->setModificationDate(time());
		$user->setPicture('');
		$user->setState('1');
		$user->setRank('2');
		$user->setDescription('Utilisateur initial');
		$user->setPseudonyme('Idleman');
		$user->setConfiguration('1');
		echo $user->save();
	break;

	case 'logout':
		$_SESSION = array();
		session_unset();
		session_destroy();
		header('location: ../pages/accueil');
	break;
	
	case 'backup':
		require_once('../Libraries/Pclzip.class.php');
		$zipName = '../Backups/'.date('d-m-Y h\hi\ms').'.zip';
		$archive = new PclZip($zipName);
		$v_list = $archive->create('../', PCLZIP_OPT_REMOVE_PATH,'..');
		if ($v_list == 0) {die("Error : ".$archive->errorInfo(true));}
	break;

	default:
		exit('0');
	break;
}


?>