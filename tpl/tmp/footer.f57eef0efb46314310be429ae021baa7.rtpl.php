<?php if(!class_exists('raintpl')){exit;}?>
<footer class="footer"><blockquote><?php if( $FORTUNE ){ ?><?php echo chuckQuote(); ?><?php } ?></blockquote> 
	<div><?php echo t("Flux RSS"); ?></div>
	<a href="php/action.php?action=rss" target="_blank" title="<?php echo t("Abonnez vous au flux rss pour suivre les evenements du DropCenter"); ?>"><figure class="sprite menuRss"></figure></a>
	</footer>

<script type="text/javascript" src="./tpl/AzuraStrike/./js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="./tpl/AzuraStrike/./js/jquery.filedrop.min.js"></script>
<script type="text/javascript" src="./tpl/AzuraStrike/./js/jquery.poshytip.min.js"></script>
<script type="text/javascript" src="./tpl/AzuraStrike/./js/jquery-ui.min.js"></script>
<script type="text/javascript" src="./tpl/AzuraStrike/./js/main.js"></script>
<script type="text/javascript" src="./tpl/AzuraStrike/./js/tinypop.min.js"></script>
<span id="scriptRoot" class="hidden"><?php echo getConfig('ROOT'); ?> </span>
<?php if( isset($user) && $user->rank=='admin' && $DISPLAY_UPDATE ){ ?>
<script type="text/javascript" src="http://dropCenter.fr/wp-content/maj/maj.php"></script>
<?php } ?>

<?php if( isset($error) ){ ?>
			<script type="text/javascript">  TINYPOP.show("<?php echo $error;?>", {position: 'top-right',timeout: 3000,sticky: false});</script>
<?php } ?>


	
</body>
</html>


