<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Chapters_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	
	//FUNCTION INDEX - Search a function code to skip to that part of the file
	/* CREATE:
	 * 
	 * READ:
	 * FUNC_VAL 	- Validate chapter details
	 * FUNC_FORM 	- Formats data for db (PRIV)
	 * FUNC_FCH 	- Fetch a chapter (can also return subchapters)
	 * FUNC_FAC 	- Fetch all chapters (main with sub)
	 * FUNC_FAM 	- Fetch all main chapters
	 * FUNC_FAS 	- Fetch all subchapters
	 * FUNC_FMCO 	- Fetch max chapter number (PRIV)
	 * FUNC_MCO 	- Detects if any chapters are missing an order
	 * 
	 * UPDATE:
	 * FUNC_UPD 	- Update OR insert a chapter/subchapter
	 * FUNC_UPO 	- Update a chapter's order
	 * FUNC_RCH 	- Reorder chapters
	 * 
	 * DESTROY:
	 * FUNC_DCH 	- Delete chapter from db
	 */
	
	/***** CREATE *****/
	
	//See FUNC_UPD for creation!
	
	/***** READ *****/

	//FUNC_VAL - Validate chapter details
	public function validate($input,$fields){
		
		//Load validation library
		$this->load->library('validation');

		//Set error array
		$errors = array();
		
		//Check validity of all fields
		foreach($input as $field => $value){
			
			//Remove prefix
			$field = str_ireplace('chapter_','',$field);
			
			//Do case by case
			switch($field){
				case "title":
					
					//Required
					if(!$this->validation->exist_check($value)){
						
						$errors[] = $fields[$field]['label'] . " is required.";
						
					} else {
					
						//Alphanumeric (with allowed punctuation)
						if(!$this->validation->is_alphanumeric($value,$allowed = array(' ',',','-','.','!','?',"'",':','"'))){
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
				case "description":
				
					//Required length?
					if(strlen($value) > $fields[$field]['maxlength']){
						$errors[] = $fields[$field]['label'] . " - must be less than " . $fields[$field]['maxlength'] . " characters in length.";
					}
					
				break;
				case "type":
					
					//Required
					if(!$this->validation->exist_check($value)){
						
						$errors[] = "Chapter type is required.";
						
					} else {
					
						//There are two allowed values
						$allowed_values = array("chapter","subchapter");
						if(!in_array($value,$allowed_values)){
							$errors[] = "Chapter type does not contain a valid value!";
						}
						
					}
					
				break;
				case "masterid": //Only applies to subchapters
					
					//Required
					if(!$this->validation->exist_check($value)){
						
						$errors[] = "Main chapter is required - please select one to link this subchapter to.";
					
					//Need to check if chapter exists...
					} else {
						
						//See in db
						if(!$this->fetch_chapter($filters = array('chapterid' => $value))){
							$errors[] = "The main chapter you have selected does not appear to exist. Oh dear!";
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
	
	//FUNC_FORM - Formats data for db (PRIV)
	private function _format($input,$fields){
		
		//Load string modify library
		$this->load->library('string_manip');
		
		//Create the array to return
		$formatted = array();
		
		//Set values to ignore in the loop...
		$ignores = array("type","masterid");
		
		//Loop through config fields
		foreach($input as $field => $value){
			
			//Remove prefix
			$field_name = str_ireplace('chapter_','',$field);
			
			//Skip certain fields to handle seperately
			if(in_array($field_name,$ignores)){ continue; }
			
			//Do case by case
			switch($field_name){
				case "title":
					
					//Retain special entities
					$value = htmlspecialchars($value);
				
				break;
			}
			
			//Assign to formatted array, assign db field
			$formatted[$fields[$field_name]['db_field']] = $value;
			
		}
		
		//Add type
		$formatted['type'] = $input['chapter_type'];
		
		//Add chapter ID if this is a subchapter
		if($formatted['type'] == "subchapter"){
			$formatted['masterid'] = $input['chapter_masterid'];
		}
		
		//Create a slug
		$formatted['slug'] = $this->string_manip->slugify($input['chapter_title']);
		
		//Return
		return $formatted;
		
	}
	
	//FUNC_FCH - Fetch a chapter (can also return subchapters)
	public function fetch_chapter($filters = array()){

		//Start query
		$sql = "SELECT * FROM `chapters`";
		
		//Add mods array
		$sql_mod = array();
		
		//Add query modifiers
		if(!empty($filters)){
			
			//Load validation library
			$this->load->library('validation');
			
			//Add mods (validates/evaluates input as well in case anything dodgy gets passed in)
			if(isset($filters['type']) && $this->validation->in_valid_range($filters['type'],$range = array('chapter','subchapter'))){
				$sql_mod[] = "`type` = " . $this->db->escape($filters['type']);
			}
			if(isset($filters['chapterid']) && ctype_digit((string)$filters['chapterid'])){
				$sql_mod[] = "`chapterid` = " . $this->db->escape($filters['chapterid']);
			}
			if(isset($filters['main_chapterid']) && ctype_digit((string)$filters['main_chapterid'])){
				$sql_mod[] = "`masterid` = " . $this->db->escape($filters['main_chapterid']);
			}
			if(isset($filters['slug']) && $this->validation->is_alphanumeric($filters['slug'],$allowances = array('_','-'))){
				$sql_mod[] = "`slug` = " . $this->db->escape($filters['slug']);
			}
			if(isset($filters['order']) && ctype_digit((string)$filters['order'])){
				$sql_mod[] = "`chapter_ordering` = " . $this->db->escape($filters['order']);
			}
				
		}
		
		//Append modifiers to SQL
		if(!empty($sql_mod)){
			$sql .= " WHERE ";
			$sql .= implode(' AND ',$sql_mod);
		}
		
		//No modifiers, get last chapter
		if(!isset($filters['chapterid']) && !isset($filters['slug'])){
			$sql .= " ORDER BY `chapter_ordering` DESC"; 
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
		
		//Return!
		return $result;
		
	}
	
	//FUNC_FAC - Fetch all chapters (main with sub)
	public function fetch_all_chapters($reverse = FALSE,$subreverse = TRUE){
		
		//Fetch the chapters
		$chapters = $this->fetch_all_main_chapters($reverse);
		
		//Fail if no chapters!
		if(!$chapters){
			return FALSE;
		}
		
		//Loop
		foreach($chapters as $chapter){
			
			//Assign subchapters to a new node
			$subchapters = $this->fetch_all_subchapters($chapter->chapterid,$subreverse);
			
			//Assign if exist
			if($subchapters){
				$chapter->subchapters = $subchapters;
			}
			
		}
		
		//DEBUG
		//print_r($chapters);die;
		
		//Return all chapters!
		return $chapters;
		
	}
	
	//FUNC_FAM - Fetch all main chapters
	public function fetch_all_main_chapters($reverse = FALSE){
		
		//Gets all pages
		$this->db->select('*');
		$this->db->from('chapters');
		$this->db->where('type','chapter');
		
		//Ordering?
		if($reverse == FALSE){
			$this->db->order_by("chapter_ordering","DESC");
		} else {
			$this->db->order_by("chapter_ordering","ASC");
		}
		
		$query = $this->db->get();
		
		//DEBUG
		//echo $this->db->last_query();
		
		//Result!
		if($query->num_rows() > 0){

			//Return values
			return $query->result();
			
		}
			
		//No result
		return FALSE;
		
	}
	
	//FUNC_FAS - Fetch all subchapters
	public function fetch_all_subchapters($chapterid,$reverse = FALSE){
		
		//Gets all pages
		$this->db->select('*');
		$this->db->from('chapters');
		$this->db->where('type','subchapter');
		$this->db->where('masterid',$chapterid);
		
		//Ordering?
		if($reverse == FALSE){
			$this->db->order_by("chapter_ordering","DESC");
		} else {
			$this->db->order_by("chapter_ordering","ASC");
		}
		
		$query = $this->db->get();
		
		//DEBUG
		//echo $this->db->last_query();
		
		//Result!
		if($query->num_rows() > 0){

			//Return values
			return $query->result();
			
		}
			
		//No result
		return FALSE;
		
	}
	
	//FUNC_FMCO - Fetch max chapter number (PRIV)
	private function _fetch_max_chapter_order($chapterid = FALSE){
		
		//NOTE - Passing in a chapterid automatically sets the system to look for a subchapter

		//Get the max order number
		$this->db->select_max('chapter_ordering');
		
		//Modify query based on whether we want chapter or subchapter
		if($chapterid == FALSE){
			$this->db->where('type','chapter');
		} else {
			$this->db->where('type','subchapter');
			$this->db->where('masterid',$chapterid);
		}
		
		//Fetch!
		$query = $this->db->get('chapters');
		
		//No result = no chapters
		if($query->num_rows() == 0){
			return FALSE;
		}
		
		//Reassign result
		$result = $query->result();
		$result = $result[0]; //Should only be one result!
		
		//Return
		return $result->chapter_ordering;
		
	}
	
	//FUNC_MCO - Detects if any chapters are missing an order
	public function missing_chapter_ordering(){
		
		//Set SQL
		$sql = "SELECT * FROM `chapters` WHERE `chapter_ordering` IS NULL";
		
		//DEBUG
		//echo $sql;
		
		//Generate query
		$query = $this->db->query($sql);
		
		//No result = no chapters to update!
		if($query->num_rows() == 0){
			return FALSE;
		}
		return TRUE;
		
	}
	
	/***** UPDATE *****/
	
	//FUNC_UPD - Update OR insert a chapter/subchapter
	public function update($chapterid = FALSE,$input,$fields){
		
		//Do some formatting
		$input = $this->_format($input,$fields);
		
		//DEBUG
		//print_r($input);die;
		
		//Start sql array
		$sql = $sql_fields = array();
		
		//Insert or update?
		if($chapterid == FALSE){
			$sql[] = "INSERT INTO";
		} else {
			$sql[] = "UPDATE";
		}
		
		//Add table
		$sql[] = "`chapters` SET";
		
		//Loop and assemble SQL
		foreach($input as $db_fieldname => $value){
			$sql_fields[] = $this->db->protect_identifiers($db_fieldname) . " = " . $this->db->escape($value);
		}
		$sql[] = implode(',',$sql_fields);
		
		//If we're updating, add the id of the page we're updating
		if($chapterid != FALSE){
			
			$sql[] = "WHERE `chapterid` = " . $this->db->escape($chapterid);
		
		//If we're inserting, we need to update the page order
		} else {
		
			//Set chapter id
			$chapterid = FALSE;
			if(isset($input['masterid'])){
				$chapterid = $input['masterid'];
			}
		
			//Fetch last page, add 1 and assign to SQL
			$last_chapter = $this->_fetch_max_chapter_order($chapterid);
			if(!$last_chapter){ //None, presumably no chapters!
				$last_chapter = 0;
			}
			$sql[] = ", `chapter_ordering` = " . $this->db->escape($last_chapter+1);
			
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
			if($chapterid == FALSE){
				
				return $this->db->insert_id();
			
			//ID = update successful
			} else {
			
				return TRUE;
			
			}
			
		}
		
	}
	
	//FUNC_UPO - Update a chapter's order
	public function update_chapter_order($chapterid,$order){
		
		//Form SQL
		$sql = "UPDATE `chapters` SET `chapter_ordering` = " . $this->db->escape($order) . " WHERE `chapterid`= " . $this->db->escape($chapterid);
		
		//DEBUG
		//echo $sql . "<br />";
		
		//Run
		if(!$this->db->query($sql)){
			return FALSE;
		}
		return TRUE;
		
	}
	
	//FUNC_RCH - Reorder chapters
	public function reorder_all_chapters(){
		
		//Convoluted looking SQL! All it does is...
		//Join chapters and subchapters together based on masterid, giving all fields new aliases
		//Union a query to fetch all chapters with no subchapters
		//Aliases the lot to "t" so we can then order the results from the previous two
		$sql = "SELECT t.* FROM (SELECT chap.chapterid AS main_chapter_id,chap.name AS main_chapter_name,chap.slug AS main_chapter_slug,chap.description AS
		main_chapter_description,sub.chapterid AS sub_chapter_id,sub.name AS sub_chapter_name,sub.slug AS sub_chapter_slug,sub.description AS
		sub_chapter_description, chap.chapter_ordering AS main_chapter_ordering,sub.chapter_ordering AS sub_chapter_ordering FROM chapters AS chap
		LEFT JOIN chapters AS sub ON chap.chapterid = sub.masterid WHERE chap.type = 'chapter' AND sub.type = 'subchapter' UNION SELECT chapterid
		AS main_chapter_id,name AS main_chapter_name, slug AS main_chapter_slug,description AS main_chapter_description,NULL,NULL,NULL,NULL,chapter_ordering,
		NULL FROM chapters WHERE type = 'chapter' AND chapterid NOT IN(SELECT DISTINCT masterid FROM chapters WHERE masterid IS NOT NULL)) AS t ORDER BY
		main_chapter_ordering,main_chapter_id,sub_chapter_ordering,sub_chapter_id";
		
		//DEBUG
		//echo $sql;
		
		//Generate query
		$query = $this->db->query($sql);
		
		//No result = no chapters to update!
		if($query->num_rows() == 0){
			return FALSE;
		}
		
		//Reassign result
		$chapters_raw = $query->result();
		
		//Create an array for us to reassign to
		$chapters = array();
		
		//Loop and format into a new array
		foreach($chapters_raw as $row){
			
			//See if main chapter ID is in array, add if required
			if(!array_key_exists($row->main_chapter_ordering,$chapters)){
				
				//DEBUG
				//echo "NOT IN ARRAY<br />";
				
				//Add to array
				$chapters[$row->main_chapter_ordering] = array(
					'id'			=> $row->main_chapter_id,
					'name'			=> $row->main_chapter_name,
					'slug'			=> $row->main_chapter_slug,
					'description'	=> $row->main_chapter_description,
					'subchapters'	=> array()
				);

			}
			
			//If NULL, no subchapters...continue!
			if($row->sub_chapter_id == NULL){
				continue;
			}
			
			//Add subchapter to array
			$chapters[$row->main_chapter_ordering]['subchapters'][$row->sub_chapter_ordering] = array(
				'id'			=> $row->sub_chapter_id,
				'name'			=> $row->sub_chapter_name,
				'slug'			=> $row->sub_chapter_slug,
				'description'	=> $row->sub_chapter_description
			);
			
			//DEBUG
			//print_r($chapters);echo "<br />";
			
		}
		
		//Sanity check
		if(empty($chapters)){
			return FALSE;
		}
		
		//DEBUG
		//print_r($chapters);//die;
		
		//Create a copy of the array, create new array
		$reorder_chapters = $chapters;
		$reordered = array();
		
		//First reorder main keys - the odd functions reorder keys from 1, no 0 like array_values does!
		//Ref: http://stackoverflow.com/questions/12715514/how-to-increase-by-1-all-keys-in-an-array
		$reorder_chapters = array_combine(range(1,count($reorder_chapters)),array_values($reorder_chapters));
		
		//Now loop and reorder subchapter keys
		foreach($reorder_chapters as $order => $details){
			
			//Only loop the subchapters if there are any!
			if(!empty($details['subchapters'])){
				$reorder_chapters[$order]['subchapters'] = array_combine(range(1,count($reorder_chapters[$order]['subchapters'])),array_values($reorder_chapters[$order]['subchapters']));
			}
			
		}
		
		//DEBUG
		//echo "<hr />";print_r($reorder_chapters);echo "<hr />";die;
		
		//Compare - if identical, nothing to do!
		if($chapters === $reorder_chapters){
			return TRUE;
		}
		
		//Loop through the reordered chapters
		foreach($reorder_chapters as $order => $details){
			
			//print_r($details);
			//echo $details['id'] . "<br />";
			
			//Update chapter order
			$this->update_chapter_order($details['id'],$order);
			
			//If subchapter...
			if(!empty($details['subchapters'])){
				
				//...loop and update subchapter orders
				foreach($details['subchapters'] as $suborder => $subdetails){
					
					//Update subchapter order
					$this->update_chapter_order($subdetails['id'],$suborder);
					
				}
				
			}
			
		}
		
		//Done!
		return TRUE;
		
	}
	
	/***** DESTROY *****/
	
	//FUNC_DCH - Delete chapter from db
	public function delete_chapter($chapterid){
		
		//Set statement
		$this->db->where('chapterid', $chapterid);
		$this->db->delete('chapters');
		
		//Check if run
		if(!$this->db->affected_rows()){
			return FALSE;
		}
		
		//Reorder the chapters!
		$this->reorder_all_chapters();
		
		return TRUE;
		
	}
	
	
}
