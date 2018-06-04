<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	
	//FUNCTION INDEX - Search a function code to skip to that part of the file
	/* CREATE:
	 * FUNC_DSV 	- Create default rows in the settings table
	 * FUNC_DNV 	- Create default rows in the navigation table
	 * 
	 * READ:
	 * FUNC_FSV 	- Fetches all site values
	 * FUNC_FSN 	- Fetches all site navigation values
	 * FUNC_FSI 	- Get a setting ID by its label
	 * FUNC_FNSI 	- Get a navigation setting ID by its label
	 * FUNC_FSSN 	- Fetches the site nav options, but ordered according to "top" or "bottom"
	 * FUNC_VALSET 	- Validate site values
	 * FUNC_VALNAV 	- Validate nav values
	 * 
	 * UPDATE:
	 * FUNC_UPDS 	- Update website settings
	 * FUNC_UPDN 	- Update website navigation
	 * 
	 * DESTROY:
	 */
	
	/***** CREATE *****/
	
	//FUNC_DSV - Create default rows in the settings table
    private function _default_site_values($check = FALSE){
		
		//Load Webcomic settings config
		$this->load->config('webcomic',TRUE);
		$settings = $this->config->item('comic_settings','webcomic');
		
		//Loop through config, assign array values
		$insertions = array();
		foreach($settings as $item => $setting){
			
			//Setup default values
			$insertions[] = array(
				'label' => str_ireplace('site_','',$setting['db_field']),
				'value' => $setting['default_val']
			);
			
		}
		
		//Insert values into the table
		foreach($insertions as $insertion){
			
			//Doing a db repair jobby
			if($check != FALSE){
				
				//Attempt to fetch value - if evaluates as "FALSE" it's missing!
				$value = $this->fetch_site_values($insertion['label']);
				if($value !== FALSE){ continue; }
				
			}
			
			//Run insert
			$this->db->insert('settings',$insertion);
		
		}
		
		//If we get this far, the process was a success
		return TRUE;
		
	}
	
	//FUNC_DNV - Create default rows in the navigation table
    private function _default_nav_values($check = FALSE){
		
		//Load Webcomic nav config
		$this->load->config('webcomic',TRUE);
		$nav_settings = $this->config->item('comic_nav','webcomic');
		
		//Loop through config, assign array values
		$insertions = array();
		foreach($nav_settings['options'] as $item => $nav){
			
			//Setup default values
			$insertions[] = array(
				'label' => $item,
				'value' => $nav['default']
			);
			
		}
		
		//Insert values into the table
		foreach($insertions as $insertion){
			
			//Doing a db repair jobby
			if($check != FALSE){
				$value = $this->fetch_site_nav($insertion['label']);
				if($value){ continue; }
			}
			
			//Run insert
			$this->db->insert('navigation',$insertion);
		
		}
		
		//If we get this far, the process was a success
		return TRUE;
		
	}
	
	/***** READ *****/
	
	//FUNC_FSV - Fetches all site values
    public function fetch_site_values($field = FALSE){

		//Field filter
		if($field != FALSE){
			
			//Fetch query by label
			$query = $this->db->get_where('settings', array('label' => $field), 1);
		
			//A result
			if($query->num_rows() > 0){
				$result = $query->result();
				return $result[0]->value;
			}
			
			//No result!
			return FALSE;
		
		//All fields
		} else {
		
			//Running this with flag set "repairs" db by filling in missing fields
			$this->_default_site_values($check = TRUE);
		
			//Gets all settings
			$query = $this->db->get('settings');
		
			//A result
			if($query->num_rows() > 0){
				
				//Create array to return
				$values = array();
				
				//Loop and assign
				foreach($query->result() as $result){
					$values['site_' . $result->label] = $result->value;
				}
				
				//DEBUG
				//print_r($values);
				
				//Return values
				return $values;
				
			//No result - create default row!
			} else {
				
				//Create values
				$this->_default_site_values();
				
				//Recursively use this function to return values we've just populated!
				$values = $this->fetch_site_values();
				return $values;
				
			}
			
		}
		
	}
	
	//FUNC_FESV - Fetches extra site values not covererd
	public function fetch_tertiary_site_values($values = FALSE){
		
		//Default = output a fresh array
		if(!$values){
			$values = array();
		}
		
		//Fetch favicon
		$custom_locations = $this->config->item('custom_file_paths','webcomic');
		$custom_locations = $custom_locations['favicon'];
		foreach($custom_locations as $location){
			if(file_exists($location)){
				$values['favicon'] = base_url() . ltrim($location,'./');
			}
		}
		
		//About page
		$values['about'] = $this->Comic->fetch_about_page($this->config->item('about','webcomic'));
		if($values['about'] != FALSE){
			$values['about'] = TRUE;
		}
		
		//Archive page
		$this->load->model('Comic_model','Comic');
		$values['archive'] = $this->Comic->fetch_all_pages(FALSE,FALSE,TRUE);
		if($values['archive'] != FALSE){
			$values['archive'] = TRUE;
		}
		
		//Characters page
		$this->load->model('Characters_model','Chars');
		$values['characters'] = $this->Chars->fetch_all_characters(FALSE,TRUE);
		if($values['characters'] != FALSE){
			$values['characters'] = TRUE;
		}
		
		//Return updated values
		return $values;
		
	}
	
	//FUNC_FSN - Fetches all site navigation values
    public function fetch_site_nav($field = FALSE){

		//Field filter
		if($field != FALSE){
			
			//Fetch query by label
			$query = $this->db->get_where('navigation', array('label' => $field), 1);
		
			//A result
			if($query->num_rows() > 0){
				$result = $query->result();
				return $result[0]->value;
			}
			
			//No result!
			return FALSE;
		
		//All fields
		} else {
		
			//Running this with flag set "repairs" db by filling in missing fields
			$this->_default_nav_values($check = TRUE);
		
			//Gets all settings
			$query = $this->db->get('navigation');
		
			//A result
			if($query->num_rows() > 0){
				
				//Create array to return
				$values = array();
				
				//Loop and assign
				foreach($query->result() as $result){
					$values['nav_' . $result->label] = $result->value;
				}
				
				//DEBUG
				//print_r($values);
				
				//Return values
				return $values;
				
			//No result - create default row!
			} else {
				
				//Create values
				$this->_default_nav_values();
				
				//Recursively use this function to return values we've just populated!
				$values = $this->fetch_nav_values();
				return $values;
				
			}
			
		}
		
	}
	
	//FUNC_FSSN - Fetches the site nav options, but ordered according to "top" or "bottom"
	public function fetch_structured_site_nav(){
		
		//Get the disorganised version
		$settings = $this->fetch_site_nav();
		
		//Create a format array, loop and assign
		$format = array();
		foreach($settings as $option => $placement){
			$format[$placement][] = str_ireplace('nav_','',$option);
		}
		
		//"Both" is not a placement, so convert those
		if(!empty($format['both'])){
			foreach($format['both'] as $option){
				$format['top'][] = $format['bottom'][] = $option;
				unset($format['both']);
			}
		}
		
		//"Neither" is also not a placement...
		unset($format['neither']);
		
		//We do want "top" and "bottom" even if they're empty...
		$wanted = array('top','bottom');
		foreach($wanted as $want){
			if(!isset($format[$want])){ $format[$want] = array(); }
		}
		
		//Finally, we want to collate a string of which nav extras we've got
		foreach($format as $placement => $options){
			if(!empty($options)){
				foreach($options as $option){
					$format['all'][] = $option;
				}
			}
		}
		$format['all'] = array_unique($format['all']);
		
		//DEBUG
		//print_r($format);
		
		//Output formatted array
		return $format;
	
	}
	
	//FUNC_FSI - Get a setting ID by its label
	private function _fetch_setting_id($label){
		
		//Label required
		if(!$label){
			return FALSE;
		}
		
		//Generate query
		$query = $this->db->get_where('settings', array('label' => $label), $limit = 1);
		
		//No result
		if($query->num_rows() == 0){
			return FALSE;
		}
		
		//Return result
		$result = $query->result();
		return $result[0]->id; //Should only be one result
		
	}
	
	//FUNC_FNSI - Get a navigation setting ID by its label
	private function _fetch_nav_setting_id($label){
		
		//Label required
		if(!$label){
			return FALSE;
		}
		
		//Generate query
		$query = $this->db->get_where('navigation', array('label' => $label), $limit = 1);
		
		//No result
		if($query->num_rows() == 0){
			return FALSE;
		}
		
		//Return result
		$result = $query->result();
		return $result[0]->id; //Should only be one result
		
	}
	
	//FUNC_VALSET - Validate site values
	public function validate($input,$fields){
		
		//Load validation library
		$this->load->library('validation');

		//Set error array
		$errors = array();
		
		/*	Example array, may include more values...
			Array(
				[ste_title] 		=> My Webcomic
				[ste_slogan] 		=> The funniest webcomic ever!
				[ste_updates-on] 	=> regularly
			)
		*/
		
		//Check validity of all fields
		foreach($input as $field => $value){
			
			//Remove prefix
			$field = str_replace('ste_','',$field);
			
			//Do case by case
			switch($field){
				default:
					
					//Required
					if($fields[$field]['required'] == TRUE && !$this->validation->exist_check($value)){
						
						$errors[] = $fields[$field]['label'] . " is required.";
						
					} else {
					
						//Alphanumeric (with allowed punctuation)
						if(!$this->validation->is_alphanumeric($value,$allowed = array(' ','-','.','!','?',"'"))){
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
				case "comments":
					
					//Not required, but check if it has been set
					if($this->validation->exist_check($value)){
						
						//Alphanumeric
						if(!$this->validation->is_alphanumeric($value,$allow=array('-'))){
							$errors[] = $fields[$field]['label'] . " - letters, numbers and dashes only.";
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
				case "date_format":
				case "rss_number_items":
				case "rss_format":
				case "archive_list_style":
					
					//Required
					if($fields[$field]['required'] == TRUE && !$this->validation->exist_check($value)){
						
						$errors[] = $fields[$field]['label'] . " is required.";
					
					//Should be one of the preset options
					} else {
					
						if(!$this->validation->in_valid_range($value,$fields[$field]['options'])){
							$errors[] = $fields[$field]['label'] . " - is not a valid " . strtolower($fields[$field]['label']) . " value!";
						}
					
					}
					
				break;
				case "webby":
				case "character_excerpt":
					
					//If the checkbox is set, it should be set to "Yes"
					if($this->validation->exist_check($value)){
						if(!$this->validation->in_valid_range($value,$range = array('Yes','No'))){
							$errors[] = $fields[$field]['label'] . " - should be 'Yes' or 'No'!";
						}
					}
					
				break;
			}
			
		}
		
		//DEBUG
		//print_r($errors);die;
		
		//Return errors
		return $errors;
		
	}
	
	//FUNC_VALNAV - Validate nav values
	public function validate_nav($input,$fields){
		
		//Load validation library
		$this->load->library('validation');

		//Set error array
		$errors = array();
		
		//DEBUG
		//print_r($fields);
		
		//Check validity of all fields
		foreach($input as $field => $value){
			
			//Remove prefix
			$field = str_replace('nav_','',$field);
			
			//If the checkbox is set, it should be set to "Yes"
			if($this->validation->exist_check($value)){
				if(!$this->validation->in_valid_range($value,$fields['placements'])){
					$errors[] = $fields['options'][$field]['label'] . " - should be one of the following values: '" . implode("', '",$fields['placements']) . "'";
				}
			}
		
		}
		
		//DEBUG
		//print_r($errors);die;
		
		//Return errors
		return $errors;
		
	}
	
	/***** UPDATE *****/
	
	//FUNC_UPDS - Update website settings
	public function update($input,$fields){
		
		//Set update array
		$update = array();
		
		//Check validity of all fields
		foreach($input as $field => $value){
			
			//Remove prefix
			$field = str_replace('ste_','',$field);
			
			//Get field db label from config array
			$label = str_ireplace('site_','',$fields[$field]['db_field']);
			
			//Get the ID of the element
			$id = $this->_fetch_setting_id($label); //Fetches ID by label
			
			//DEBUG
			//print_r($id);die;
			
			//ID found
			if($id != FALSE){
				
				//Add value to update array
				$update = array('value' => $value);
				
				//Set ID, run update
				$this->db->where('id',$id);
				$this->db->update('settings',$update); 
			
			//No ID = insert the field
			} else {
				
				//Set insertion array
				$insertion = array(
					'label' => $label,
					'value'	=> $value
				);
				
				//Run insert
				$this->db->insert('settings',$insertion);
				
			}
			
		}
		
		//Get this far = success
		return TRUE;
		
	}
	
	//FUNC_UPDN - Update website navigation
	public function update_nav($input,$fields){
		
		//Set update array
		$update = array();
		
		//Check validity of all fields
		foreach($input as $field => $value){
			
			//Remove prefix
			$field = str_replace('nav_','',$field);
			
			//Get field db label from config array
			$label = array_search($fields['options'][$field],$fields['options']);
			
			//DEBUG
			//print_r($label);
			
			//Get the ID of the element
			$id = $this->_fetch_nav_setting_id($label); //Fetches ID by label
			
			//DEBUG
			//echo "ID: ";print_r($id);die;
			
			//ID found
			if($id != FALSE){
				
				//Add value to update array
				$update = array('value' => $value);
				
				//Set ID, run update
				$this->db->where('id',$id);
				$this->db->update('navigation',$update); 
			
			//No ID = insert the field
			} else {
				
				//Set insertion array
				$insertion = array(
					'label' => $label,
					'value'	=> $value
				);
				
				//Run insert
				$this->db->insert('navigation',$insertion);
				
			}
			
		}
		
		//Get this far = success
		return TRUE;
		
	}
	
	/***** DESTROY *****/
	
}
