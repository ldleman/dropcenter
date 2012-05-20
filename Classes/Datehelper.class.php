<?php
class Datehelper{
	private $time = '';
	
	public function __construct($time){
		$this->time = $time;
	}

	public function getTime(){
		return $this->time;
	}
	public function getDate($pattern='d/m/Y'){
		
		$date = date($pattern,$this->time);
		$date = str_replace('Mon','Lun',$date);
		$date = str_replace('Tue','Mar',$date);
		$date = str_replace('Wed','Mer',$date);
		$date = str_replace('Thu','Jeu',$date);
		$date = str_replace('Fri','Ven',$date);
		$date = str_replace('Sat','Sam',$date);
		$date = str_replace('Sun','Dim',$date);
		return $date;
	}

	public function setTime($time){
		$this->time = $time;
	}

	public static function getMonday($date){
		$weekDay = date('D',$date);
		switch ($weekDay){
			case 'Mon': $monSous = 0; break;
			case 'Tue': $monSous = 1; break;
			case 'Wed': $monSous = 2; break;
			case 'Thu': $monSous = 3; break;
			case 'Fri': $monSous = 4; break;
			case 'Sat': $monSous = 5; break;
			case 'Sun': $monSous = 6; break;
		}
		$date = strtotime(date('m/d/Y',$date-($monSous*(24*3600))));
		return $date;
	}

	public static function getWeek($date,$weekend=false){
		
		$monday = Datehelper::getMonday($date);
		$week[]= new DateHelper($monday);
		$week[]= new DateHelper($monday+(1*24*3600));
		$week[]= new DateHelper($monday+(2*24*3600));
		$week[]= new DateHelper($monday+(3*24*3600));
		$week[]= new DateHelper($monday+(4*24*3600));
		if($weekend){
		$week[]= new DateHelper($monday+(5*24*3600));
		$week[]= new DateHelper($monday+(6*24*3600));
		}
		return $week;
	}
	
	

	
	
	public static function frenchToUS($date){
		$date = explode('/',$date);
		return $date[1].'/'.$date[0].'/'.$date[2];
	}
	
	public static function monthToString($month){
		
		$monthTab = array(
		'',
		'Janvier',
		'Fevrier',
		'Mars',
		'Avril',
		'Mai',
		'Juin',
		'Juillet',
		'Aout',
		'Septembre',
		'Octobre',
		'Novembre',
		'Decembre'
		);
		return $monthTab[$month];
	}
	
}

?>