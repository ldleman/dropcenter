<?php 

require_once('header.php') ;

	
	
	$tpl->assign('userList',parseUsers('./'));
	$tpl->assign('dir',scandir(DIR_LANG));
	$view = 'index';
	


require_once('footer.php') 
?>