<?php

/*
 @nom: Mail
 @auteur: Valentin CARRUESCO (valentin.carruesco@sys1.fr)
 @date de création: 11/10/2011 11:25:48
 @description: Classe de gestion et d\'envois d\'email
 @language :
 */

class Mail
{
	private $id;
	private $expeditorMail;
	private $expeditorName;
	private $message;
	private $format;
	private $recipients;
	private $title;
	private $responseEmail;
	private $attachment;
	private $smtpPort;
	private $smtpUrl;
	private $smtpLogin;
	private $encodage;
	private $bits;
	private $smtpPassword;

	public function __construct($expeditor=null,$encodage=null,$bits=null, $message=null, $format=null, $recipients=null, $title=null, $responseEmail=null, $attachment=null, $smtpPort=null, $smtpUrl=null, $smtpLogin=null, $smtpPassword=null ){
		//Opérations du constructeur...

		if($expeditor!=null) $this->expeditor=$expeditor;
		if($message!=null) $this->message=$message;
		if($format!=null){ $this->format=$format;}else{ $this->format='text/html';}
		if($encodage!=null){ $this->encodage=$encodage;}else{ $this->encodage='iso-8859-1';}
		if($bits!=null){ $this->bits=$bits;}else{ $this->bits='8bit';}
		if($recipients!=null) $this->recipients=$recipients;
		if($title!=null) $this->title=$title;
		if($responseEmail!=null) $this->responseEmail=$responseEmail;
		if($attachment!=null) $this->attachment=$attachment;
		if($smtpPort!=null) $this->smtpPort=$smtpPort;
		if($smtpUrl!=null) $this->smtpUrl=$smtpUrl;
		if($smtpLogin!=null) $this->smtpLogin=$smtpLogin;
		if($smtpPassword!=null) $this->smtpPassword=$smtpPassword;
	}


	public function __call($methode, $attributs){
		//Action sur appel d'une méthode inconnue
	}


	public function __destruct(){
		//Action lors du unset de l'objet
	}


	public function __toString(){
		$retour = "instance de la classe Mail : <br/>";
		$retour .= '$id : '.$this->getId().'<br/>';

		$retour .= '$expeditor : '.$this->expeditorName.'<br/>';
		$retour .= '$expeditor mail : '.$this->expeditorMail.'<br/>';
		$retour .= '$message : '.$this->message.'<br/>';
		$retour .= '$format : '.$this->format.'<br/>';
		$retour .= '$recipient : '.$this->recipients.'<br/>';
		$retour .= '$title : '.$this->title.'<br/>';
		$retour .= '$responseEmail : '.$this->responseEmail.'<br/>';
		$retour .= '$attachment : '.$this->attachment.'<br/>';
		$retour .= '$smtp Port : '.$this->smtpPort.'<br/>';
		$retour .= '$smtp Url : '.$this->smtpUrl.'<br/>';
		$retour .= '$smtp Login : '.$this->smtpLogin.'<br/>';
		$retour .= '$smtp password : '.$this->smtpPassword.'<br/>';
		return $retour;
	}


	public  function __clone(){
		//Action lors du clonage de l'objet Mail
	}


	/**
	 * Methode de mise en session de l'objet Mail
	 * @author Valentin CARRUESCO
	 * @category SESSION
	 * @param <String> $name=nom de la classe, definis la clé de l'objet en session
	 * @return Aucun retour
	 */
	public function session($name="Mail"){
		$_SESSION[$name] = serialize($this);
	}


	/**
	 * Methode de traduction de l'objet Mail en json (necessite au minimum de PHP 5.2 et de l'extension l'extension JSON de PECL)
	 * @author Valentin CARRUESCO
	 * @category SESSION
	 * @require PHP 5.2
	 * @require extension JSON de PECL
	 * @require encodage UTF-8
	 * @return code json
	 */
	public function json(){
		return json_encode($this);
	}




	/**
	 * Méthode de serialisation des attributs de la classe Mail pour le transfert javascript
	 * @author Valentin CARRUESCO
	 * @category Transport language
	 * @return<String> chaine serialisée
	 */
	public function forJavascript(){
		$retour = "";

		$retour .= 'expeditor[*:*]'.$this->expeditor.'[*-*]';
		$retour .= 'message[*:*]'.$this->message.'[*-*]';
		$retour .= 'format[*:*]'.$this->format.'[*-*]';
		$retour .= 'recipient[*:*]'.$this->recipient.'[*-*]';
		$retour .= 'title[*:*]'.$this->title.'[*-*]';
		$retour .= 'responseEmail[*:*]'.$this->responseEmail.'[*-*]';
		$retour .= 'attachment[*:*]'.$this->attachment.'[*-*]';
		$retour .= 'smtp Port[*:*]'.$this->smtpPort.'[*-*]';
		$retour .= 'smtp Url[*:*]'.$this->smtpUrl.'[*-*]';
		$retour .= 'smtp Login[*:*]'.$this->smtpLogin.'[*-*]';
		$retour .= 'smtp password[*:*]'.$this->smtpPassword;
		return $retour;
	}


