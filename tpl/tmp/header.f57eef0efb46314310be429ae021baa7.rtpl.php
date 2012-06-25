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
					<li onclick="openView('.panelFolder');" class="sprite menuAddFolder pointer" alt="Nouveau dossier" title="Nouveau dossier"></li>
					<li onclick="openView('.panelSetting');" class="sprite menuSetting pointer" alt="Réglages" title="Réglages"></li>
					<li onclick="openView('.panelAbout');" class="sprite menuUsers pointer" alt="A propos" title="A propos"></li>
					<div class="clear"></div>
				</ul>
			</nav>
			<section class="loginBloc">
				<figure><img class="sprite avatarDefault"></figure>
				<nav>
					<?php if( isset($user) ){ ?>
					<div class="left">Idleman</div><div class="sprite arrowDown left"></div>
					<ul>
						<li>Preferences</li>
						<li>D&eacute;connexion</li>
					</ul>
					<?php }else{ ?>
					<form action="php/action.php?action=login" method="POST">
						<input required placeholder="<?php echo t('Login'); ?>" type="text" name="login">
						<input required type="password" placeholder="<?php echo t('Password'); ?>" name="password">
						<button type="submit">Connexion</button>
					</form>
					<?php } ?>

				</nav>

			</section>
		</header>

		