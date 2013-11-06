<?php

date_default_timezone_set('Europe/Paris');
require_once '../php/function.php';
require_once 'vendor/autoload.php';
$rootDirectory = new \Sabre\DAV\FS\Directory('../uploads');
$server = new \Sabre\DAV\Server($rootDirectory);
$server->setBaseUri('/dropcenter/dav/');
$lockBackend = new \Sabre\DAV\Locks\Backend\File('data/locks');
$lockPlugin = new \Sabre\DAV\Locks\Plugin($lockBackend);
$server->addPlugin($lockPlugin);
$auth = new \Sabre\HTTP\BasicAuth();
$result = $auth->getUserPass();
//if ($result!=false && exist($result[0],$result[1])) {
    $server->exec();
//}else{
//	$auth->requireLogin();
  //  echo "Authentication required\n";
  //  die();
//}

/*
date_default_timezone_set('Europe/Paris');
require_once '../php/function.php';
require_once 'vendor/autoload.php';
$rootDirectory = new \Sabre\DAV\FS\Directory('../uploads');
$server = new \Sabre\DAV\Server($rootDirectory);
$server->setBaseUri('/dropcenter/dav/');
$lockBackend = new \Sabre\DAV\Locks\Backend\File('data/locks');
$lockPlugin = new \Sabre\DAV\Locks\Plugin($lockBackend);
$server->addPlugin($lockPlugin);
$auth = new \Sabre\HTTP\BasicAuth();
$result = $auth->getUserPass();
if ($result!=false && exist($result[0],$result[1])) {
    $server->exec();
}else{
	$auth->requireLogin();
    echo "Authentication required\n";
    die();
}
*/

?>