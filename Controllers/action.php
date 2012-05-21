<?php
/*
 @nom: action
 @auteur: Idleman
 @description: Page executant les actions non liés a une vue (ex:appels ajax,supressions,ajout...)
 */

require_once("header.php");


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
		}else{
			$user->session();
		}
		header('location: ../pages/index');
	break;

	case 'logout':
		$_SESSION = array();
		session_unset();
		session_destroy();
		header('location: ../pages/accueil');
	break;
	

	default:
		exit('0');
	break;
}


?>