<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>


<ul class="fileList">

	<li>
		<figure><img src="./tpl/AzuraStrike/./img/ext/pdf.png"></figure>
		<h1>Fichier 1</h1>
		<section class="fileInfos">
			<div class="fileSize">208 ko</div>
			<div class="fileDate">27/12/2012 16:11</div>
		</section>
		<nav>
			<ul>
				<li><figure class="sprite optionMail"></figure></li>
				<li><figure class="sprite optionEdit"></figure></li>
				<li><figure class="sprite optionDownload"></figure></li>
				<li><figure class="sprite optionUrl"></figure></li>
			</ul>
		</nav>
		<div class="clear"></div>
	</li>

</ul>
		


<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>
