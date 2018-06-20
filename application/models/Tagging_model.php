<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Tagging_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	
	//FUNCTION INDEX - Search a function code to skip to that part of the file
	/* CREATE:
	 * FUNC_ANT 	- Creates a new tag
	 * FUNC_APT 	- Add tags or character links
	 * 
	 * READ:
	 * FUNC_FAT 	- Fetch all tags
	 * FUNC_FTAG 	- Fetch a tag
	 * FUNC_VAL 	- Validate a new tag
	 * FUNC_GUS 	- Generate unique slug for the tag (PRIV)
	 * FUNC_STAG 	- Search db for matching tags
	 * FUNC_FPT 	- Fetch tags for a given page
	 * FUNC_FPTC 	- Grab all page tags, order by tag name
	 * FUNC_FTC 	- Fetch counts for how many times a tag has been used
	 * FUNC_FPBT 	- Fetch pages via a specific tag slug
	 * 
	 * UPDATE:
	 * FUNC_UPTAG 	- Update a tag's label
	 * FUNC_UTLINK 	- Change tag links
	 * 
	 * DESTROY:
	 * FUNC_RTAG 	- Remove a tag
	 * FUNC_DPT 	- Delete tags for a given page
	 */
	 
	/***** CREATE *****/
	
	//FUNC_ANT - Creates a new tag
	public function add_new_tag($tag){
		
		//Create tag slug
		$slug = $this->_generate_unique_slug($tag);
		
		//Form the insert SQL
		$sql = "INSERT INTO `tags` SET `label` = " . $this->db->escape($tag) . ", `slug` = " . $this->db->escape($slug);
		
		//Run
		if(!$this->db->query($sql)){
			return FALSE;
		}
		return $this->db->insert_id();
		
	}
	
	//FUNC_APT - Add tags or character links
	public function add_page_tags($linkids,$pageid,$type = "tag"){
		
		//This operates in a slightly lazy manner by just removing all existing links and then re-adding them
		$this->delete_page_tags($pageid,$type);
		
		//Create new links
		foreach($linkids as $linkid){
			
			//Form the insert SQL
			$sql = "INSERT INTO `comic_tags` SET `linkid` = " . $this->db->escape($linkid) . ", `pageid` = " . $this->db->escape($pageid) . ", 
			`type` = " . $this->db->escape($type);
			
			//DEBUG
			//echo $sql;
			
			//Run
			if(!$this->db->query($sql)){
				continue;
			}
		
		}
		
		//End
		return;
		
	}
	
	/***** READ *****/
	
	//FUNC_FAT - Fetch all tags
	public function fetch_all_tags($cnt = FALSE){
		
		//Gets all pages
		$this->db->select('*, CASE WHEN label LIKE "The %" THEN TRIM(SUBSTR(label FROM 4)) ELSE label END AS label_order');
		$this->db->from('tags');
		$this->db->order_by("label_order","ASC");
		
		$query = $this->db->get();
		
		//DEBUG
		//echo $this->db->last_query();
		
		//Result!
		if($query->num_rows() > 0){
			
			//No count...
			if($cnt == FALSE){

				//...return values
				return $query->result();
				
			}
			
			//Count - reassign, loop, fetch and return
			$result = $query->result();
			foreach($result as $key => $item){
				$result[$key]->usage = $this->fetch_tag_count($item->tagid);
			}
			return $result;
			
		}
			
		//No result
		return FALSE;
		
	}
	
	//FUNC_FTAG - Fetch a tag
	public function fetch_tag($tagid = FALSE,$tag = FALSE,$slug = FALSE){
		
		//Require at least one input!
		if(!$tagid && !$tag && !$slug){
			return FALSE;
		}
		
		//Assemble SQL
		$sql = "SELECT * FROM `tags` WHERE ";
		
		//Apply filters
		$sql_bits = array();
		if($tagid){
			$sql_bits[] = "`tagid` = " . $this->db->escape($tagid);
		}
		if($tag){
			$sql_bits[] = "`label` = " . $this->db->escape($tag);
		}
		if($slug){
			$sql_bits[] = "`slug` = " . $this->db->escape($slug);
		}
		$sql .= implode(' AND ',$sql_bits);
		
		//Apply limit
		$sql .= " LIMIT 1";
		
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
	
	//FUNC_VAL - Validate a new tag
	public function validate($input,$fields){
		
		//Load validation library
		$this->load->library('validation');
		
		//Load characters model
		$this->load->model('Characters_model','Character');

		//Set error array
		$errors = array();
		
		//Check validity of all fields
		foreach($input as $field => $value){
			
			//Remove prefix
			$field = str_ireplace('tags_','',$field);
			
			//Do case by case
			switch($field){
				case "tag":
					
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
						
						//Does it already exist?
						if($this->fetch_tag(FALSE,$value,FALSE) != FALSE){
							$errors[] = $fields[$field]['label'] . " - that tag already exists!";
						}
						
						//Does it already exist as a character?
						if($this->Character->fetch_character($filters = array('name' => $value))){
							$errors[] = $fields[$field]['label'] . " - that tag already exists as a character.";
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
	
	//FUNC_GUS - Generate unique slug for the tag (PRIV)
	private function _generate_unique_slug($tag){
		
		//"Slugify" the character's name
		$tag = $this->string_manip->slugify($tag);
		
		//Get a count of rows that match this title
		$number = $this->db->where('slug',$tag)->count_all_results('tags');
		
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
				$number = $this->db->where('slug',$tag."-".$cnt)->count_all_results('tags');
				
				//If the amount matched is 0, that's the number to use!
				if($number == 0){
					
					//Set flag and title
					$flag 	= TRUE;
					$tag 	= $tag . "-" . $cnt;
				
				//Matches, so increment to check the next number...
				} else {
					$cnt++;
				}
				
			}
			
		}
		
		//Output the title
		return $tag;
		
	}
	
	//FUNC_STAG - Search db for matching tags
	public function search_tags($tag){
		
		//Load validation library
		$this->load->library('validation');
		
		//Don't allow any funny business with the input
		if(!$this->validation->is_alphanumeric($tag,$allowed = array(' ',',','-','.','!','?',"'",':','"'))){
			return FALSE;
		}
		
		//Form query
		$sql = "SELECT * FROM `tags` WHERE `label` LIKE '%" . $this->db->escape_like_str($tag) . "%' ORDER BY label ASC";
		
		//DEBUG
		//echo $sql;
		
		//Run query
		$query = $this->db->query($sql);
		
		//No result
		if($query->num_rows() == 0){
			return FALSE;
		}
		
		//Reassign result
		$result = $query->result();
		
		//Return!
		return $result;
		
	}
	
	//FUNC_FPT - Fetch tags for a given page
	public function fetch_page_tags($pageid,$type = "tag"){
		
		//Handle two types of tags
		switch($type){
			case "character":
				$table 			= "characters";
				$join_field 	= "characterid";
				$order_by		= "character_ordering";
				$fields			= array('name','slug');
			break;
			default:
			case "tag":
				$table 			= "tags";
				$join_field 	= "tagid";
				$order_by		= "label";
				$fields			= array('tagid','label');
			break;
		}
		
		//Join tables together, return results
		$sql = "SELECT tags.*,link.* FROM `comic_tags` AS tags LEFT JOIN " . $this->db->protect_identifiers($table) . " AS link ON 
		tags.`linkid` = link." . $this->db->protect_identifiers($join_field) . " WHERE tags.type = " . $this->db->escape($type) . " 
		AND tags.pageid = " . $this->db->escape($pageid);
		
		//Limit characters to only the "active" ones
		if($type == "character"){
			$sql .= " AND link.profile_active = 'Y'";
		}
		
		$sql .= " ORDER BY " . $this->db->protect_identifiers($order_by);
		
		//DEBUG
		//echo $sql;
		
		//Run query
		$query = $this->db->query($sql);
		
		//No result
		if($query->num_rows() == 0){
			return FALSE;
		}
		
		//Reassign result
		$result = $query->result();
		
		//Loop and format
		$formatted = array();
		foreach($result as $tag){
			
			//Empty tag, assign desired fields
			$tag_details = array();
			foreach($fields as $field){
				$tag_details[$field] = $tag->$field;
			}
			
			//Assign to formatted array using ID as a key
			$formatted[$tag->$join_field] = $tag_details;
			
		}
		
		//DEBUG
		//print_r($formatted);
		
		//Output formatted array
		return $formatted;
		
	}
	
	//FUNC_FPTC - Grab all page tags, order by tag name
	public function fetch_page_tags_collated($pageid){
		
		//Collection array
		$collated = array();
		
		//Get tags
		$tags = $this->fetch_page_tags($pageid,$type = "tag");
		if($tags){
			foreach($tags as $tag){
				$tag = $this->fetch_tag($tag['tagid']);
				if($tag){
					$collated[$tag->label]['slug'] = $tag->slug;
					$collated[$tag->label]['type'] = $type;
				}
			}
		}
		
		//Get characters
		$chars = $this->Tags->fetch_page_tags($pageid,$type = "character");
		if($chars){
			$this->load->model('Characters_model','Character');
			foreach($chars as $char){
				$collated[$char['name']]['slug'] = $char['slug'];
				$collated[$char['name']]['type'] = $type;
			}
		}
		
		//No tags!
		if(empty($collated)){
			return FALSE;
		}
		
		//Faff to get the tags ignoring "the"
		$reorder = array();
		foreach($collated as $label => $tag){
			
			//Only handle if there's spaces
			if(stristr($label,' ')){
				
				//Split up on spaces
				$label_edit = explode(' ',$label);
				
				//If the first word is "the", remove it and reorder the label
				$the = "";
				if(strtolower($label_edit[0]) == "the"){
					unset($label_edit[0]);
					$the = ", The";
				}
				
				//Reassemble
				$label_edit = implode(' ',$label_edit) . $the;
				
				//Assign to array
				$reorder[$label] = $label_edit;
				continue;
				
			}
			
			//Assign to array
			$reorder[$label] = $label;
			
		}
		
		//Now sort the reorder array by keys
		asort($reorder);
		
		//And now we reorder based on this new array!
		$collated_ordered = array();
		foreach($reorder as $tag => $relabel){
			$collated_ordered[$tag] = $collated[$tag];
		}
		
		//DEBUG
		//print_r($reorder);die;
		//print_r($collated);
		
		//All collated!
		return $collated_ordered;
		
	}
	
	//FUNC_FTC - Fetch counts for how many times a tag has been used
	public function fetch_tag_count($tagid){
		
		//Query
		$sql = "SELECT COUNT(*) AS num FROM `comic_tags` WHERE `type` = 'tag' AND linkid = " . $this->db->escape($tagid);
		
		//Run query
		$query = $this->db->query($sql);
		
		//No result
		if($query->num_rows() == 0){
			return 0;
		}
		
		//Reassign result
		$result = $query->result();
		$result = $result[0]; //Should only be one result!
		
		//Return!
		return $result->num;
		
	}
	
	//FUNC_FPBT - Fetch pages via a specific tag slug
	public function fetch_pages_by_tag($slug,$type = "tag"){
	
		//Handle two types of tags
		switch($type){
			case "character":
				$table 			= "characters";
				$join_field 	= "characterid";
			break;
			default:
			case "tag":
				$table 			= "tags";
				$join_field 	= "tagid";
			break;
		}
	
		//Form SQL
		$sql = "SELECT comic.* FROM `comic` LEFT JOIN comic_tags ON comic.comicid = comic_tags.pageid LEFT JOIN " . $this->db->protect_identifiers($table) . " AS link ON 
        comic_tags.linkid = link." . $this->db->protect_identifiers($join_field) . " WHERE comic.filename IS NOT NULL AND link.slug = " . $this->db->escape($slug) . " AND 
        comic_tags.type = " . $this->db->escape($type) . " AND comic.published < " . $this->db->escape(date('Y-m-d H:i:s')) . " ORDER BY comic.page_ordering ASC";
		
		//DEBUG
		//echo $sql;
		
		//Run query
		$query = $this->db->query($sql);
		
		//No result
		if($query->num_rows() == 0){
			return array();
		}
		
		//Reassign result
		$result = $query->result();
		
		//Return!
		return $result;
		
	}
	
	/***** UPDATE *****/
	
	//FUNC_UPTAG - Update a tag's label
	public function update_tag($tagid,$label){
	
		//Some input required!
		if(!$tagid || !$label){
			return FALSE;
		}
		
		//Need to fetch the existing tag
		$tag = $this->Tagging->fetch_tag($tagid);
		
		//Create "slugified" version of tag
		$slug = $this->_generate_unique_slug($label);
		
		//Form update
		$sql = "UPDATE `tags` SET `label` = " . $this->db->escape($label) . ", `slug` = " . $this->db->escape($slug) . " WHERE `tagid` = " . $this->db->escape($tagid);
		
		//Run, end function
		if(!$this->db->query($sql)){
			return FALSE;
		}
		
		//Load redirection model
		$this->load->model('Redirects_model','Redirects');
		
		//Add redirect
		if($tag->slug != $slug){
			$this->Redirects->remove_redirect(FALSE,FALSE,$url = $slug,$type = "tag");
			$this->Redirects->add_new_redirect($type = "tag",$tag->slug,$slug);
			$this->Redirects->update_redirect($type = "tag",$tag->slug,$slug);
		}
		
		//End!
		return TRUE;
		
	}
	
	//FUNC_UTLINK - Change tag links
	public function update_tag_links($new_linkid,$old_linkid,$new_type,$old_type){
		
		//Sanity check
		if(empty($new_linkid) || empty($old_linkid) || empty($new_type) || empty($old_type)){
			return FALSE;
		}
		
		$sql = "UPDATE `comic_tags` SET `linkid` = " . $this->db->escape($new_linkid) . ", `type` = " . $this->db->escape($new_type) . 
		" WHERE `linkid` = " . $this->db->escape($old_linkid) . " AND `type` = " . $this->db->escape($old_type);
		
		//Run, end function
		if(!$this->db->query($sql)){
			return FALSE;
		}
		
		//Success!
		return TRUE;
		
	}
	 
	/***** DESTROY *****/
	 
	//FUNC_RTAG - Remove a tag
	public function remove_tag($tagid){
		
		//Some input required!
		if(!$tagid){
			return FALSE;
		}
		
		//Start sql
		$sql = "DELETE FROM `tags` WHERE `tagid` = " . $this->db->escape($tagid);
		
		//Run, end function
		if(!$this->db->query($sql)){
			return FALSE;
		}
		
		//Try removing any page links
		$this->db->where('linkid', $tagid);
		$this->db->where('type', "tag");
		$this->db->delete('comic_tags');
		
		//Success
		return TRUE;
		
	}
	 
	//FUNC_DPT - Delete tags for a given page
	public function delete_page_tags($pageid,$type = FALSE){
		
		//Form main query
		$sql = "DELETE FROM `comic_tags` WHERE `pageid`= " . $this->db->escape($pageid);
		
		//If type is set, limit query to that type
		if($type != FALSE){
			$sql .= " AND type = " . $this->db->escape($type);
		}
		
		//Run
		$this->db->query($sql);
		return;
		
	}
	 
}
