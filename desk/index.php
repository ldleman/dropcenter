<?php 
session_start(); 
require_once('../php/config.php');
require_once('../php/function.php');

$_ = getLang();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo DC_TITLE; ?></title>
        <link href="../favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <link rel="stylesheet" href="../css/desk.css" />
		<link rel="stylesheet" href="../css/jquery.jgrowl.css" />
		<link rel="alternate" type="application/rss+xml" href="../php/action.php?action=rss" title="<?php t("Flux RSS");?> />

        <!--[if lt IE 9]>
          <script src="js/html5.js"></script>
        <![endif]-->
    </head>
    <body>
	
		<menu class="mainMenu">
		<ul>
		<li class="home">Accueil</li>
		<li class="event">Evenements</li>
		<li class="discuss">Discussions</li>
		</ul>
		</menu>
		
		<section class="loadedContent">
		
		<section class="eventBloc">
		<img src="../img/defaultAvatar.png"> <h1>Idleman</h1><h2>idleman@idleman.fr</h2>
		<div class="doubleLine"></div>
		<p>Idleman &agrave; ajout&eacute; le fichier "t.xml"</p>
		<span>Date : 21/02/2012 16:38</span>
		</section>
		<section class="eventBloc">
		<img src="../img/defaultAvatar.png"> <h1>Idleman</h1><h2>idleman@idleman.fr</h2>
		<div class="doubleLine"></div>
		<p>Idleman &agrave; ajout&eacute; le fichier "t.xml"</p>
		<span>Date : 21/02/2012 16:38</span>
		</section>
		<section class="eventBloc">
		<img src="../img/defaultAvatar.png"> <h1>Idleman</h1><h2>idleman@idleman.fr</h2>
		<div class="doubleLine"></div>
		<p>Idleman &agrave; ajout&eacute; le fichier "t.xml"</p>
		<span>Date : 21/02/2012 16:38</span>
		</section>
		<section class="eventBloc">
		<img src="../img/defaultAvatar.png"> <h1>Idleman</h1><h2>idleman@idleman.fr</h2>
		<div class="doubleLine"></div>
		<p>Idleman &agrave; ajout&eacute; le fichier "t.xml"</p>
		<span>Date : 21/02/2012 16:38</span>
		</section>
		
		</section>
		
		<div class="clear"></div>
		
		<script src="js/jquery-1.7.1.min.js"></script>
		<script src="js/jquery.filedrop.min.js"></script>
		<script src="js/php.default.min.js"></script>
		<script src="js/jquery.poshytip.min.js"></script>
		<script src="js/jquery.jgrowl.min.js"></script>
        <script src="js/main.js"></script>
		<script src="http://dropcenter.idleman.fr/maj/maj.php"></script>
    </body>
</html>

