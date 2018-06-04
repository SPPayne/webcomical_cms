<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Redirects_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	
	//FUNCTION INDEX - Search a function code to skip to that part of the file
	/* CREATE:
	 * FUNC_ANR 	- Creates a redirect entry
	 * 
	 * READ:
	 * FUNC_FAR 	- Grab the contents of the redirects table
	 * FUNC_FRE 	- Fetch one redirect via its ID
	 * FUNC_VAL 	- Validate a new redirect
	 * 
	 * UPDATE:
	 * FUNC_UPR 	- Update a redirect entry
	 * 
	 * DESTROY:
	 * FUNC_RER 	- Remove a redirect entry
	 */
	
	/***** CREATE *****/
	
	//FUNC_ANR - Creates a redirect entry
	public function add_new_redirect($type,$old_slug,$new_slug){
		
		//Form the insert SQL
		$sql = "INSERT INTO `redirects` SET `type` = " . $this->db->escape($type) . ", `url` = " . $this->db->escape($old_slug) . 
		", `redirect` = " . $this->db->escape($new_slug);
		
		//Run
		if(!$this->db->query($sql)){
			return FALSE;
		}
		return TRUE;
		
	}
	
	/***** READ *****/
	
	//FUNC_FAR - Grab the contents of the redirects table
	public function fetch_all_redirects($redirectid = FALSE){
		
		//Gets all redirects
		$this->db->select('*');
		$this->db->from('redirects');
		
		$query = $this->db->get();
		
		//DEBUG
		//echo $this->db->last_query();
		
		//Result!
		if($query->num_rows() > 0){

			//Format values into array with items assigned to a type
			$format = array();
			foreach($query->result() as $item){
				$format[$item->type][] = $item;
			}
			
			//Return formatted array
			return $format;
			
		}
			
		//No result
		return FALSE;
		
	}
	
	//FUNC_FRE - Fetch one redirect via its ID and/or URL slug
	public function fetch_redirect($redirectid = FALSE,$slug = FALSE,$type = FALSE){
		
		//Input required
		if(!$redirectid && !$slug){
			return FALSE;
		}
		
		//Fetch all details
		$this->db->select('*');
		$this->db->from('redirects');
		
		//ID known
		if($redirectid){
			$this->db->where('id',$redirectid);
		}
		
		//Slug known
		if($slug){
			$this->db->where('url',$slug);
		}
		
		//Type known
		if($type){
			$this->db->where('type',$type);
		}
		
		//Limit 1, fetch
		$this->db->limit(1);
		$query = $this->db->get();
		
		//DEBUG
		//echo $this->db->last_query();
		
		//Result!
		if($query->num_rows() > 0){

			//Return the one row
			return $query->result()[0];
			
		}
			
		//No result
		return FALSE;
		
	}
	
	//FUNC_VAL - Validate a new redirect
	public function validate($input,$fields){
		
		//Load validation library
		$this->load->library('validation');

		//Set error array
		$errors = array();
		
		//URL cannot be the same as the redirect! Obviously.
		if($input['redirect_url'] == $input['redirect_redirect']){
			$errors[] = "Both URL slugs cannot be the same!";
		}
		
		//Check validity of all fields
		foreach($input as $field => $value){
			
			//Remove prefix
			$field = str_ireplace('redirect_','',$field);
			
			//Do case by case
			switch($field){
				case "url":
				case "redirect":
					
					//Required
					if(!$this->validation->exist_check($value)){
						
						$errors[] = $fields[$field]['label'] . " is required.";
						
					} else {
					
						//Alphanumeric (with allowed punctuation)
						if(!$this->validation->is_alphanumeric($value,$allowed = array('-','_'))){
							$errors[] = $fields[$field]['label'] . " - letters, numbers, dashes and underscores only.";
						}
						
						//Required length?
						if(strlen($value) > $fields[$field]['maxlength']){
							$errors[] = $fields[$field]['label'] . " - must be less than " . $fields[$field]['maxlength'] . " characters in length.";
						}
						if(strlen($value) < $fields[$field]['minlength']){
							$errors[] = $fields[$field]['label'] . " - must be longer than " . $fields[$field]['minlength'] . " characters in length.";
						}
					
					}
					
					//Check if the slug already exists in a redirect...
					$existing = $this->fetch_redirect(FALSE,$slug = $value,$input['redirect_type']);
					if($existing != FALSE){
						$errors[] = $fields[$field]['label'] . " - the slug you have entered is already in place for a " . $field . ".";
					}

					//Checks if the redirected page actually exists
					switch($input['redirect_type']){
						case "comic":
							
							//Load model
							$this->load->model('Comic_model','Comic');
							
							//Attempt to fetch page
							$filter = array('slug' => $value);
							$comic = $this->Comic->fetch_page($filter);
							
							//URL cannot match an existing comic page
							if($comic && $field == "url"){
								$errors[] = $fields[$field]['label'] . " - the slug you have entered is already being used on an existing page.";
							//Redirect must match an existing comic page
							} elseif(!$comic && $field == "redirect"){
								$errors[] = $fields[$field]['label'] . " - the comic page being redirected to does not exist.";
							}
							
						break;
						case "character":
							
							//Load model
							$this->load->model('Characters_model','Characters');
							
							//Attempt to fetch character
							$filter = array('slug' => $value);
							$char = $this->Characters->fetch_character($filter);
							
							//URL cannot match an existing char page
							if($char && $field == "url"){
								$errors[] = $fields[$field]['label'] . " - the slug you have entered is already being used on an existing profile.";
							//Redirect must match an existing char page
							} elseif(!$char && $field == "redirect"){
								$errors[] = $fields[$field]['label'] . " - the character profile being redirected to does not exist.";
							}
							
						break;
						case "tag":
						
							//Load model
							$this->load->model('Tagging_model','Tags');
							
							//Attempt to fetch tag
							$tag = $this->Tags->fetch_tag(FALSE,FALSE,$slug = $value);
							
							//URL cannot match an existing tag page
							if($tag && $field == "url"){
								$errors[] = $fields[$field]['label'] . " - the slug you have entered is already being used on an existing tag.";
							//Redirect must match an existing char page
							} elseif(!$tag && $field == "redirect"){
								$errors[] = $fields[$field]['label'] . " - the tag being redirected to does not exist.";
							}
						
						break;
					}
					
				break;
				case "type":
					
					//Required
					if(!$this->validation->exist_check($value)){
						
						$errors[] = "Type is required.";
						
					} else {
						
						//Check that the type is an allowed value
						$range = array('comic','character','tag');
						if(!$this->validation->in_valid_range($value,$range)){
							$errors[] = "Type does not contain an allowed value.";
						}
					
					}
					
				break;
			}
			
		}
		
		//DEBUG
		//echo "Error: "; print_r($input);
		
		//Return errors
		return $errors;
		
	}
	
	/***** UPDATE *****/
	
	//FUNC_UPR - Update a redirect entry
	public function update_redirect($type,$old_slug,$new_slug){
		
		//Form update
		$sql = "UPDATE `redirects` SET `redirect` = " . $this->db->escape($new_slug) . " WHERE `redirect` = " . $this->db->escape($old_slug) . 
		" AND type = " . $this->db->escape($type);
		
		//Run
		if(!$this->db->query($sql)){
			return FALSE;
		}
		return TRUE;
		
	}
	
	/***** DESTROY *****/
	
	//FUNC_RER - Remove a redirect entry
	public function remove_redirect($redirectid = FALSE,$redirect = FALSE,$url = FALSE,$type = "comic"){
		
		//Some input required!
		if($redirectid == FALSE && $redirect == FALSE && $url == FALSE){
			return FALSE;
		}
		
		//Start sql
		$sql = "DELETE FROM `redirects` WHERE ";
		
		//Set modifiers
		if($redirectid != FALSE){
			$modifiers[] = "`id` = " . $this->db->escape($redirectid);
		}
		if($redirect != FALSE){
			$modifiers[] = "`redirect` = " . $this->db->escape($redirect);
		}
		if($url != FALSE){
			$modifiers[] = "`url` = " . $this->db->escape($url);
		}
		$modifiers[] = "`type` = " . $this->db->escape($type);
		
		//DEBUG
		//print_r($modifiers);die;
		
		//Add to SQL
		$sql .= implode(' AND ', $modifiers);
		
		//Run, end function
		$this->db->query($sql);
		return TRUE;
		
	}
	
}
