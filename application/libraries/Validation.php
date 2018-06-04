<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validation{

	public function __construct(){
		//NOWT
	}
	
	//Is current request AJAX? Return TRUE or FALSE
	public function is_ajax_request(){
		
		//Detect
		//Ref: https://davidwalsh.name/detect-ajax
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			return TRUE;
		}
		
		//Default = FALSE
		return FALSE;
		
	}
	
	//Is value empty?
	public function exist_check($str){
		
		//If string is empty, return FALSE
		if(!$str || empty($str) || is_null($str) || $str == ""){
			return FALSE;
		}
		
		//Something there
		return TRUE;
		
	}
	
	//Is value alphanumeric - pass in allowed characters
	public function is_alphanumeric($str,$allowances = array()){
		
		//If spaces are allowed, strip 'em for testing
		if(!empty($allowances)){
			foreach($allowances as $allow){
				$str = str_ireplace($allow,'',$str);
			}
		}
		
		//Do a test
		if(!preg_match('/^[A-Za-z0-9_]+$/',$str)){
			return FALSE;
		}
		
		//Valid
		return TRUE;
		
	}
	
	//Is value a boolean?
	//Ref: http://stackoverflow.com/questions/8272723/test-if-string-could-be-boolean-php
	public function is_boolean($str){
		$str = strtolower($str);
		return(in_array($str, array("true", "false", "1", "0", "yes", "no"), true));
	}
	
	//Is value a valid email address?
	public function is_email_address($str){
		
		//Do a test - regex allows for all the fancy-dan new domains, too
		if(!preg_match("/^[_a-zA-Z0-9-%&\+']+(\.[_a-zA-Z0-9-%&\+']+)*@[a-zA-Z0-9-%']+(\.[a-zA-Z0-9-%']+)*(\.[a-zA-Z]{2,20})$/",$str)){
			return FALSE;
		}
		
		//Valid
		return TRUE;
		
	}
	
	//Is value a valid URL?
	public function is_url($str){
		
		//Do a test
		if(!preg_match("/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/",$str)){
			return FALSE;
		}
		
		//Valid
		return TRUE;
		
	}
	
	//Is value a valid hostname?
	public function is_hostname($str){
		
		//Do a test
		if(!preg_match("/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/",$str)){
			return FALSE;
		}
		
		//Valid
		return TRUE;
		
	}
	
	//Password strong enough?
	public function match_password_requirement($str){
		
		//Length?
		if(strlen($str) < 8){
			return FALSE;
		}
		
		//Test for letters and numbers
		if(!preg_match('/[A-Za-z]/',$str) || !preg_match('/[0-9]/',$str)){
			return FALSE;
		}
		
		//Valid
		return TRUE;
		
	}
	
	//Valid date/time string?
	//Ref: http://stackoverflow.com/questions/19271381/correctly-determine-if-date-string-is-a-valid-date-in-that-format
	public function is_valid_datetime($date){
		
		$timestamp = strtotime($date);
		return $timestamp ? TRUE : FALSE;
		
	}
	
	//Checks if a value is in a range of values, useful for select fields
	public function in_valid_range($value,$range = array()){
		
		//DEBUG
		//echo $value; print_r($range);
		
		//Check in array
		if(!in_array($value,$range)){
			return FALSE;
		}
		
		//Valid option
		return TRUE;
		
	}
	
	//Check to see if a string is HTML
	//Ref: http://stackoverflow.com/questions/10778035/how-to-check-if-string-contents-have-any-html-in-it
	public function is_html($string){
		
		if($string != strip_tags($string)){
            return TRUE; //Contains HTML
        }
        return FALSE; //Does not contain HTML
		
    }
    
    //Check image dimensions
    public function img_has_valid_dimensions($img_dimensions,$restrictions){
		
		//Comparisons
		if($img_dimensions['width'] > $restrictions['width'] || $img_dimensions['height'] > $restrictions['height']){
			return FALSE;
		}
		
		//Valid
		return TRUE;
		
	}
	
}
