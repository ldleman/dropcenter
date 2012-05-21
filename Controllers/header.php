<?php session_start();
require_once('../Configurations/configuration.php');
function __autoload($class){
	if(file_exists("../Classes/".$class.".class.php")){
		require_once("../Classes/".$class.".class.php");
	}
}
require_once('../Libraries/RainTpl.class.php');

//Calage de la date
date_default_timezone_set(DC_TIMEZONE); 

//Instanciation du template
$tpl = new RainTPL();

//Definition des dossiers de template
raintpl::configure("base_url", null );
raintpl::configure("tpl_dir", '../Views/'.TPL_NAME.'/' );
raintpl::configure("cache_dir", "../Views/Temporary/" );


//Récuperation des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1); 


//Instanciation de l'objet representant l'utilisateur courant
if(isset($_SESSION['User'])){
	$currentUser = unserialize($_SESSION['User']);
}else{
	$visitorRank = Rank::load(array('label'),array('Visiteur'));
	$currentUser = new User();
	$currentUser->setLastip(Functions::getIP());
	$currentUser->setRankId($visitorRank->getId());
	$currentUser->setName("Anonyme");
	$currentUser->session();
}
$tpl->assign('currentUser',$currentUser);



//Récuperation et sécurisation de toutes les variables POST et GET
$_ = array();
foreach($_POST as $key=>$val){
$_[$key]=Functions::secure($val);
}
foreach($_GET as $key=>$val){
$_[$key]=Functions::secure($val);
}

//Assignation des constantes globales au template
$tpl->assign('DC_TITLE',DC_TITLE);
$tpl->assign('DC_LOCATION',DC_LOCATION);
$tpl->assign('DC_CATEGORY',DC_CATEGORY);
$tpl->assign('DC_DESCRIPTION',DC_DESCRIPTION);
$tpl->assign('DC_KEYWORDS',DC_KEYWORDS);
$tpl->assign('DC_COPYRIGHT',DC_COPYRIGHT);
$tpl->assign('DC_AUTHOR',DC_AUTHOR);
$tpl->assign('DC_IDE',DC_IDE);
$tpl->assign('DC_LANGAGE',DC_LANGAGE);
$tpl->assign('DC_URL',DC_URL);
$tpl->assign('DC_LICENCE',DC_LICENCE);

//Assignation des chemins d'inclusion au template
$tpl->assign('STYLESHEET_PATH',STYLESHEET_PATH);
$tpl->assign('JAVASCRIPT_PATH',JAVASCRIPT_PATH);
?>