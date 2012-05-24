<?php
/*
 @nom: footer
 @description: Page commune a toute l'application qui affiche le pied du site
 */
require_once('header.php');


$infoFiles = countFiles();

$totalSize = 0;

foreach($infoFiles as $file){
	$totalSize += $file['size'];
}

$tpl->assign('fileNumber', count($infoFiles));
$tpl->assign('totalSize', $totalSize );

//C'est ici qu'on assigne la vue préalablement définie dans les pages incluses par la variable $view
$html = $tpl->draw($view);

?>