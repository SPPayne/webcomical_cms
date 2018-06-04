<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	
	//FUNCTION INDEX - Search a function code to skip to that part of the file
	/* CREATE:
	 * 
	 * READ:
	 * FUNC_VAL 	- Validate info for a user
	 * FUNC_GUC 	- Get a count of users in the system
	 * 
	 * UPDATE:
	 * FUNC_UPD 	- Insert or update a user's credentials (does some formatting, uses ion_auth to do the actual deed)
	 * 
	 * DESTROY:
	 * FUNC_DELU 	- Delete, basically a wrapper for the ion_auth function
	 */
	
	/***** CREATE *****/
	
	/***** READ *****/
	
	//FUNC_VAL - Validate info for a user
	public function validate($input,$fields,$userid = FALSE,$install = FALSE){
		
		//Note: install flag is for first-time install only - it flags up that there aren't any 
		//users so we don't need to do "new user" checks!
		
		//Load validation library
		$this->load->library('validation');

		//Set error array
		$errors = array();
		
		/*
			Array(
				[usr_first-name] => Admin
				[usr_surname] => istrator
				[usr_username] => administrator
				[usr_email-address] => admin@admin.com
				[usr_password] => 
			)
		*/
		
		//If userid, get existing details
		if($userid != FALSE){
			$this->load->model('Ion_auth_model','Auth'); //Load auth library
			$user = $this->Auth->user($userid)->row();
		}
		
		//Check validity of all fields
		foreach($input as $field => $value){
			
			//Remove prefix
			$field = str_replace('usr_','',$field);
			
			//Do case by case
			switch($field){
				case "first-name":
				case "surname":
					
					//Required
					if(!$this->validation->exist_check($value)){
						
						$errors[] = $fields[$field]['label'] . " is required.";
						
					} else {
					
						//Alphanumeric
						if(!$this->validation->is_alphanumeric($value,$allowed = array(' ',',',"'",'-','.'))){
							$errors[] = $fields[$field]['label'] . " - letters, numbers, limited punctuation and spaces only.";
						}
						
						//Required length?
						if(strlen($value) > $fields[$field]['maxlength']){
							$errors[] = $fields[$field]['label'] . " - must be less than " . $fields[$field]['maxlength'] . " characters in length.";
						}
						if(strlen($value) < $fields[$field]['minlength']){
							$errors[] = $fields[$field]['label'] . " - must be longer than " . $fields[$field]['minlength'] . " characters in length.";
						}
					
					}
				
				break;
				case "username":
				
					//Required
					if(!$this->validation->exist_check($value)){
						
						$errors[] = $fields[$field]['label'] . " is required.";
						
					} else {
					
						//Alphanumeric
						if(!$this->validation->is_alphanumeric($value,$allowed = array('_'))){
							$errors[] = $fields[$field]['label'] . " - letters, numbers and underscores only.";
						}
						
						//Already exists? Only run if username has changed or new user
						if(($userid != FALSE && $value != $user->username) || ($userid == FALSE && $install == FALSE)){
							if($this->Auth->username_check($value,$userid)){
								$errors[] = $fields[$field]['label'] . " - that username has already been taken.";
							}
						}
					
					}
				
				break;
				case "email-address":
				
					//Required
					if(!$this->validation->exist_check($value)){
						
						$errors[] = $fields[$field]['label'] . " is required.";
						
					} else {
					
						//Email address
						if(!$this->validation->is_email_address($value)){
							$errors[] = $fields[$field]['label'] . " - is not a valid email address.";
						}
						
						//Already exists? Only run if email has changed or new user
						if(($userid != FALSE && $value != $user->email) || ($userid == FALSE && $install == FALSE)){
							if($this->Auth->email_check($value,$userid)){
								$errors[] = $fields[$field]['label'] . " - that email address is already in use.";
							}
						}
					
					}
				
				break;
				case "password":
					
					//If password has been set...
					if($value != ""){
						
						//...Test it!
						if(!$this->validation->match_password_requirement($value)){
							$errors[] = $fields[$field]['label'] . " - is not a strong enough password.";
						}
						
					}
				
				break;
			}
			
		}
		
		//If password confirm field exists, do a comparison!
		if(isset($input['usr_password_confirm'])){
			if($input['usr_password_confirm'] != $input['usr_password']){
				$errors[] = "Passwords - entered passwords do not match!";
			}
		}
		
		//DEBUG
		//print_r($errors);die;
		
		//Return errors
		return $errors;
		
	}
	
	//FUNC_GUC - Get a count of users in the system
	public function get_user_count(){
		
		//Return a count of users
		$this->load->library(array('ion_auth'));
		return count($this->ion_auth->users()->result());
		
	}
	
	/***** UPDATE *****/
	
	//FUNC_UPD - Insert or update a user's credentials (does some formatting, uses ion_auth to do the actual deed)
	public function update($userid = FALSE,$input,$fields){
		
		//DEBUG
		//print_r($input);die;
		
		//Load auth library
		$this->load->model('Ion_auth_model','Auth');
		
		//Insert
		if($userid == FALSE){
			
			//Prep values
			$username 	= $input['usr_username'];
			$password 	= $input['usr_password'];
			$email 		= $input['usr_email-address'];
			$additional_data = array(
				'first_name' 	=> $input['usr_first-name'],
				'last_name' 	=> $input['usr_surname'],
			);
			$group = array('1');
			
			//Run insert
			$ran = $this->Auth->register($username,$password,$email,$additional_data,$group);
			if(!$ran){
				return FALSE;
			}
		
		//Update
		} else {
			
			//Prep update array
			$update = array();
			foreach($input as $fieldname => $value){
				$fieldname = str_replace('usr_','',$fieldname);
				if($fieldname == "password" && $value != ""){
					$update['password'] = $value;
				} elseif($fieldname != "password"){
					$update[$fields[$fieldname]['ion_field']] = $value;
				}
			}
			
			//DEBUG
			//print_r($input);
			//print_r($update);die;
			
			//Run update
			$ran = $this->Auth->update($userid,$update);
			if(!$ran){
				return FALSE;
			}
			
		}
		
		//Update ran!
		return $ran;
		
	}
	
	//FUNC_SDEBAR - Update sidebar preference for user
	public function update_siderbar_preference($userid,$status){
		
		//Form SQL
		$sql = "UPDATE `users` SET `admin_sidebar` = " . $this->db->escape($status) . " WHERE `id` = " . $this->db->escape($userid);
		
		//DEBUG
		//echo $sql;
		
		//Run
		if(!$this->db->query($sql)){
			return FALSE;
		}
		return TRUE;
		
	}
	
	/***** DESTROY *****/
	
	//FUNC_DELU - Delete, basically a wrapper for the ion_auth function
	public function delete_user($userid){
		
		//Load auth library
		$this->load->model('Ion_auth_model','Auth');
		
		//Set error string
		$error = "";
		
		//No userid = fail
		if(!$userid){
			return "No user to delete.";
		}
		
		//Check there's more than one user in the system, otherwise there could be bad times ahead...
		if($this->get_user_count() <= 1){
			return "There is only one user on the system - deleting this last user will lock you out of the system!";
		}
		
		//Check that we're not deleting the account we are logged in as otherwise MORE BAD TIMES...
		$this->load->library('ion_auth');
		$current_userid = $this->ion_auth->get_user_id();
		if($userid == $current_userid){
			return "You cannot delete yourself!";
		}
		
		//Run function
		if(!$this->Auth->delete_user($userid)){
			return "Deletion could not be processed.";
		}
		
		//Success
		return TRUE;
		
	}
	
}