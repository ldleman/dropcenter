<?php if(!class_exists('raintpl')){exit;}?>
		<!--***************-->
		<!-- [TOUS] FOOTER -->
		<!--***************-->

<footer>
<?php echo t( "CopyrightFooter", array(DC_TITLE,DC_VERSION,DC_NAME,DC_WEBSITE,DC_LICENCE) ); ?>

 	<?php echo t('% fichiers disponibles pour un poids total de %',array($fileNumber,convertSize($totalSize))); ?>
	</span>

	<?php if( isset($user) ){ ?> 
		<?php echo t(' - Taille maximale par fichier : %.',array (convertSize(getUploadSize()))); ?>
	<?php } ?>


	<br/><br/>
	<?php if( $FORTUNE ){ ?><?php echo chuckQuote(); ?><br/><br/><?php } ?>
	<a class="rssFeed tooltips" target="_blank"
		href="php/action.php?action=rss" alt="&lt;?php t("Flux RSS");?&gt;"
		title="<?php echo t("Abonnez vous au flux rss pour suivre les evenements du DropCenter"); ?>"><figure></figure><?php echo t("Flux RSS"); ?>
	</a>
</footer>


		<!--*******************-->
		<!-- [TOUS] JAVASCRIPT -->
		<!--*******************-->

<script type="text/javascript" src="./tpl/UnderBlack/./js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="./tpl/UnderBlack/./js/jquery.filedrop.min.js"></script>
<script type="text/javascript" src="./tpl/UnderBlack/./js/jquery.poshytip.min.js"></script>
<script type="text/javascript" src="./tpl/UnderBlack/./js/jquery-ui.min.js"></script>
<script type="text/javascript" src="./tpl/UnderBlack/./js/main.js"></script>
<script type="text/javascript" src="./tpl/UnderBlack/./js/tinypop.min.js"></script>
<span id="scriptRoot" class="hidden"><?php echo getConfig('ROOT'); ?> </span>
<?php if( isset($user) && $user->rank=='admin' && $DISPLAY_UPDATE ){ ?>
<script type="text/javascript" src="http://dropCenter.fr/wp-content/maj/maj.php"></script>
<?php } ?>

<?php if( isset($_GET['error']) ){ ?>
			<script type="text/javascript">  TINYPOP.show("&lt;?php echo $_GET['error'] ?&gt;", {position: 'top-right',timeout: 3000,sticky: false});</script>
<?php } ?>

</body>
</html>