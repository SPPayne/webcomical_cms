<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class String_manip{

	public function __construct(){
		//NOWT
	}
	
	//Turn string into a slug
	public function slugify($str){
		
		//Input
		if(!$str){
			return FALSE;
		}
		
		//Remove excess spaces
		$str = explode(' ',trim($str));
		$str = array_filter($str);
		$str = implode('-',$str);
		
		//Lowercase the lot
		$str = strtolower($str);
		
		//Remove all bar the alphanumeric character
		$str = str_ireplace('.','-',$str);
		$str = preg_replace('/[^a-z0-9_\-]/','',$str);
		
		//Explode on dashes, remove empty values, glue back together - prevents clumping of dashes e.g. "---"
		$str = explode('-',$str);
		$str = array_filter($str,'strlen'); //Strlen preserves "0" as a valid value - ref: http://stackoverflow.com/questions/14134006/remove-null-false-and-but-not-0-from-a-php-array
		$str = implode('-',$str);
		
		//Return slugified string
		return $str;
		
	}
	
	//Takes string, converts to mySQL timestamp
	public function create_timestamp($str){
		return date('Y-m-d H:i:s',strtotime($str));
	}
	
	//Loops through an array and trims only the string values
	public function trimify_array($array){
		
		//Input
		if(!$array || !is_array($array)){
			return FALSE;
		}
		
		//Loop...
		foreach($array as $key => $value){
			
			//Have to check in case of arrays, hence lack of array_map()
			if(is_string($value)){
				$array[$key] = trim($value);
			}
			
		}
		
		//Return "trimified" array
		return $array;
		
	}
	
	//Tame a wild string back to an alphanumeric state regardless of what it is
	public function make_tame($str){
		return preg_replace('/[^A-Za-z0-9_\-.,!?"\'\(\) ]/','',strip_tags($str));
	}
	
}
