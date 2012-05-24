<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>



		<div id="dropbox">
		
		<!--***************************-->
		<!-- [PUBLIQUE] IDENTIFICATION -->
		<!--***************************-->

		<div class="loginBloc">
		<?php if( !isset($user) || $user==null ){ ?>
		<form action="php/action.php?action=login" method="POST">
			&lt;?php t("Login");?&gt; : <input required type="text" placeholder="&lt;?php t("Login");?&gt;" type="text" name="login">
			&lt;?php t("Password");?&gt; : <input required type="password" placeholder="&lt;?php t("Password");?&gt;" type="password" name="password">
			<input type="submit" name="Connect">
		</form>
		<?php }else{ ?>
			<figure class="avatar"><img src="./tpl/UnderBlack/'.$user->avatar.'"/></figure><section class="textLogin">'.tt("Connecte en tant que %",array($user->login)).' - <a href="php/action.php?action=logout">'.tt("Deconnexion").'</a></section>
		<?php } ?>
		</div>

		

		<!--***********************************-->
		<!-- [ADMINISTRATION/UTILISATEUR] MENU -->
		<!--***********************************-->

	<?php if( isset($user) && $user->rank=='admin' ){ ?>
<div class="menuBloc">
	<a onclick="$('.folderNameBloc').fadeToggle(200);" class="newFolder tooltips"
		title="&lt;?php t("Nouveau dossier")?&gt;"></a> <a
		onclick="$('#paramsBloc').fadeToggle()" class="preferences tooltips"
		title="&lt;?php t("Parametres") ?&gt;"></a> <a
		onclick="$('#usersBloc').fadeToggle()" class="member tooltips"
		title="&lt;?php t("Comptes")?&gt;"></a> <a
		href="php/action.php?action=backup" class="backup tooltips"
		title="&lt;?php t("Sauvegarde");?&gt;"></a>

		<div class="folderNameBloc"><input name="folderName" placeholder="&lt;?php t('Nom du dossier'); ?&gt;" class="blackControl" type="text"/><button class="blackControl pointer" onclick="addFolder();">Ok</button></div>
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
<span class="message">&lt;?php t("Droppez le fichier ici pour l'uploader. <br /><i>(Enfin tout depend de votre navigateur)</i>");?&gt;
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
