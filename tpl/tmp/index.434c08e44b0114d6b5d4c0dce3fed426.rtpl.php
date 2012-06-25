<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>

<!--***************************-->
<!-- [UTILISATEUR] PREFERENCES -->
<!--***************************-->



<div class="panelAbout">

Programme : Drop Center<br/>
Version : V2<br/>
Distribution : BETA<br/>
Auteurs :   -Valentin CARRUESCO aka Idleman (contact@dropcenter.fr	-	http://blog.idleman.fr)<br/>
			-Paul R aka Fox http://fox-photography.net63.net/me-contacter<br/>


Plugins : -Jquery (www.jquery.com)<br/>
		  -Phpjs (www.phpjs.org)<br/>
		  -PclZip (www.phpconcept.net/pclzip/)<br/>
		  -RainTPL (www.raintpl.com)<br/>
		  
Icones : Faenza Icons par tiheum (http://tiheum.deviantart.com/art/Faenza-Icons-173323228)<br/>
</div>


<div class="panelFolder">
<input name="folderName" placeholder="<?php echo t('Nom du dossier'); ?>" class="blackControl" type="text"/><button class="blackControl pointer" onclick="addFolder();">Ok</button>
</div>

<?php if( isset($user) ){ ?>
<div class="panelSetting">
	<form action="php/action.php?action=saveSettings&user=<?php if( isset($user) ){ ?>$user->login<?php } ?>" method="POST">

	<h1><?php echo t('Parametres'); ?></h1>	
	<h2><?php echo t('Profil'); ?></h2>
	<ul>
		<li><span><?php echo t('Password'); ?> : </span><input placeholder="<?php echo t('Password'); ?>" type="password" name="password"></li>
		<li><span><?php echo t('Mail'); ?> : </span><input required pattern="[^ @]*@[^ @]*" placeholder="<?php echo t('Mail'); ?>" value="<?php echo $user->mail;?>" type="text" name="mail"></li>
		<li><span><?php echo t('Avatar'); ?> : </span><input placeholder="<?php echo t('Avatar'); ?>" value="<?php echo $user->avatar;?>" type="text" name="avatar"></li>
	</ul>
	<h2><?php echo t('Preferences'); ?></h2>
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
							  	<?php $counter1=-1; if( isset($dir) && is_array($dir) && sizeof($dir) ) foreach( $dir as $key1 => $value1 ){ $counter1++; ?>
							  		
							  		<?php if( is_file($DIR_LANG.''.$value1) ){ ?>
										<?php if( strpos($DIR_LANG.''.$value1, '.')===false ){ ?>
							  				<option <?php if( $user->lang==$value1 ){ ?>selected="selected"<?php } ?>><?php echo utf8_encode($value1); ?></option>
							  			<?php } ?>
							  		<?php } ?>
							  	<?php } ?>
							  	?&gt;
							 </select>
							</li>
						</ul>
						<input type="submit" value="<?php echo t("Valider"); ?>">
	</form>
</div>
<?php } ?>

<div class="uploadBloc">
	<div class="dropZone">Droppez vos fichiers ou cliquez ici</div>
	<div class="urlZone">
		<h1>ou depuis une url</h1>
		<input type="text" placeholder="http://site.com/image-url.jpg" name="urlUpload"><button>Ok</button>
	</div>
	<div class="clear"></div>
</div>

<ul class="fileList">
</ul>
		


<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>
