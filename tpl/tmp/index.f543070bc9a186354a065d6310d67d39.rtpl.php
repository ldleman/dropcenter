<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>



		<div id="dropbox">
		
		<!--***************************-->
		<!-- [PUBLIQUE] IDENTIFICATION -->
		<!--***************************-->

		<div class="loginBloc">
		<?php if( !isset($user) || $user==null ){ ?>
		<form action="php/action.php?action=login" method="POST">
			<?php echo t('Login'); ?> : <input required type="text" placeholder="<?php echo t('Login'); ?>" type="text" name="login">
			<?php echo t('Password'); ?> : <input required type="password" placeholder="<?php echo t('Password'); ?>" type="password" name="password">
			<input type="submit" name="Connect">
		</form>
		<?php }else{ ?>
			<figure class="avatar"><img src="./tpl/UnderBlack/'.$user->avatar.'"/></figure><section class="textLogin"><?php echo tt("Connecte en tant que %",array($user->login)); ?> - <a href="php/action.php?action=logout"><?php echo tt("Deconnexion"); ?></a></section>
		<?php } ?>
		</div>

		

		<!--***********************************-->
		<!-- [ADMINISTRATION/UTILISATEUR] MENU -->
		<!--***********************************-->

	<?php if( isset($user) && $user->rank=='admin' ){ ?>
<div class="menuBloc">
	<a onclick="$('.folderNameBloc').fadeToggle(200);" class="newFolder tooltips"
		title="<?php echo t("Nouveau dossier"); ?>"></a> <a
		onclick="$('#paramsBloc').fadeToggle()" class="preferences tooltips"
		title="<?php echo t("Parametres") ; ?>"></a> <a
		onclick="$('#usersBloc').fadeToggle()" class="member tooltips"
		title="<?php echo t("Comptes"); ?>"></a> <a
		href="php/action.php?action=backup" class="backup tooltips"
		title="<?php echo t("Sauvegarde"); ?>"></a>

		<div class="folderNameBloc"><input name="folderName" placeholder="{function="t('Nom du dossier')}" class="blackControl" type="text"/><button class="blackControl pointer" onclick="addFolder();">Ok</button></div>
</div>

	<?php } ?>
<div class="clear"></div>

		<!--**********************-->
		<!-- [TOUS] FIL D'ARIANNE -->
		<!--**********************-->

<ul class="breadcrumb"></ul>
<div class="clear"></div>

		<!--*********************-->
		<!-- [TOUS] ZONE DE DROP -->
		<!--*********************-->
<?php if( isset($user) ){ ?>
<div class="fileBloc">
<span class="message"><?php echo t("Droppez le fichier ici pour l'uploader. <br /><i>(Enfin tout depend de votre navigateur)</i>"); ?>
</span>
<div class="urlFile">
	<input name="urlFile" type="text" value="http://"><button>Copier l'url</button><br/>
	<div class="fileInput"><input id="fileInputText" type="text"><button id="fileInputButton"></button><input id="fileInputFile" name="localFile" type="file"></div>
</div>
<div class="clear"></div>
</div>
<?php } ?>

</div>
	

			

			</ul>
		</section>
	</section>
</form>
		


<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>
