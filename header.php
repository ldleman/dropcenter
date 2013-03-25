<?php
session_start();
header( 'content-type: text/html; charset=utf-8' );
require_once('php/rain.tpl.class.php');
require_once('php/config.php');
require_once('php/function.php');

//Instanciation du template
$tpl = new RainTPL();

//Definition des dossiers de template
raintpl::configure("base_url", null );
raintpl::configure("tpl_dir", './tpl/'.DEFAULT_THEME.'/' );
raintpl::configure("cache_dir", "./tpl/tmp/" );

$user = null;

$tpl->assign('DC_TITLE',DC_TITLE);//Titre du dropCenter
$tpl->assign('DC_DESCRIPTION',DC_DESCRIPTION);//description du dropCenter
$tpl->assign('DC_LOGO',DC_LOGO);//logo central du dropCenter (Si rien n'est mis, le logo par défaut apparaît)
$tpl->assign('DC_LICENCE',DC_LICENCE);//License de votre dropCenter
$tpl->assign('UPLOAD_FOLDER',UPLOAD_FOLDER);//chemin vers le dossier d'upload (ne pas oublier de mettre les droits d'écriture sur ce dossier)
$tpl->assign('NAME_LIMIT',NAME_LIMIT);//Nombre maximal de caractères affichés pour les fichiers
$tpl->assign('NAME_LIMIT_BORDER',NAME_LIMIT_BORDER);//Les caractères qui s'afficheront pour signifier qu'un nom est raccourci
$tpl->assign('MAX_SIZE',MAX_SIZE);//Taille maximale authorisée par fichier en Mo (Pensez a configurer post_max_size et upload_max_size dans le fichier php.ini de votre serveur si vous voulez uploader de gros fichiers).
$tpl->assign('FORBIDEN_FORMAT',FORBIDEN_FORMAT);//Les extensions interdites à l'exécution séparées par des virgules (les fichiers seront bien envoyés mais un .txt sera rajouté à l'extension afin d'empêcher les utilisateurs d'exécuter leurs fichiers sur le serveur
$tpl->assign('AVATAR_DEFAULT',AVATAR_DEFAULT); //chemin de l'avatar par défaut
$tpl->assign('AVATARFOLDER',AVATARFOLDER); //dossier contenant les avatars
$tpl->assign('FORTUNE',FORTUNE);//Affiche une citation aléatoire Chuck Norris Facts (mettre à false pour ne pas afficher)
$tpl->assign('RSS_MAIL',RSS_MAIL);
$tpl->assign('READ_FOR_ANONYMOUS',READ_FOR_ANONYMOUS);// Définit si les visiteurs non authentifiés peuvent lire le contenu du dropCenter (true = lecture possible, false = lecture interdite)
$tpl->assign('DC_LANG',DC_LANG);//Définit la langue par défaut
$tpl->assign('DIR_LANG',DIR_LANG);//Dossier des fichiers de langue
$tpl->assign('MAIL',MAIL);//Autorise les notifications par e-mail
$tpl->assign('DISPLAY_DOTFILES',DISPLAY_DOTFILES);//Affiche ou non les dossiers/fichiers commençant par un point
$tpl->assign('DISPLAY_UPDATE',DISPLAY_UPDATE);//Activer la vérification des mises-à-jour
$tpl->assign('DISPLAY_AVATAR_FOLDER',DISPLAY_AVATAR_FOLDER);//Afficher le dossier des avatars

$tpl->assign('DCFOLDER',DCFOLDER); //fichier contenant les données d'évènements
$tpl->assign('LANGFOLDER',LANGFOLDER); //dossier contenant les fichiers données de traductions
$tpl->assign('EVENTFILE',EVENTFILE); //fichier contenant les données d'évènements
$tpl->assign('USERFILE',USERFILE); //fichier contenant les données utilisateurs
$tpl->assign('CONFIGFILE',CONFIGFILE); //fichier contenant les données utilisateurs
$tpl->assign('TAGSFILE',TAGSFILE); //fichier contenant les tags des fichiers envoyés
$tpl->assign('CHUCKFILE',CHUCKFILE);//Nom du fichier fortune contenant les citations de Chuck Norris

$tpl->assign('SECURE_DELIMITER_BEGIN',SECURE_DELIMITER_BEGIN); //
$tpl->assign('SECURE_DELIMITER_END',SECURE_DELIMITER_END); //
$tpl->assign('DC_VERSION',DC_VERSION); //Version du programme
$tpl->assign('DC_NAME',DC_NAME);//Nom du programme
$tpl->assign('DC_VERSION_NUMBER',DC_VERSION_NUMBER);//Nom du programme
$tpl->assign('DC_WEBSITE',DC_WEBSITE);//Site du programme

if(file_exists('./'.DCFOLDER.USERFILE)){
		$user = (isset($_SESSION['user']) && trim($_SESSION['user'])!='' && $_SESSION['user']!=null ?@unserialize($_SESSION['user']):null);
		$user = ($user?$user:null);
		$tpl->assign('user',$user);
		$_ = getLang();
}else{
	if(strpos($_SERVER['PHP_SELF'], 'install.php')===false){
	header('location: install.php');
	}
}
?>