	/**
	 * Methode d'envois du mail
	 * @author Valentin CARRUESCO
	 * @category SMTP
	 */

	public function send(){


		$retour = true;

		//-----------------------------------------------
		//GENERE LA FRONTIERE DU MAIL ENTRE TEXTE ET HTML
		//-----------------------------------------------

		$frontiere = '-----=' . md5(uniqid(mt_rand()));

		//-----------------------------------------------
		//HEADERS DU MAIL
		//-----------------------------------------------



		$headers = 'From: "'.$this->getExpeditorMail().'" <'.$this->getExpeditorMail().'>'."\n";
		$headers .= 'Return-Path: <'.$this->getExpeditorMail().'>'."\n";
		$headers .= 'MIME-Version: 1.0'."\n";
		$headers .= 'Content-Type: multipart/mixed; boundary="'.$frontiere.'"';

		//-----------------------------------------------
		//MESSAGE HTML
		//-----------------------------------------------
		$message = '--'.$frontiere."\n";

		$message .= 'Content-Type: text/html; charset="iso-8859-1"'."\n";
		$message .= 'Content-Transfer-Encoding: 8bit'."\n\n";
		$message .=  '<html>' .
			'<head>' .
			'<title>'.$this->getTitre().'</title>' .
			'</head>' .
			'<body style="padding:0px;margin:0px;"><div style="border-bottom:1px solid #227D9B;font-size:10px;padding:3px;background-color:#4FB3D6;color:#ffffff;width:100%;font-family:Verdana,Arial;">Bonjour! ' .
		$this->getExpeditorName().' à utilisé le site de sys1 pour communiquer, voici son message :<br></div>' .
		$this->getMessage().'</body>' .
			'</html>';
		$message .= "\n\n";

		$message .= '--'.$frontiere."\n";

		//-----------------------------------------------
		//PIECE JOINTE
		//-----------------------------------------------

		if(count($this->attachment)>0){
			foreach($this->attachment as $attachment){
				$message .= 'Content-Type: application/excel; name="'.$attachment.'"'."\n";
				$message .= 'Content-Transfer-Encoding: base64'."\n";
				$message .= 'Content-Disposition:attachement; filename="'.$attachment.'"'."\n\n";
				$message .= chunk_split(base64_encode(file_get_contents($attachment)))."\n";
			}
		}
		$recipients = $this->getRecipients();


		if(isset($recipients)){
			foreach($recipients as $key=>$destinataire){
				if(!mail($destinataire->getEmail(), $this->getTitle(),$message,$headers))
				{
					Journal::put(12,'ERREUR ENVOIS EMAIL','Caracteristiques de l\'email: '.$this);
					$retour = false ;
				}

			}
		}
		return $retour;

	}


	// ACCESSEURS

	/**
	 * Méthode de récuperation de l'attribut  de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute>
	 */

	public function getId(){
		return $this->id;
	}

	/**
	 * Méthode de définition de l'attribut  de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute>
	 */

	public function setId($id){
		$this->id = $id;
	}

	/**
	 * Méthode de récuperation de l'attribut Expeditor de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> expeditor
	 */

	public function getExpeditorName(){
		return $this->expeditorName;
	}

	/**
	 * Méthode de définition de l'attribut Expeditor de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $expeditor
	 * @return Aucun retour
	 */

	public function setExpeditorName($expeditorName){
		$this->expeditorName = $expeditorName;
	}

	/**
	 * Méthode de récuperation de l'attribut Expeditor de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> expeditor
	 */

	public function getExpeditorMail(){
		return $this->expeditorMail;
	}

	/**
	 * Méthode de définition de l'attribut Expeditor de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $expeditor
	 * @return Aucun retour
	 */

	public function setExpeditorMail($expeditorMail){
		$this->expeditorMail = $expeditorMail;
	}

	/**
	 * Méthode de récuperation de l'attribut Message de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> message
	 */

	public function getMessage(){
		return $this->message;
	}

	/**
	 * Méthode de définition de l'attribut Message de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $message
	 * @return Aucun retour
	 */

	public function setMessage($message){
		$this->message = $message;
	}

	/**
	 * Méthode de récuperation de l'attribut Format de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> format
	 */

