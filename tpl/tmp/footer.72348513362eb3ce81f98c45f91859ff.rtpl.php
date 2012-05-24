<?php if(!class_exists('raintpl')){exit;}?>
		<!--***************-->
		<!-- [TOUS] FOOTER -->
		<!--***************-->

<footer>
<?php echo t( "CopyrightFooter", array(DC_TITLE,DC_VERSION,DC_NAME,DC_WEBSITE,DC_LICENCE) ); ?>

&lt;?php 

$infoFiles = countFiles();
$fileNumber = count($infoFiles);
$totalSize = 0;

foreach($infoFiles as $file){
	$totalSize += $file['size'];
}
 t('% fichiers disponibles pour un poids total de %',array($fileNumber,convertSize($totalSize))); ?&gt;
	</span>&lt;?php if(isset($user)){t(' - Taille maximale par fichier : %.',array (convertSize(getUploadSize())));} ?&gt;<br/><br/>
	&lt;?php echo (FORTUNE?chuckQuote().'<br/><br/>':'') ?&gt;
	<a class="rssFeed tooltips" target="_blank"
		href="php/action.php?action=rss" alt="&lt;?php t("Flux RSS");?&gt;"
		title="&lt;?php t("Abonnez vous au flux rss pour suivre les evenements du DropCenter");?&gt;"><figure></figure>&lt;?php t("Flux RSS");?&gt;
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
<span id="scriptRoot" class="hidden">&lt;?php echo getConfig('ROOT'); ?&gt; </span>
&lt;?php if(isset($user) && $user->rank=='admin' && DISPLAY_UPDATE){ ?&gt;
<script type="text/javascript" src="http://dropCenter.fr/wp-content/maj/maj.php"></script>
&lt;?php } ?&gt;

&lt;?php if(isset($_GET['error'])){ ?&gt;
			<script type="text/javascript">  TINYPOP.show("&lt;?php echo $_GET['error'] ?&gt;", {position: 'top-right',timeout: 3000,sticky: false});</script>
&lt;?php } ?&gt;

</body>
</html>