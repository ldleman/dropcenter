<?php 
require_once('header.php') ;
 

		$tests = array();
		if (!@function_exists('file_get_contents')){
		 $tests['error'][] = tt('La fonction requise "file_get_contents" est inaccessible sur votre serveur, verifiez votre version de PHP.');
		}else{
		 $tests['succes'][] = tt('La fonction requise "file_get_contents" est accessible sur votre serveur');	
		}
		if (!@function_exists('file_put_contents')){
		 $tests['error'][] = tt('La fonction requise "file_put_contents" est inaccessible sur votre serveur, verifiez votre version de PHP.');
		}else{
		 $tests['succes'][] = tt('La fonction requise "file_put_contents" est accessible sur votre serveur');	
		}
		if (@version_compare(PHP_VERSION, '4.3.0') <= 0){
		 $tests['warning'][] = tt('Votre version de PHP (%) est trop ancienne, il est possible que certaines fonctionalitees du script comportent des disfonctionnements.',array(PHP_VERSION));
		}else{
		 $tests['succes'][] = tt('Votre version de PHP (%) est compatible avec le script',array(PHP_VERSION));	
		}
		if(is_writable('../'.UPLOAD_FOLDER)){
			$tests['error'][] = tt('Le dossier de stockage des donnees "%" est inaccessible en ecriture, verifiez que vous avez bien regle les permissions via un chmod777 sur le dossier.',array(UPLOAD_FOLDER));
		}else{
		 $tests['succes'][] = tt('Le dossier de stockage des donnees "%" est accessible en ecriture',array(UPLOAD_FOLDER));	
		}

	$tpl->assign('tests',$tests);
	$tpl->assign('testsCount',count($tests));
	$tpl->assign('dir',scandir(DIR_LANG));
	$tpl->assign('presumedRoot',str_replace(basename(__FILE__),'','http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']));
	$view = 'install';

require_once('footer.php') 
?>