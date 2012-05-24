<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>



		<div id="dropbox">
		
		<!--*********************************************-->
		<!-- [ADMINISTRATION] CREATION D'UN UTILISATEURS -->
		<!--*********************************************-->

		<section id="usersBloc" <?php if( isset($_GET['openUserPanel']) ){ ?> style="display:block;"<?php } ?>>
		<form action="php/action.php?action=addUser" method="POST">
		<h1><?php echo t("Liste des utilisateurs"); ?></h1>
		<h2 onclick="$('#userCreateBloc').fadeToggle()">(+ <?php echo t("Ajouter un utilisateur"); ?>)</h2>
		&lt;?php 
		<?php if( isset($user) && $user->rank=='admin' ){ ?>
			<?php echo $userList = parseUsers('./');?>
		<?php } ?>
		<ul>
		<li id="userCreateBloc" <?php if( isset($_GET['openUserPanel']) ){ ?>style="display:block;"<?php } ?>>
			<ul>
				<li><figure class="avatar"><img src="./tpl/UnderBlack/img/<?php echo $AVATAR_DEFAULT;?>"/></figure></li>
				<li><span><?php echo t('Login'); ?>: <input required type="text" placeholder="<?php echo t("Login"); ?>" type="text" name="login"/></span></li>
				<li><span><?php echo t("Password"); ?>: <input required type="password" placeholder="<?php echo t('Password'); ?>" type="password" name="password"/></span></li>
				<li><span><?php echo t("Rang"); ?>: <select name="rank"><option value="user"><?php echo t('Utilisateur'); ?></option><option value="admin"><?php echo t('Administrateur'); ?></option></select></span></li>
				<li><span><<?php echo t('Mail'); ?>: <input required pattern="[^ @]*@[^ @]*" placeholder="<?php echo t("Mail"); ?>" type="text" name="mail"/></span></li>
				<li><input type="submit" value="Ajouter"></li>
			</ul>
		</li>

		<!--*****************************************-->
		<!-- [ADMINISTRATION] LISTE DES UTILISATEURS -->
		<!--*****************************************-->

		<?php $counter1=-1; if( isset($userList) && is_array($userList) && sizeof($userList) ) foreach( $userList as $key1 => $value1 ){ $counter1++; ?>
		
		<li>
			<ul>
				<li><figure class="avatar" id="avatar"><img src="./tpl/UnderBlack/<?php echo $value1->avatar;?>"/></figure></li>
				<li><span><?php echo t('Login'); ?>: <?php echo $value1->login;?></span></li>
				<li><span><?php echo t('Rang'); ?>: <?php echo $value1->rank;?></span></li>
				<li><span> <a href="mailto: <?php echo $value1->mail;?>"><?php echo $value1->mail;?></a></span></li>
				<!-- <li><a onclick="editUser('<?php echo $value1->login;?>');">Modifier</a></li> -->
				<li><a onclick="deleteUser('<?php echo t('Etes-vous sur de vouloir supprimer cet utilisateur?'); ?>','<?php echo $value1->login;?>');" ><?php echo t('Supprimer'); ?></a></li>
			</ul>
		</li>
		<?php } ?>
		
		</ul>
	
		</form>
		</section>

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

		<!--***************************-->
		<!-- [UTILISATEUR] PREFERENCES -->
		<!--***************************-->
		
		<form action="php/action.php?action=saveSettings&user=<?php if( isset($user) ){ ?>$user->login<?php } ?>" method="POST">
		<section id="paramsBloc">
				<h1><?php echo t('Parametres'); ?></h1>	
				<ul>
					<li><?php echo t('Profil'); ?>
						<ul>
							<li><span><?php echo t('Password'); ?> : </span><input placeholder="<?php echo t('Password'); ?>" type="password" name="password"></li>
							<li><span><?php echo t('Mail'); ?> : </span><input required pattern="[^ @]*@[^ @]*" placeholder="<?php echo t('Mail'); ?>" value="<?php echo $user->mail;?>" type="text" name="mail"></li>
							<li><span><?php echo t('Avatar'); ?> : </span><input placeholder="<?php echo t('Avatar'); ?>" value="<?php echo $user->avatar;?>" type="text" name="avatar"></li>
						</ul>
					</li>
					<li><?php echo t('Preferences'); ?>
						<ul>
							<li>
								<span><?php echo t('Notification par mail ?'); ?> :</span>
								<input type="checkbox" name="notifMail"
									<?php if( $user->notifMail == 'true' ){ ?> 
									checked
									<?php } ?>
								> 

								<?php if( $user->notifMail=='true' ){ ?> 
									<?php echo t('On'); ?> 
								<?php }else{ ?> 
									<?php echo t('Off'); ?> 
								<?php } ?>
							</li>
							<li><span><?php echo t('Langue'); ?> :</span>


							<select name="lang">
							  	&lt;?php 
							  	$dir = scandir(DIR_LANG);
							  	foreach ($dir as $file){
							  		
							  		if(is_file(DIR_LANG.$file) && strpos(DIR_LANG.$file, '.')===false){
							  			echo '<option '.($user->lang==$file ? 'selected="selected"':'').'>'.utf8_encode($file).'</option>';
							  		}
							  	}  
							  	?&gt;
							 </select>
							</li>
						</ul>
					</li>
					<li>
						<input type="submit" value="{function="t("Valider");?&gt;">
					</li>
				</ul>
		
		</section>
			</form>



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
