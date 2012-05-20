<?php 
/*
	@nom: doAction
	@auteur: Valentin CARRUESCO (valentincarruesco@yahoo.fr)
	@date de cr&eacute;ation: 05/10/2011 &agrave; 14:19
	@description: Page executant les actions non li&eacute;s a une vue (ex:appels ajax,supressions,ajout...)
*/
require_once('header.php');

$type = htmlentities(mysql_escape_string($_['type']));
$suggestion  ='Aucune suggestions';

$typeLog = '1';

switch($type){
/***************************/
/** ERREURS PERSONALISEES **/
/***************************/
case '001': 	$title='Connexion impossible!!'; $detail = 'Votre identifiant ou votre mot de passe est incorrect, <a href="../pages/membres">Veuillez vous identifier de nouveaux</a>.' ; break;

/******************/
/** ERREURS HTTP **/
/******************/

case '400': 	$title='Erreur, mauvaise requ&ecirc;te!!'; $detail = 'La syntaxe de la requ&ecirc;te est erron&eacute;e' ; break;
case '401': 	$typeLog = '3'; $title='Erreur, acc&egrave;s interdit!!'; $detail = 'Une authentification est n&eacute;cessaire pour acc&eacute;der &agrave; la ressource' ; break;
case '402': 	$typeLog = '3'; $title='Erreur, paiement obligatoire!!'; $detail = 'Paiement requis pour acc&eacute;der &agrave; la ressource (non utilis&eacute;)' ; break;
case '403': 	$typeLog = '3'; $title='Erreur, acc&egrave;s interdit!!'; $detail = 'L’authentification est refus&eacute;e.' ; break;
case '404': 	


$suggestion = str_replace('.php','',str_replace('/',' ',$_SERVER['REQUEST_URI']));
$title='Erreur, page introuvable!!';
$detail = 'Document non trouv&eacute;';
break;
 
case '405': 	$typeLog = '3'; $title='Erreur, m&eacute;thode non allou&eacute;e!!'; $detail = 'M&eacute;thode de requ&ecirc;te non autoris&eacute;e' ; break;
case '406': 	$title='Erreur, non acceptable!!'; $detail = 'Toutes les r&eacute;ponses possibles seront refus&eacute;es.' ; break;
case '407': 	$typeLog = '3'; $title='Erreur, identification proxy requise!!'; $detail = 'Acc&egrave;s &agrave; la ressource autoris&eacute; par identification avec le proxy' ; break;
case '408': 	$title='Erreur, temps maximum d&eacute;pass&eacute;!!'; $detail = 'Temps d’attente d’une r&eacute;ponse du serveur &eacute;coul&eacute;' ; break;
case '409': 	$typeLog = '2'; $title='Erreur, conflit!!'; $detail = 'La requ&ecirc;te ne peut &ecirc;tre trait&eacute;e &agrave; l’&eacute;tat actuel' ; break;
case '410': 	$typeLog = '2'; $title='Erreur, partie!!'; $detail = 'La ressource est indisponible et aucune adresse de redirection n’est connue' ; break;
case '411': 	$title='Erreur, taille requise!!'; $detail = 'La longueur de la requ&ecirc;te n’a pas &eacute;t&eacute; pr&eacute;cis&eacute;e' ; break;
case '412': 	$title='Erreur, pr&eacute;-condition &eacute;chou&eacute;e!!'; $detail = 'Pr&eacute;conditions envoy&eacute;es par la requ&ecirc;te non-v&eacute;rifi&eacute;es' ; break;
case '413': 	$typeLog = '3'; $title='Erreur, requ&ecirc;te trop grosse!!'; $detail = 'Traitement abandonn&eacute; dû &agrave; une requ&ecirc;te trop importante' ; break;
case '414': 	$title='Erreur, URI trop longue!!'; $detail = 'URI trop longue' ; break;
case '415': 	$typeLog = '3'; $title='Erreur, format non support&eacute;!!'; $detail = 'Format de requ&ecirc;te non-support&eacute;e pour une m&eacute;thode et une ressource donn&eacute;es' ; break;
case '416': 	$title='Erreur, range incorrect!!'; 	$detail = 'Champs d’en-t&ecirc;te de requ&ecirc;te « range » incorrect.' ; break;
case '417': 	$typeLog = '3'; $title='Erreur, comportement insatisfaisable!!'; $detail = 'Comportement attendu et d&eacute;fini dans l’en-t&ecirc;te de la requ&ecirc;te insatisfaisable' ; break;
case '418': 	$title='Erreur, I’m a teapot!!'; $detail = 'Ce code est d&eacute;fini dans la RFC 2324 dat&eacute;e du premier avril, Hyper Text Coffee Pot Control Protocol. Il n’y a pas d’impl&eacute;mentation de ce code.' ; break;
case '422': 	$title='Erreur, entit&eacute; incompr&eacute;hensible!!'; $detail = 'WebDAV : L’entit&eacute; fournie avec la requ&ecirc;te est incompr&eacute;hensible ou incompl&egrave;te.' ; break;
case '423': 	$title='Erreur v&eacute;rouill&eacute;!!'; $detail = 'WebDAV : L’op&eacute;ration ne peut avoir lieu car la ressource est verrouill&eacute;e.' ; break;
case '424': 	$title='Erreur, methode &eacute;chou&eacute;e !!'; $detail = 'WebDAV : Une m&eacute;thode de la transaction &agrave; &eacute;chou&eacute;.' ; break;
case '425': 	$title='Erreur, Unordered Collection!!'; $detail = 'WebDAV (RFC 3648). Ce code est d&eacute;fini dans le brouillon WebDAV Advanced Collections Protocol, mais est absent de Web Distributed Authoring and Versioning (WebDAV) Ordered Collections Protocol' ; break;
case '426': 	$title='Erreur, mise &agrave; jour requise!!'; $detail = '(RFC 2817) Le client devrait changer de protocole, par exemple au profit de TLS/1.0' ; break;
case '449': 	$title='Erreur, r&eacute;esayez!!'; $detail = 'La requ&ecirc;te devrait &ecirc;tre renvoy&eacute;e apr&egrave;s avoir effectu&eacute; une action.' ; break;
case '450 ':	$title='Erreur, contr&ocirc;l parental!!'; $detail = 'Bloqu&eacute; par le contr&ocirc;le parental de windows' ; break;
case '500 ':	$typeLog = '2';$title='Erreur, crash serveur!!'; $detail = 'Le serveur ne parvient pas a executer correctement la section, merci de contacter un administrateur' ; break;
	default:
	exit('0');
	break;
}

$tpl->assign('ERROR_CODE',$type);
$tpl->assign('ERROR_TITLE',$title);
$tpl->assign('ERROR_DETAIL',$detail);
$tpl->assign('SUGGESTION404',$suggestion);

$userAgent = "";
$userLangage = "";
$charset = "";
if(isset($_SERVER['HTTP_USER_AGENT']))$userAgent = $_SERVER['HTTP_USER_AGENT'];
if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))$userLangage = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
if(isset($_SERVER['HTTP_ACCEPT_CHARSET']))$charset = $_SERVER['HTTP_ACCEPT_CHARSET'];

//Journal::put($typeLog,'ERREUR_HTTP ('.$type.'): '.$title,$detail.'[:]'.$userAgent.'[:]'.$userLangage.'[:]'.$charset);


$view = 'error';

require_once('footer.php');
?>