	public function getFormat(){
		return $this->format;
	}

	/**
	 * Méthode de définition de l'attribut Format de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $format
	 * @return Aucun retour
	 */

	public function setFormat($format){
		$this->format = $format;
	}


	/**
	 * Méthode de récuperation de l'attribut Recipient de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> recipient
	 */

	public function getRecipients(){
		return $this->recipients;
	}

	/**
	 * Méthode de définition de l'attribut Recipient de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $recipient
	 * @return Aucun retour
	 */

	public function setRecipients($recipient){
		$this->recipients = $recipient;
	}

	/**
	 * Méthode d'ajout de l'attribut destinataire dans le conteneur destinataires de la classe Newsletter
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Utilisateur> $destinataire
	 * @return Aucun retour
	 */

	public function addRecipient($recipient){
		$recipients = $this->getRecipients();
		$recipients[] = $recipient;
		$this->setRecipients($recipients);
	}


	/**
	 * Méthode de récuperation de l'attribut Title de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> title
	 */

	public function getTitle(){
		return $this->title;
	}

	/**
	 * Méthode de définition de l'attribut Title de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $title
	 * @return Aucun retour
	 */

	public function setTitle($title){
		$this->title = $title;
	}

	/**
	 * Méthode de récuperation de l'attribut ResponseEmail de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> responseEmail
	 */

	public function getResponseEmail(){
		return $this->responseEmail;
	}

	/**
	 * Méthode de définition de l'attribut ResponseEmail de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $responseEmail
	 * @return Aucun retour
	 */

	public function setResponseEmail($responseEmail){
		$this->responseEmail = $responseEmail;
	}

	/**
	 * Méthode de récuperation de l'attribut Attachment de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> attachment
	 */

	public function getAttachment(){
		return $this->attachment;
	}

	/**
	 * Méthode de définition de l'attribut Attachment de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $attachment
	 * @return Aucun retour
	 */

	public function setAttachment($attachment){
		$this->attachment = $attachment;
	}

	public function addAttachment($attachment){

		$attachments =  $this->getAttachment() ;
		$attachments[]= $attachment;
		$this->setAttachment($attachments);
	}

	/**
	 * Méthode de récuperation de l'attribut Smtp Port de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> smtp Port
	 */

	public function getSmtpPort(){
		return $this->smtpPort;
	}

	/**
	 * Méthode de définition de l'attribut Smtp Port de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $smtp Port
	 * @return Aucun retour
	 */

	public function setSmtpPort($smtpPort){
		$this->smtpPort = $smtpPort;
	}

	/**
	 * Méthode de récuperation de l'attribut Smtp Url de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> smtp Url
	 */

	public function getSmtpUrl(){
		return $this->smtpUrl;
	}

	/**
	 * Méthode de définition de l'attribut Smtp Url de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $smtp Url
	 * @return Aucun retour
	 */

	public function setSmtpUrl($smtpUrl){
		$this->smtpUrl = $smtpUrl;
	}

	/**
	 * Méthode de récuperation de l'attribut Smtp Login de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> smtp Login
	 */

	public function getSmtpLogin(){
		return $this->smtpLogin;
	}

	/**
	 * Méthode de définition de l'attribut Smtp Login de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $smtp Login
	 * @return Aucun retour
	 */

	public function setSmtpLogin($smtpLogin){
		$this->smtpLogin = $smtpLogin;
	}

	/**
	 * Méthode de récuperation de l'attribut Smtp password de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> smtp password
	 */

	public function getSmtpPassword(){
		return $this->smtpPassword;
	}

	/**
	 * Méthode de définition de l'attribut Smtp password de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $smtp password
	 * @return Aucun retour
	 */

	public function setSmtpPassword($smtpPassword){
		$this->smtpPassword = $smtpPassword;
	}

	/**
	 * Méthode de récuperation de l'attribut encodage de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> encodage
	 */

	public function getEncodage(){
		return $this->encodage;
	}

	/**
	 * Méthode de définition de l'attribut encodage de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $encodage
	 * @return Aucun retour
	 */

	public function setEncodage($encodage){
		$this->encodage = $encodage;
	}

	/**
	 * Méthode de récuperation de l'attribut bits de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param Aucun
	 * @return <Attribute> bits
	 */

	public function getBits(){
		return $this->bits;
	}

	/**
	 * Méthode de définition de l'attribut bits de la classe Mail
	 * @author Valentin CARRUESCO
	 * @category Accesseur
	 * @param <Attribute> $bits
	 * @return Aucun retour
	 */

	public function setBits($bits){
		$this->bits = $bits;
	}


}
?>