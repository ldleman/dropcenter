<style>
table tr td{
	padding:5px;
	border:1px solid #cecece;
	font-family:Verdana;
	font-size:11px;
}
</style>



<?php $currentLang = (isset($_GET['edit'])?$_GET['edit']:false); ?>

<form action="#" method="POST">
<table cellspadding="0" cellspacing="0" style="width:100%;">
	<tr style="background-color:#000000;color:#ffffff;" >
		<td colspan="2">Langue: <input type="text" value="<?php echo $currentLang; ?>" name="lang"> , Charger une langue existante : <select name="langSelection" onchange="if(this.value!='')window.location='LangGenerator.php?edit='+this.value;">
	<option value=""></option>
<?php 



$langFiles = scandir(dirname(__FILE__));
foreach($langFiles as $file){
	if(is_file($file) && strpos($file, '.')===false){
		?><option value="<?php echo $file; ?>"><?php echo $file; ?></option><?php
	}
}
?>
</select></td>

	</tr>

<?php
$template = file((!$currentLang?'fr - Francais':$currentLang));
$refTab = array(); 
$refNum = 0;
foreach($template as $line){
	list($key,$value) = explode('[::->]',$line);
		$refTab[$refNum] = $key ; 
	?>
	<tr <?php echo( $refNum %2!=0?'style="background-color:#dedede;"':'') ?> ><td><?php echo $key; ?></td><td style="width:50%;"><input style="width:100%;" type="text" name="key<?php echo $refNum ?>" <?php

	 if($currentLang!=false){
	 	echo ' value="'.str_replace('"','&quot;',utf8_encode($value)).'" ';
	 	} 

	 ?> placeholder="<?php echo str_replace('"','&quot;',utf8_encode($value)); ?>"/></td></tr><?php
	$refNum++;
}
?>
<tr style="background-color:#000000;color:#ffffff;" ><td colspan ="2" ><input type="submit" name="Generer" value="G&eacute;nerer"></td></tr>
</table>

</form>


<form action="#" method="POST">
Langue: <input type="text" value="<?php echo $currentLang; ?>" name="lang"> <br><br>
<textarea name="all">
<?php
foreach($template as $line){
	list($key,$value) = explode('[::->]',$line);
	echo $value;
}
?>
</textarea>
<input type="submit" name="Generer2" value="G&eacute;nerer">
</form>

<?php
	if(isset($_POST['Generer'])){
		foreach($_POST as $key=>$value){
			if(substr($key, 0,3)=="key"){
				$key = substr($key, 3);
				$lines[] = $refTab[$key].'[::->]'.$value;
			}
		}
		file_put_contents($_POST['lang'], implode("\n",$lines));
	}


	if(isset($_POST['Generer2'])){

		$allLines = explode("\n",$_POST['all']);

		foreach($allLines as $key=>$value){
			
				$lines[] = $refTab[$key].'[::->]'.$value;
			
		}
		
		file_put_contents($_POST['lang'], implode("\n",$lines));
	}


?>


