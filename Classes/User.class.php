<?php
class User extends JSONEntity{

	protected $id,$login,$avatar,$rank,$password,$mail,$preferences;
	protected $TABLE_NAME = 'user';
	protected $CLASS_NAME = 'User';
	protected $object_fields = 
	array(
		'id'=>'key',
		'login'=>'string',
		'avatar'=>'longstring',
		'rank'=>'string',
		'password'=>'string',
		'mail'=>'string',
		'preferences'=>'longstring'
	);

	function __construct(){
		parent::__construct();
	}


	function exist($login,$password){
		$userManager = new User();
		return $userManager->load(array('login'=>$login,'password'=>User::encrypt($password)));
	}

	function existAuthToken($auth){
		$result = false;
		$userManager = new User();
		$users = $userManager->populate('id');
		foreach($users as $user){
		
			if(sha1($user->getPassword().$user->getLogin())==$auth) $result = $user;
		}
		return $result;
	}
	
	function getId(){
		return $this->id;
	}

	function getLogin(){
		return $this->login;
	}

	function setLogin($login){
		$this->login = $login;
	}

	function getPassword(){
		return $this->password;
	}

	function setPassword($password){
		$this->password = User::encrypt($password);
	}

	function getAvatar(){
		return $this->avatar;
	}

	function setAvatar($avatar){
		$this->avatar = $avatar;
	}

	function getRank(){
		return $this->rank;
	}

	function setRank($rank){
		$this->rank = $rank;
	}

	function getMail(){
		return $this->mail;
	}

	function setMail($mail){
		$this->rank = $mail;
	}

	function getPreferences(){
		return explode('::->',$this->preferences);
	}

	function setPreferences($preferences){
		$this->preference = implode('::->', $preferences);
	}

	static function encrypt($password){
		return sha1($password);
	}


}

?>