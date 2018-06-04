<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Ref: https://stackoverflow.com/questions/44843305/how-to-integrate-phpmailer-with-codeigniter-3

class Phpmailer_library{
	
	public function __construct(){
		//log_message('Debug', 'PHPMailer class is loaded.');
	}

	public function load(){
		require_once(APPPATH."third_party/phpmailer/PHPMailerAutoload.php");
		$objMail = new PHPMailer;
		return $objMail;
	}
	
}