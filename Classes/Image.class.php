<?php

/*
 @nom: Image
 @auteur: Valentin CARRUESCO (valentin.carruesco@sys1.fr)
 @date de création: 07/10/2011 à 21:10
 @description: Fournis de nombreux outils pour la gestion des images
 */

class Image
{

	private $image,$infos,$imageFlux,$inf;


	function __construct($image=false)
	{
		if($image!=false){
			$this->image = $image ;
		}
	}

	function ouvrir($image){
		$this->image = $image ;
		$this->inf= $this->infos();


		switch (strtolower($this->inf[2])){
			case 'jpg':
				$this->imageFlux = imagecreatefromjpeg($this->image);
				break;
			case 'jpeg':
				$this->imageFlux = imagecreatefromjpeg($this->image);
				break;
			case 'png':
				$this->imageFlux = imagecreatefrompng($this->image);
				break;
			case 'gif':
				$this->imageFlux = imagecreatefromgif($this->image);
				break;
			case 'txt':
				$this->imageFlux = imagecreatefromstring($this->image);
				break;
			case 'bmp':
				$this->imageFlux = imagecreatefrombmp($this->image);
				break;
			case 'gif':
				$this->imageFlux = imagecreatefromgif($this->image);
				break;
			default:
				exit("ERREUR: format de l'image non supporté. Formats supportés : jpg, jpeg, png, bmp, gif, txt.");
				break;
		}
	}

	function enregistrer($chemin='./',$nom=false,$ecraser=false){

		if (!$nom){ $nom= $this->image; }
		$num='';
		if (!$ecraser){

			$dir = opendir($chemin);
			while($f = @readdir($dir)) {

				if(is_file($chemin.$f)){

					if($chemin.$f==$chemin.$nom){
						$num='('.time().')';
					}
				}

			}
			closedir($dir);}
			$dest = $chemin.$num.$nom ;

			switch (strtolower($this->inf[2])){
				case 'jpg':
					imagejpeg($this->imageFlux, $dest);
					break;
				case 'jpeg':
					imagejpeg($this->imageFlux, $dest);
					break;
				case 'png':
					imagepng($this->imageFlux, $dest);
					break;
				case 'gif':
					imagegif($this->imageFlux, $dest);
					break;
				case 'bmp':
					imagejpeg($this->imageFlux, $dest);
					break;

			}
			imagedestroy($this->imageFlux);
			return $dest;
	}

	function tourner($angle,$back=0){
		imagerotate ($this->imageFlux  , $angle  ,$back  );
	}

	function reduire($largeur = 0, $hauteur = 0,$proportions = TRUE){
		if ($proportions){
			if($this->inf[0]<$this->inf[1]){
				$largeur = ($hauteur / $this->inf[1]) * $this->inf[0] ;
			}else{
				$hauteur = ($largeur / $this->inf[0]) * $this->inf[1] ;
			}
		}
		$destination = imagecreatetruecolor($largeur, $hauteur);
		imagecopyresampled ($destination,$this->imageFlux,0,0,0,0,$largeur,$hauteur,$this->inf[0],$this->inf[1] ) ;
		$this->imageFlux=$destination;
	}

	function desaturer(){
		imagefilter($this->imageFlux, IMG_FILTER_GRAYSCALE);
	}

	function teindre($hex){

		if(! ereg("[0-9a-fA-F]{6}", $hex)) {
			echo "Error : input is not a valid hexadecimal number";
			return 0;
		}

		for($i=0; $i<3; $i++) {
			$temp = substr($hex, 2*$i, 2);
			$rgb[$i] = 16 * hexdec(substr($temp, 0, 1)) +
			hexdec(substr($temp, 1, 1));
		}

		imagefilter($this->imageFlux, IMG_FILTER_COLORIZE,$rgb[0],$rgb[2],$rgb[1]);

	}

	function flouter($taux=1){
		imagefilter($this->imageFlux,IMG_FILTER_GAUSSIAN_BLUR);

		for ($i=0;$i<$taux;$i++){
			imagefilter($this->imageFlux,IMG_FILTER_GAUSSIAN_BLUR);
		}


	}

	function infos(){
		$infosBrut=getimagesize($this->image);
		$path_parts = pathinfo($this->image);

		$this->infos[0]=$infosBrut[0];
		$this->infos[1]=$infosBrut[1];
		$this->infos[2]=$path_parts['extension'];
		$this->infos[3]=$path_parts['basename'];
		$this->infos[4]=$infosBrut['mime'];
		$this->infos[5]=$infosBrut['bits'];
		if(isset($infosBrut['channels'])) $this->infos[6]=$infosBrut['channels'];
		$this->infos[7]=$path_parts['dirname'];

		return $this->infos ;
	}




	private static function imagecreatefrombmp($url_source){
		$file    =    fopen($p_sFile,"rb");
		$read    =    fread($file,10);
		while(!feof($file)&&($read<>""))
		$read    .=    fread($file,1024);
		$temp    =    unpack("H*",$read);
		$hex    =    $temp[1];
		$header    =    substr($hex,0,108);
		if (substr($header,0,4)=="424d")
		{
			$header_parts    =    str_split($header,2);
			$width            =    hexdec($header_parts[19].$header_parts[18]);
			$height            =    hexdec($header_parts[23].$header_parts[22]);
			unset($header_parts);
		}
		$x                =    0;
		$y                =    1;
		$image            =    imagecreatetruecolor($width,$height);
		$body            =    substr($hex,108);
		$body_size        =    (strlen($body)/2);
		$header_size    =    ($width*$height);
		$usePadding        =    ($body_size>($header_size*3)+4);
		for ($i=0;$i<$body_size;$i+=3)
		{
			if ($x>=$width)
			{
				if ($usePadding)
				$i    +=    $width%4;
				$x    =    0;
				$y++;
				if ($y>$height)
				break;
			}
			$i_pos    =    $i*2;
			$r        =    hexdec($body[$i_pos+4].$body[$i_pos+5]);
			$g        =    hexdec($body[$i_pos+2].$body[$i_pos+3]);
			$b        =    hexdec($body[$i_pos].$body[$i_pos+1]);
			$color    =    imagecolorallocate($image,$r,$g,$b);
			imagesetpixel($image,$x,$height-$y,$color);
			$x++;
		}
		unset($body);
		return $image;
	}


}

?>
