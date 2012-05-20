<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>


<section class="blocError">
<figure><?php echo $ERROR_CODE;?></figure><h1><?php echo $ERROR_TITLE;?></h1>
<p>Explication de l'erreur : <?php echo $ERROR_DETAIL;?></p>

<?php if( $ERROR_CODE =='404' ){ ?>
<h2>Recherche de suggestions</h2>
<input type="text" name="search" value="<?php echo $SUGGESTION404;?>">
<div onclick="search()" class="buttonErrorSearch"><figure></figure><h1>Recherche</h1></div>
<?php } ?>
<div class="clear"></div>

</section>
<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>