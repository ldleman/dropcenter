<?php 

require_once('header.php') ;

	$view = 'index';

	$tpl->assign('userList',parseUsers('./'));
	$tpl->assign('dir',scandir(DIR_LANG));



require_once('footer.php') 
?>