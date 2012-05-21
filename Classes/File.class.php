<?php

/*
	@nom: File
	@auteur: Idleman
	@description: Classe de gestion des fichiers
*/

class File
{
	public static function get($fileUrl){
		return file_get_contents($fileUrl);
	}

	public static function put($fileUrl,$data){
		return file_put_contents($fileUrl, $data,FILE_APPEND);
	}
}
?>
