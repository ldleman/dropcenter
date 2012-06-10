<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<title></title>
	<link href="./tpl/AzuraStrike/./favicon.ico" rel="shortcut icon" type="image/x-icon" />
	<link rel="stylesheet" href="./tpl/AzuraStrike/./css/styles.css" />
	<link rel="alternate" type="application/rss+xml"href="./tpl/AzuraStrike/./php/action.php?action=rss" title="" />

</head>
	<body onbeforeunload ="checkPendingTask();">
		
		<header class="header">
			<a href="index.php"><figure class="sprite logo"></figure></a>
			<nav class="mainMenu">
				<ul>
					<li class="sprite menuAddFolder pointer" alt="Nouveau dossier" title="Nouveau dossier"></li>
					<li class="sprite menuSetting pointer" alt="Réglages" title="Réglages"></li>
					<li class="sprite menuUsers pointer" alt="A propos" title="A propos"></li>
					<div class="clear"></div>
				</ul>
			</nav>
			<section class="loginBloc">
				<figure><img class="sprite avatarDefault"></figure>
				<nav>
					<div class="left">Idleman</div><div class="sprite arrowDown left"></div>
					<ul>
						<li>Preferences</li>
						<li>D&eacute;connexion</li>
					</ul>

				</nav>

			</section>
		</header>

		