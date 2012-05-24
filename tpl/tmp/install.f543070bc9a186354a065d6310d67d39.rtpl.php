<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>


		<!--*******************************-->
		<!-- [ADMINISTRATION] INSTALLATION -->
		<!--*******************************-->

<form action="php/action.php?action=addUser" method="POST">
	<section id="initProgram">
		<h1>
		<?php echo t("Installation du programme"); ?>
		</h1>
		<p>
		<?php echo t("Aucun administrateur n'est defini, merci de remplir les informations ci dessous."); ?>
		</p>
		<section>
			<ul>

				<?php if( !isset($tests['error']) ){ ?>
				<li><figure class="avatar">
						<img src="./tpl/UnderBlack/./img/<?php echo $AVATAR_DEFAULT;?>" />
					</figure></li>
				<li><span><?php echo t("Login"); ?>: <input  placeholder="<?php echo t("Login"); ?>"required type="text"
						name="login" /> </span></li>
				<li><span><?php echo t("Password"); ?>: <input placeholder="<?php echo t("Password"); ?>" required type="password"
						name="password" /><input type="hidden" name="rank" value="admin" />
				</span></li>
				<li><span><?php echo t("Mail"); ?>: <input placeholder="<?php echo t("Mail"); ?>" pattern="[^ @]*@[^ @]*" required
						type="email" name="mail" /> </span></li>
				<li><span> <?php echo t("Racine du programme"); ?>: <input pattern="https?://.+"
						required type="url"
						value="<?php echo $presumedRoot;?>"
						name="root" /> </span></li>
				<li><input type="submit" value="<?php echo t("Creer"); ?>"></li>
				<?php } ?>

				<?php if( $testsCount!=0 ){ ?>
					<?php $counter1=-1; if( isset($tests) && is_array($tests) && sizeof($tests) ) foreach( $tests as $key1 => $value1 ){ $counter1++; ?>
						

						<li><?php echo $key1;?> : <ul>
						<?php $counter2=-1; if( isset($value1) && is_array($value1) && sizeof($value1) ) foreach( $value1 as $key2 => $value2 ){ $counter2++; ?>
						<li class="requireBloc <?php echo $key2;?>"><span><?php echo $value2;?></span></li>

					<?php } ?>
					</ul></li><?php } ?>
				<?php } ?>

			</ul>
		</section>
	</section>
</form>
	
<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>