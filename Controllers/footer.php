<?php

require_once('header.php');

//Assignation du contenu de debug a la variable de template DEBUG
$tpl->assign("DEBUG",$debug->get());


$html = $tpl->draw($view);



?>