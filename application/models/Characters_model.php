<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Characters_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	
	//FUNCTION INDEX - Search a function code to skip to that part of the file
	/* CREATE:
	 * 
	 * READ:
	 * FUNC_VAL 	- Validate char details
	 * FUNC_FORM 	- Formats data for db (PRIV)
	 * FUNC_GUS 	- Generate unique slug for the character, prevents duplicates! (PRIV)
	 * FUNC_FCH 	- Fetch a character
	 * FUNC_FAC 	- Fetch all characters
	 * FUNC_MCO 	- Detects if characters are missing an order
	 * FUNC_VPI 	- Checks that profile images still exist
	 * FUNC_FMCO 	- Fetches the maximum character ordering (PRIV)
	 * 
	 * UPDATE:
	 * FUNC_UPD 	- Update OR insert a character
	 * FUNC_RAC 	- Reorder chars
	 * FUNC_UCO 	- Update a character's order
	 * FUNC_UPF 	- Update filepath for a profile img
	 * 
	 * DESTROY:
	 * FUNC_DCH 	- Delete character from db
	 */
	
	/***** CREATE *****/
	
	//See FUNC_UPD for creation!
	
	/***** READ *****/
	
	//FUNC_VAL - Validate char details
	public function validate($input,$fields){
		
		//Load validation library
		$this->load->library('validation');

		//Fetch tagging model
		$this->load->model('Tagging_model','Tags');

		//Set error array
		$errors = array();
		
		//Check validity of all fields
		foreach($input as $field => $value){
			
			//Remove prefix
			$field = str_ireplace('character_','',$field);
			
			//Do case by case
			switch($field){
				case "name":
					
					//Required
					if(!$this->validation->exist_check($value)){
						
						$errors[] = $fields[$field]['label'] . " is required.";
						
					} else {
					
						//Alphanumeric (with allowed punctuation)
						if(!$this->validation->is_alphanumeric($value,$allowed = array(' ',',','-','.','!','?',"'",':','"','(',')'))){
							$errors[] = $fields[$field]['label'] . " - letters, numbers, limited punctuation and spaces only.";
						}
						
						//Required length?
						if(strlen($value) > $fields[$field]['maxlength']){
							$errors[] = $fields[$field]['label'] . " - must be less than " . $fields[$field]['maxlength'] . " characters in length.";
						}
						if(strlen($value) < $fields[$field]['minlength']){
							$errors[] = $fields[$field]['label'] . " - must be longer than " . $fields[$field]['minlength'] . " characters in length.";
						}
						
						//Does name match an existing tag?
						if($this->Tags->fetch_tag(FALSE,$value,FALSE) != FALSE){
							$errors[] = $fields[$field]['label'] . " - that character name already exists as a tag, please delete the tag first.";
						}
					
					}
					
				break;
				case "bio":
				case "excerpt":
				
					//Required length?
					if(strlen($value) > $fields[$field]['maxlength']){
						$errors[] = $fields[$field]['label'] . " - must be less than " . $fields[$field]['maxlength'] . " characters in length.";
					}
					
				break;
				case "active":
					
					//Correct value if set?
					if($this->validation->exist_check($value) && $value != "Y"){
						$errors[] = $fields[$field]['label'] . " - set value is not correct (are you tring to hack the checkbox?) ;)";
					}
					
				break;
			}
			
		}
		
		//DEBUG
		//echo "Error: "; print_r($input);
		
		//Return errors
		return $errors;
		
	}
	
	//FUNC_FORM - Formats data for db (PRIV)
	private function _format($input,$fields,$update){
		
		//Load string modify library
		$this->load->library('string_manip');
		
		//Create the array to return
		$formatted = array();
		
		//Loop through config fields
		foreach($input as $field => $value){
			
			//Remove prefix
			$field_name = str_ireplace('character_','',$field);
			
			//Do case by case
			switch($field_name){
				case "name":
					
					//Retain special entities
					$value = htmlspecialchars($value);
				
				break;
			}
			
			//Assign to formatted array, assign db field
			$formatted[$fields[$field_name]['db_field']] = $value;
			
		}
		
		//If active flag not set, manually set to "no"
		if(!isset($input['character_active'])){
			$formatted['profile_active'] = "N";
		}

		//DEBUG
		//print_r($input);die;
		
		//Load redirection model
		$this->load->model('Redirects_model','Redirects');

		//Create a slug (if a new record)
		if($update == FALSE){
			
			//Generate a unique slug
			$formatted['slug'] = $this->_generate_unique_slug($input['character_name']);
			
			//Remove any redirects that contain the new slug (new char will "adopt" that old slug)
			$this->Redirects->remove_redirect(FALSE,FALSE,$url = $formatted['slug'],$type = "character");
			
		//Updating record...
		} else {
			
			//First fetch the existing record
			$character = $this->fetch_character($filters = array('characterid' => $update));
			
			//Only run the slug generation if the title has changed!
			if($character->name != $input['character_name']){
				
				//Assign generated slug
				$formatted['slug'] = $this->_generate_unique_slug($input['character_name']);
				
				//Add a new redirect and update any existing ones to the new one
				$this->load->model('Redirects_model','Redirects');
				$this->Redirects->remove_redirect(FALSE,FALSE,$url = $formatted['slug'],$type = "character");
				$this->Redirects->add_new_redirect($type = "character",$character->slug,$formatted['slug']);
				$this->Redirects->update_redirect($type = "character",$character->slug,$formatted['slug']);
				
			}
			
		}
		
		//Return
		return $formatted;
		
	}
	
	//FUNC_GUS - Generate unique slug for the character, prevents duplicates! (PRIV)
	private function _generate_unique_slug($name){
		
		//"Slugify" the character's name
		$name = $this->string_manip->slugify($name);
		
		//Get a count of rows that match this title
		$number = $this->db->where('slug',$name)->count_all_results('characters');
		
		//DEBUG
		//echo $number;die;
		
		//If number is greater than 0, check for others and find what upper number to add
		if($number > 0){
			
			//Set flag and counter
			$flag 	= FALSE;
			$cnt 	= 1;
			
			//Loop
			while($flag == FALSE){
				
				//Check for slug with number
				$number = $this->db->where('slug',$name."-".$cnt)->count_all_results('characters');
				
				//If the amount matched is 0, that's the number to use!
				if($number == 0){
					
					//Set flag and title
					$flag 	= TRUE;
					$name 	= $name . "-" . $cnt;
				
				//Matches, so increment to check the next number...
				} else {
					$cnt++;
				}
				
			}
			
		}
		
		//Output the title
		return $name;
		
	}
	
	//FUNC_FCH - Fetch a character
	public function fetch_character($filters = array()){

		//Start query
		$sql = "SELECT * FROM `characters`";
		
		//Add mods array
		$sql_mod = array();
		
		//Add query modifiers
		if(!empty($filters)){
			
			//Load validation library
			$this->load->library('validation');
			
			//Add mods (validates/evaluates input as well in case anything dodgy gets passed in)
			if(isset($filters['name']) && $this->validation->is_alphanumeric($filters['name'],$allowances = array(' ',',','-','.','!','?',"'",':','"'))){
				$sql_mod[] = "`name` = " . $this->db->escape($filters['name']);
			}
			if(isset($filters['characterid']) && ctype_digit((string)$filters['characterid'])){
				$sql_mod[] = "`characterid` = " . $this->db->escape($filters['characterid']);
			}
			if(isset($filters['slug']) && $this->validation->is_alphanumeric($filters['slug'],$allowances = array('_','-'))){
				$sql_mod[] = "`slug` = " . $this->db->escape($filters['slug']);
			}
			if(isset($filters['order']) && ctype_digit((string)$filters['order'])){
				$sql_mod[] = "`character_ordering` = " . $this->db->escape($filters['order']);
			}
			
		}
		
		//Append modifiers to SQL
		if(!empty($sql_mod)){
			$sql .= " WHERE ";
			$sql .= implode(' AND ',$sql_mod);
		}
		
		//No modifiers, get last added character
		if(!isset($filters['characterid']) && !isset($filters['slug'])){
			$sql .= " ORDER BY `characterid` DESC";
		}
		
		//Add limit
		$sql .= " LIMIT 1";
		
		//DEBUG
		//echo $sql . "<br />";//die;
		
		//Run query
		$query = $this->db->query($sql);
		
		//No result
		if($query->num_rows() == 0){
			return FALSE;
		}
		
		//Reassign result
		$result = $query->result();
		$result = $result[0]; //Should only be one result!
		
		//Check profile image file exists...
	
		//Load helper
		$this->load->helper('file');
	
		//Set URL
		$url = "./assets/characters/" . $result->filename;
			
		//Check if exists
		if(!read_file($url)){
			
			//If it doesn't then update the page file reference to NULL
			$this->update_profileimg_file($result->characterid);
			$result->filename = NULL;
			
		}
		
		//Return!
		return $result;
		
	}
	
	//FUNC_FAC - Fetch all characters
	public function fetch_all_characters($reverse = FALSE,$active = FALSE){
		
		//Gets all pages
		$this->db->select('*');
		$this->db->from('characters');
		
		//Only return "active" profiles?
		if($active != FALSE){
			$this->db->where('profile_active','Y');
		}
		
		//Ordering?
		if($reverse == FALSE){
			$this->db->order_by("character_ordering","ASC");
		} else {
			$this->db->order_by("character_ordering","DESC");
		}
		
		$query = $this->db->get();
		
		//DEBUG
		//echo $this->db->last_query();
		
		//Result!
		if($query->num_rows() > 0){

			//Reassign
			$result = $query->result();
			
			//Loop and format excerpt
			//Ref: http://www.ambrosite.com/blog/truncate-long-titles-to-the-nearest-whole-word-using-php-strrpos
			foreach($result as $key => $char){
				if(empty($char->excerpt)){
					$excerpt = strip_tags($char->notes);
					if(strlen($excerpt) > 500){
						$result[$key]->excerpt = substr($excerpt,0,strrpos(substr($excerpt,0,500),' ')) . "...";
					} else {
						$result[$key]->excerpt = $excerpt;
					}
					$result[$key]->excerpt = "<p>" . $result[$key]->excerpt . "</p>";
				}
			}
			
			//Output
			return $result;
			
		}
			
		//No result
		return FALSE;
		
	}
	
	//FUNC_MCO - Detects if characters are missing an order
	public function missing_character_ordering(){
		
		//Set SQL
		$sql = "SELECT * FROM `characters` WHERE `character_ordering` IS NULL";
		
		//DEBUG
		//echo $sql;
		
		//Generate query
		$query = $this->db->query($sql);
		
		//No result = no orders to update!
		if($query->num_rows() == 0){
			return FALSE;
		}
		return TRUE;
		
	}
	
	//FUNC_VPI - Checks that profile images still exist
	public function verify_profileimg_integrity(){
	
		//Get characters
		$characters = $this->fetch_all_characters();
		
		//No pages?
		if(!$characters){
			return FALSE;
		}
		
		//Load helper
		$this->load->helper('file');
		
		//Loop through the pages, test each link
		foreach($characters as $character){
			
			//Skip if not set...
			if($character->filename == NULL){
				continue;
			}
			
			//Set URL
			$url = "./assets/characters/" . $character->filename;
			
			//Check if exists
			if(!read_file($url)){
				
				//If it doesn't then update the page file reference to NULL
				$this->update_profileimg_file($character->characterid);
				
			}
			
		}
		
		//End!
		return TRUE;
		
	}
	
	//FUNC_FMCO - Fetches the maximum character ordering (PRIV)
	private function _fetch_max_character_order(){
		
		//Get the max order number
		$this->db->select_max('character_ordering');
		
		//Fetch!
		$query = $this->db->get('characters');
		
		//No result = no characters!
		if($query->num_rows() == 0){
			return FALSE;
		}
		
		//Reassign result
		$result = $query->result();
		$result = $result[0]; //Should only be one result!
		
		//Return
		return $result->character_ordering;
		
	}
	
	/***** UPDATE *****/
	
	//FUNC_UPD - Update OR insert a character
	public function update($characterid = FALSE,$input,$fields){
		
		//Do some formatting
		$input = $this->_format($input,$fields,$characterid);
		
		//DEBUG
		//print_r($input);die;
		
		//Start sql array
		$sql = $sql_fields = array();
		
		//Insert or update?
		if($characterid == FALSE){
			$sql[] = "INSERT INTO";
		} else {
			$sql[] = "UPDATE";
		}
		
		//Add table
		$sql[] = "`characters` SET";
		
		//Loop and assemble SQL
		foreach($input as $db_fieldname => $value){
			$sql_fields[] = $this->db->protect_identifiers($db_fieldname) . " = " . $this->db->escape($value);
		}
		$sql[] = implode(',',$sql_fields);
		
		//If we're updating, add the id of the page we're updating
		if($characterid != FALSE){
			
			$sql[] = "WHERE `characterid` = " . $this->db->escape($characterid);
		
		//If we're inserting, we need to update the character's order in the page archive
		} else {

			//Fetch last character, add 1 and assign to SQL
			$last_char = $this->_fetch_max_character_order();
			if(!$last_char){ //None, presumably no characters!
				$last_char = 0;
			}
			$sql[] = ", `character_ordering` = " . $this->db->escape($last_char+1);
			
		}
		
		//Assemble SQL
		$sql = implode(' ',$sql);
		
		//DEBUG
		//echo $sql;die;
		
		//Attempt to run - either fail or...
		if(!$this->db->query($sql)){
			
			return FALSE;
		
		} else {
			
			//No ID = return the shiny new page ID
			if($characterid == FALSE){
				
				return $this->db->insert_id();
			
			//ID = update successful
			} else {
			
				return TRUE;
			
			}
			
		}
		
	}
	
	//FUNC_RAC - Reorder chars
	public function reorder_all_characters(){
		
		//Fetch characters, attempt order by
		$sql = "SELECT * FROM (SELECT a.characterid,a.character_ordering FROM `characters` AS a WHERE a.character_ordering IS NOT NULL 
		UNION SELECT b.characterid,b.character_ordering FROM `characters` AS b WHERE b.character_ordering IS NULL) AS t";
		
		//DEBUG
		//echo $sql;
		
		//Generate query
		$query = $this->db->query($sql);
		
		//No result = no chapters to update!
		if($query->num_rows() == 0){
			return FALSE;
		}
		
		//Reassign result
		$character_orders = $query->result();
		
		//Set counter, start at 1
		$counter = 1;
		
		//Loop...
		foreach($character_orders as $chr){
			
			//Update regardless of current setting
			$this->update_character_order($chr->characterid,$counter);
			
			//Increment the counter
			$counter++;
				
		}
		
		//Done!
		return TRUE;
		
	}
	
	//FUNC_UCO - Update a character's order
	public function update_character_order($characterid,$order){
		
		//Form SQL
		$sql = "UPDATE `characters` SET `character_ordering` = " . $this->db->escape($order) . " WHERE `characterid`= " . $this->db->escape($characterid);
		
		//DEBUG
		//echo $sql . "<br />";
		
		//Run
		if(!$this->db->query($sql)){
			return FALSE;
		}
		return TRUE;
		
	}
	
	//FUNC_UPF - Update filepath for a profile img
	//Note that not passing in no filename value wipes the field, ostensibly "deleting" the img
	public function update_profileimg_file($characterid,$filename = NULL){
		
		//Query
		$sql = "UPDATE `characters` SET `filename` = " . $this->db->escape($filename) . " WHERE `characterid`= " . $this->db->escape($characterid);
		
		//Run
		if(!$this->db->query($sql)){
			return FALSE;
		}
		return TRUE;
		
	}
	
	/***** DESTROY *****/
	
	//FUNC_DCH - Delete character from db
	public function delete_character($characterid){
		
		//Set statement
		$this->db->where('characterid', $characterid);
		$this->db->delete('characters');
		
		//Check if run
		if(!$this->db->affected_rows()){
			return FALSE;
		}
		
		//Try removing any page links
		$this->db->where('linkid', $characterid);
		$this->db->where('type', "character");
		$this->db->delete('comic_tags');
		
		//Reorder the characters!
		$this->reorder_all_characters();
		
		return TRUE;
		
	}
	
	
}
