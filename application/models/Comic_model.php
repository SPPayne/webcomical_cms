<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Comic_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	
	//FUNCTION INDEX - Search a function code to skip to that part of the file
	/* CREATE:
	 * 
	 * READ:
	 * FUNC_VALCOM 		- Validate comic page details
	 * FUNC_VALABO 		- Validate about page details
	 * FUNC_FORM 		- Formats comic page data for db (PRIV)
	 * FUNC_FRMABO 		- Formats data for db for about page (PRIV)
	 * FUNC_GUS 		- Generate unique slug for the page (PRIV)
	 * FUNC_FP 			- Fetch a comic page, returns most recent by default
	 * FUNC_FAP 		- Fetch all comic pages, optionally by chapter
	 * FUNC_FVPIO 		- Fetches all pages, verifies that corresponding page files exist
	 * FUNC_FPN 		- Fetches pages for comic navigation
	 * FUNC_FNSP 		- Find next page in sequence, up or down (PRIV)
	 * FUNC_FMPO 		- Fetch max page number
	 * FUNC_MPO 		- Detects if comic pages are missing an order
	 * FUNC_SEARCH  	- Search comic archive for a specific term
	 * FUNC_ABOUT 		- Fetch about page details (if any!)
	 * FUNC_PROCOMTEMP 	- Process a custom template for the comic page
	 * FUNC_PROABTTEMP	- Process a custom template for the about page
	 * FUNC_PROARCTEMP 	- Process a custom template for the archive page
	 * 
	 * UPDATE:
	 * FUNC_UPD 	- Update OR insert a comic page
	 * FUNC_UPF 	- Update file for a page
	 * FUNC_UPO 	- Update a page's order
	 * FUNC_UPC 	- Update a page's chapter
	 * FUNC_SDO 	- Default ordering for comic
	 * FUNC_UPABPG 	- Update (or create) the "about" page
	 * 
	 * DESTROY:
	 * FUNC_DP 		- Delete page from db
	 */
	
	/***** CREATE *****/
	
	//See FUNC_UPD for creation!
	
	/***** READ *****/
	
	//FUNC_VALCOM - Validate comic page details
	public function validate($input,$fields){
		
		//Load validation library
		$this->load->library('validation');

		//Set error array
		$errors = array();
		
		//Check validity of all fields
		foreach($input as $field => $value){
			
			//Remove prefix
			$field = str_ireplace('comic_','',$field);
			
			//Do case by case
			switch($field){
				case "title":
					
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
					
					}
					
				break;
				case "hover-over":
				case "excerpt":
					
					//Only validate if there's a value
					if($this->validation->exist_check($value)){
						
						//Alphanumeric (with allowed punctuation)
						if(!$this->validation->is_alphanumeric($value,$allowed = array(' ',',','-','.','!','?',"'",':','"','(',')'))){
							$errors[] = $fields[$field]['label'] . " - letters, numbers, limited punctuation and spaces only.";
						}
						
						//Required length?
						if(strlen($value) > $fields[$field]['maxlength']){
							$errors[] = $fields[$field]['label'] . " - must be less than " . $fields[$field]['maxlength'] . " characters in length.";
						}
						
					}
				
				break;
				case "transcript":
				case "blog":
				
					//Required length?
					if(strlen($value) > $fields[$field]['maxlength']){
						$errors[] = $fields[$field]['label'] . " - must be less than " . $fields[$field]['maxlength'] . " characters in length.";
					}
					
				break;
				case "schedule":
					
					//Required
					if(!$this->validation->exist_check($value)){
						
						$errors[] = $fields[$field]['label'] . " is required.";
						
					} else {
					
						//Valid date?
						if(!$this->validation->is_valid_datetime($value)){
							$errors[] = $fields[$field]['label'] . " does not contain a valid date.";
						}
					
					}
				
				break;
				case "chapter":
					
					//Not required, but check for...
					if($this->validation->exist_check($value)){
					
						//Needs to be a number
						if(!ctype_digit($value)){
							$errors[] = "Chapter ID is not valid.";
						}
						
						//Get chapter model, check if the chapter exists!
						$this->load->model('Chapters_model','Chapters');
						if(!$this->Chapters->fetch_chapter($filters = array('chapterid' => $value))){
							$errors[] = "Chapter selected does not exist!";
						}
						
					}
					
				break;
				case "characters":
				case "tags":
					
					//Check for array
					if(!is_array($value)){
						
						//Not an array!
						$errors[] = ucfirst($field) . " values are not expected input.";
						
					} else {
						
						//Set exist flag
						$all_exist = TRUE;
						
						//Character checks
						if($field == "characters"){
						
							//Get character model, check characters exist!
							$this->load->model('Characters_model','Characters');
							foreach($value as $characterid){
								if(!ctype_digit($characterid) || !$this->Characters->fetch_character($filters = array('characterid' => $characterid))){
									$all_exist = FALSE;
								}
							}
							
						}
						
						//Tag checks
						if($field == "tags"){
							
							//Get tags model, tags exist!
							$this->load->model('Tagging_model','Tags');
							foreach($value as $tagid){
								if(!ctype_digit($tagid) || !$this->Tags->fetch_tag($tagid)){
									$all_exist = FALSE;
								}
							}
							
						}
						
						//Has flag changed?
						if($all_exist == FALSE){
							$errors[] = "One of the selected " . $field . " does not exist!";
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
	
	//FUNC_VALABO - Validate about page details
	public function validate_about($input,$fields){
		
		//Load validation library
		$this->load->library('validation');

		//Set error array
		$errors = array();
		
		//Check validity of all fields
		foreach($input as $field => $value){
			
			//Remove prefix
			$field = str_ireplace('about_','',$field);
			
			//Do case by case
			switch($field){
				case "title":
					
					//Required
					if($this->validation->exist_check($value)){
					
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
					
					}
					
				break;
				case "about":
				
					//Required length?
					if(strlen($value) > $fields[$field]['maxlength']){
						$errors[] = $fields[$field]['label'] . " - must be less than " . $fields[$field]['maxlength'] . " characters in length.";
					}
					
				break;
			}
			
		}
		
		//DEBUG
		//echo "Error: "; print_r($input);
		
		//Return errors
		return $errors;
		
	}
	
	//FUNC_FORM - Formats comic page data for db (PRIV)
	private function _format($input,$fields,$update){
		
		//DEBUG
		//print_r($input);
		
		//Load string modify and validations libraries
		$this->load->library('string_manip');
		$this->load->library('validation');
		
		//Create the array to return
		$formatted = array();
		
		//Loop through config fields
		foreach($input as $field => $value){
			
			//Remove prefix
			$field_name = str_ireplace('comic_','',$field);
			
			//Handle chapters/characters seperately
			if($field_name == "chapter" || $field_name == "characters" || $field_name == "tags"){
				continue;
			}
			
			//Do case by case
			switch($field_name){
				case "title":
				case "hover-over":
				case "excerpt":
					
					//No hover-over = use title instead
					if($field_name == "hover-over" && !$this->validation->exist_check($value)){
						$value = $input['comic_title'];
					}
					
					//Retain special entities
					$value = htmlspecialchars($value);
				
				break;
				case "schedule":
					
					//Convert to timestamp
					$value = $this->string_manip->create_timestamp($value);
				
				break;
			}
			
			//Assign to formatted array, assign db field
			$formatted[$fields[$field_name]['db_field']] = $value;
			
		}
		
		//Three specialist fields to process and reassign
		$special_fields = array(
			"chapterid" 	=> "comic_chapter",
			"characters"	=> "comic_characters",
			"tags"			=> "comic_tags"
		);
		foreach($special_fields as $reassign => $current_field){
			if(isset($input[$current_field]) && $this->validation->exist_check($input[$current_field])){
				$formatted[$reassign] = $input[$current_field];
			}
		}
		
		//No chapters = set to NULL
		if(!isset($formatted['chapterid'])){
			$formatted['chapterid'] = NULL;
		}
		
		//Load redirection model
		$this->load->model('Redirects_model','Redirects');
		
		//Create a slug (if a new record)
		if($update == FALSE){
			
			//Generate a unique slug
			$formatted['slug'] = $this->_generate_unique_slug($input['comic_title']);
			
			//Remove any redirects that contain the new slug (new page will "adopt" that old slug)
			$this->Redirects->remove_redirect(FALSE,FALSE,$url = $formatted['slug']);
			
		//Updating record...
		} else {
			
			//First fetch the existing record
			$page = $this->fetch_page($filters = array('pageid' => $update));
			
			//Only run the slug generation if the title has changed!
			if($page->name != $input['comic_title']){
				
				//Assign generated slug
				$formatted['slug'] = $this->_generate_unique_slug($input['comic_title']);

				//Add a new redirect and update any existing ones to the new one
				$this->Redirects->remove_redirect(FALSE,FALSE,$formatted['slug']);
				$this->Redirects->add_new_redirect($type = "comic",$page->slug,$formatted['slug']);
				$this->Redirects->update_redirect($type = "comic",$page->slug,$formatted['slug']);
				
			}
			
		}
		
		//DEBUG
		//print_r($formatted);die;
		
		//Return
		return $formatted;
		
	}
	
	//FUNC_FRMABO - Formats data for db for about page (PRIV)
	private function _format_about($input,$fields){
		
		//Load string modify and validations libraries
		$this->load->library('string_manip');
		$this->load->library('validation');
		
		//Create the array to return
		$formatted = array();
		
		//Loop through config fields
		foreach($input as $field => $value){
			
			//Remove prefix
			$field_name = str_ireplace('about_','',$field);
			
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
		
		//DEBUG
		//print_r($formatted);die;
		
		//Return
		return $formatted;
	
	}
	
	//FUNC_GUS - Generate unique slug for the page (PRIV)
	private function _generate_unique_slug($title){
		
		//I know it's not in the spirit of MVC to mention this here but in case you're wondering what's 
		//stopping duplicate filenames, that gets handled in CodeIgniter's file upload functionality!
		
		//"Slugify" the title
		$title = $this->string_manip->slugify($title);
		
		//Get a count of rows that match this title
		$number = $this->db->where('slug',$title)->count_all_results('comic');
		
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
				$number = $this->db->where('slug',$title."-".$cnt)->count_all_results('comic');
				
				//If the amount matched is 0, that's the number to use!
				if($number == 0){
					
					//Set flag and title
					$flag 	= TRUE;
					$title 	= $title . "-" . $cnt;
				
				//Matches, so increment to check the next number...
				} else {
					$cnt++;
				}
				
			}
			
		}
		
		//Output the title
		return $title;
		
	}
	
	//FUNC_FP - Fetch a comic page, returns most recent by default
	public function fetch_page($filters = array(),$reverse = FALSE){
		
		//Start query
		$sql = "SELECT * FROM `comic`";
		
		//Add mods array
		$sql_mod = array();
		
		//DEBUG
		//print_r($filters);
		
		//Add query modifiers
		if(!empty($filters)){
			
			//Load validation library
			$this->load->library('validation');

			//Add mods (validates/evaluates input as well in case anything dodgy gets passed in)
			if(isset($filters['pageid']) && ctype_digit((string)$filters['pageid'])){
				$sql_mod[] = "`comicid` = " . $this->db->escape($filters['pageid']);
			}
			if(isset($filters['slug']) && $this->validation->is_alphanumeric($filters['slug'],$allowances = array('_','-'))){
				$sql_mod[] = "`slug` = " . $this->db->escape($filters['slug']);
			}
			if(isset($filters['ordering']) && ctype_digit((string)$filters['ordering'])){
				$sql_mod[] = "`page_ordering` = " . $this->db->escape($filters['ordering']);
			}
			if(isset($filters['chapterid']) && ctype_digit((string)$filters['chapterid'])){
				$sql_mod[] = "`chapterid` = " . $this->db->escape($filters['chapterid']);
			}
			if(isset($filters['verified']) && $this->validation->is_boolean($filters['verified'])){
				$sql_mod[] = "`filename` IS NOT NULL";
				$sql_mod[] = "`published` < " . $this->db->escape(date('Y-m-d H:i:s'));
			}
				
		}
		
		//DEBUG
		//print_r($sql_mod);
		
		//Append modifiers to SQL
		if(!empty($sql_mod)){
			$sql .= " WHERE ";
			$sql .= implode(' AND ',$sql_mod);
		}
		
		//Reverse order flage
		if($reverse != FALSE){
			$sql .= " ORDER BY `page_ordering` ASC, `published` ASC"; 
		} else {
			
			//No modifiers, most recent
			if(!isset($filters['pageid']) && !isset($filters['slug'])){
				$sql .= " ORDER BY `page_ordering` DESC, `published` DESC"; 
			}
			
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
		
		//Some minor formatting for published date
		$result->published = strtotime($result->published);
		
		//Return!
		return $result;
		
	}
	
	//FUNC_FAP - Fetch all comic pages, optionally by chapter
	public function fetch_all_pages($reverse = FALSE,$chapterid = FALSE,$active = FALSE){
		
		//Gets all pages
		$this->db->select('*');
		$this->db->from('comic');
		
		//Chapter
		if($chapterid != FALSE){
			$this->db->where('chapterid',$chapterid);
		}
		
		//Active flag = is page available to view?
		if($active != FALSE){
			$this->db->where('filename IS NOT NULL');
			$this->db->where('published < ',date('Y-m-d H:i:s'));
		}
		
		//Ordering?
		if($reverse == FALSE){
			$this->db->order_by("page_ordering","DESC");
			$this->db->order_by("published","DESC");
		} else {
			$this->db->order_by("page_ordering","ASC");
			$this->db->order_by("published","ASC");
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
	
	//FUNC_FVPIO - Fetches all pages, verifies that corresponding page files exist
	public function fetch_valid_pages_in_order($reverse = FALSE,$active = FALSE){
		
		//Get most of the page info
		$pages = $this->fetch_all_pages($reverse,FALSE,$active);
		
		//No pages?
		if(!$pages){
			return FALSE;
		}
		
		//Load helper
		$this->load->helper('file');
		
		//Loop through the pages, test each link
		foreach($pages as $page){
			
			//Skip if not set...
			if($page->filename == NULL){
				continue;
			}
			
			//Set URL
			$url = "./assets/pages/" . $page->filename;
			
			//Check if exists
			if(!read_file($url)){
				
				//If it doesn't then update the page file reference to NULL
				$this->update_page_file($page->comicid);
				$page->filename = NULL;
				
			}
			
		}
		
		//Set chapters "wrapper" array
		$pages_chapters 				= array();
		$no_chapter 					= new stdClass();
		$no_chapter->chapterid 			= 0;
		$no_chapter->type 				= "chapter";
		$no_chapter->masterid 			= NULL;
		$no_chapter->name 				= "No chapter set";
		$no_chapter->slug				= NULL;
		$no_chapter->description		= NULL;
		$no_chapter->chapter_ordering	= 0;
		
		//We need to bolt in chapters for the ordering - so attempt to fetch those!
		$this->load->model('Chapters_model','Chapters');
		$chapters = $this->Chapters->fetch_all_chapters($reverse,$reverse);
		
		//DEBUG
		//print_r($chapters); print_r($pages);
		
		//No chapters = assign all items to "no chapter", return
		if(!$chapters){
			$no_chapter->pages 	= $pages;
			$pages_chapters[] 	= $no_chapter;
			return $pages_chapters;
		}
		
		//Chapters - loop through and assign to array
		foreach($chapters as $chapter_key => $chapter){
			
			//Create pages array
			$chapters[$chapter_key]->pages = array();
			
			//Loop through pages
			foreach($pages as $page_key => $page){
				
				//If ID matches...
				if($chapter->chapterid == $page->chapterid){
					
					//...assign to chapter
					$chapters[$chapter_key]->pages[] = $page;
					
					//Remove from pages array
					unset($pages[$page_key]);
					
				}
				
			}
			
			//Subchapters...(is there a neater way to loop this???)
			if(!empty($chapter->subchapters)){
				
				//Loop
				foreach($chapter->subchapters as $subchapter_key => $subchapter){
					
					//Create pages array
					$chapter->subchapters[$subchapter_key]->pages = array();
					
					//Loop through pages
					foreach($pages as $page_key => $page){
						
						//If ID matches...
						if($subchapter->chapterid == $page->chapterid){
							
							//...assign to chapter
							$chapter->subchapters[$subchapter_key]->pages[] = $page;
							
							//Remove from pages array
							unset($pages[$page_key]);
							
						}
						
					}
					
				}
				
			}
			
		}
		
		//If spare pages...
		if(!empty($pages)){
		
			//Add the rest to the "no chapter" array
			$no_chapter->pages = $pages;
			
			//Add "no chapter" array to chapters array (at the beginning!)
			array_unshift($chapters,$no_chapter);
			
		}
		
		//DEBUG
		//print_r($chapters);
		
		//Return formatted pages
		return $chapters;
		
	}
	
	//FUNC_FPN - Fetches pages for comic navigation
	public function fetch_pages_nav($pageid = FALSE,$slug = FALSE,$verified = FALSE,$on_display = FALSE){
		
		//Require one input at least!
		if(!$pageid && !$slug){
			return FALSE;
		}
		
		//Set nav array
		$nav = array(
			'first_page' 		=> FALSE,
			'last_page'			=> FALSE,
			'prev_page'			=> FALSE,
			'next_page'			=> FALSE,
			'rand_page'			=> FALSE,
			'chapter_jump'		=> FALSE,
			'page_select'		=> FALSE,
			'chapter_select'	=> FALSE
		);
		
		//Fetch current page
		$page 		= $this->fetch_page($filters = array('pageid' => $pageid,'slug' => $slug,'verified' => $verified));
		$page_order = (string)$page->page_ordering;
		
		//Fetch the max number of pages...
		$min_number = 1;
		$max_number = $this->fetch_max_page_order($on_display); //Set display flag to only fetch pages "on show"
		if(!$max_number){ return FALSE; }

		//Try finding the first page...
		if($page_order != $min_number){
			$page_offset = $min_number;
			$nav['first_page'] = $this->_find_next_sequential_page($page_offset,$max_number,"up",$verified);
		}
		
		//Try finding the last page...
		if($page_order != $max_number){
			$page_offset = $max_number;
			$nav['last_page'] = $this->_find_next_sequential_page($page_offset,$min_number,"down",$verified);
		}
		
		//Previous page
		$page_offset = ($page_order - 1);
		$nav['prev_page'] = $this->_find_next_sequential_page($page_offset,$min_number,"down",$verified);
		
		//Next page
		$page_offset = ($page_order + 1);
		$nav['next_page'] = $this->_find_next_sequential_page($page_offset,$max_number,"up",$verified);
		
		//Select a random page - first build an array of pages to exclude
		$excludes = array($page_order,$page_offset);
		foreach($nav as $page_type => $navpage){
			if($navpage){
				$excludes[] = (string)$navpage->page_ordering;
			}
		};
		$excludes = array_unique($excludes); asort($excludes);
		
		//Random page - make sure it's not one of the other pages!
		$rand_offset 	= FALSE;
		$attempts 		= 0;
		while($rand_offset == FALSE || in_array($rand_offset,$excludes)){
			$rand_offset = rand($min_number,$max_number);
			$attempts++; //Soz for use of magic number '3', basically if there's only one page this would infinite loop so this is a fix!
			if($attempts >= 3){
				break;
			}
		}
		
		//DEBUG
		//echo $rand_offset; print_r($excludes);
		
		//Random page
		$nav['rand_page'] = $this->_find_next_sequential_page($rand_offset,$max_number,"up",$verified);
		
		//Chapter jump - get start and end pages for the chapter
		$filters 						= array('chapterid' => $page->chapterid,'verified' => TRUE);
		$nav['chapter_jump']['start'] 	= $this->fetch_page($filters,$reverse = TRUE);
		$nav['chapter_jump']['end'] 	= $this->fetch_page($filters);
		
		//Chapter jump - if the current page is either, remove it!
		foreach($nav['chapter_jump'] as $place => $jump_page){
			if($jump_page == FALSE || $page->comicid == $jump_page->comicid){
				$nav['chapter_jump'][$place] = FALSE;
			}
		}
		
		//Chapter jump - chances are that the very last page might be the same as the "end" of the chapter so check that
		if($nav['chapter_jump']['end'] != FALSE && isset($nav['chapter_jump']['end']->comicid) && isset($nav['last_page']->comicid)){
			if($nav['chapter_jump']['end']->comicid == $nav['last_page']->comicid){
				$nav['chapter_jump']['end'] = FALSE;
			}
		}
		
		//Page select - get all pages, strip empty chapters
		$all_pages = $this->fetch_valid_pages_in_order(FALSE,TRUE);
		if($all_pages){
			foreach($all_pages as $key => $chapter){
				if(empty($chapter->pages) && !isset($chapter->subchapters)){
					unset($all_pages[$key]);
				}
				if(isset($chapter->subchapters)){
					foreach($chapter->subchapters as $skey => $subchapter){
						if(isset($all_pages[$key]->subchapters[$skey]) && empty($subchapter->pages)){
							unset($all_pages[$key]->subchapters[$skey]);
						}
					}
				}
			}
		}
		$nav['page_select'] = $all_pages;
		
		//Chapter select - fetch the first page in each chapter
		$chapters = array();
		if($all_pages){
			foreach($all_pages as $key => $chapter){

				//Subchapters
				if(isset($chapter->subchapters)){
					$chapter->subchapters = array_reverse($chapter->subchapters);
					foreach($chapter->subchapters as $skey => $subchapter){
						$filters['chapterid'] 	= $subchapter->chapterid;
						$subpage 				= $this->fetch_page($filters,$reverse = TRUE);
						if($subpage != FALSE && !empty($subpage)){
							$chapters[$chapter->name]['subs'][$subchapter->name] = $subpage;
						}
					}
				}
				
				//Skip the "non-chapter"
				if($chapter->name == "No chapter set"){
					continue;
				}
				
				//Set filters, attempt to fetch page
				$filters['chapterid'] 	= $chapter->chapterid;
				$page 					= $this->fetch_page($filters,$reverse = TRUE);
				if($page != FALSE && !empty($page)){
					$chapters[$chapter->name]['main'] = $page;
				}
				
				//No main page but there are subchapters - use the first page in the first subchapter instead
				if((!isset($chapters[$chapter->name]['main']) || $chapters[$chapter->name]['main'] == FALSE) && isset($chapter->subchapters[0])){
					$filters['chapterid'] 	= $chapter->subchapters[0]->chapterid;
					$subpage				= $this->fetch_page($filters,$reverse = TRUE);
					if($subpage != FALSE && !empty($subpage)){
						$chapters[$chapter->name]['main'] = $subpage;
					}
				}
				
			}
		}
		if(!empty($chapters)){
			$nav['chapter_select'] = $chapters;
		}
		
		//DEBUG
		//print_r($nav);die;
		
		//Output navigation
		return $nav;
		
	}
	
	//FUNC_FNSP - Find next page in sequence, up or down (PRIV)
	private function _find_next_sequential_page($offset,$max_offset,$direction = "up",$verified = FALSE){
		
		//Set filters array
		$filters = array('verified' => $verified);
		
		//While page is blank
		$page = FALSE;
		while($page == FALSE){
			
			//Set offset
			$filters['ordering'] = $offset;
			
			//Attempt fetch - if no matching page, try the next one along...
			$page = $this->fetch_page($filters);
			if(!$page){
				
				//Up or down?
				if($direction == "up"){
					
					//Increment offset
					$offset++;
					
					//Over the max offset
					if($offset >= $max_offset){
						return FALSE;
					}
					
				} else {
					
					//Decrease offset
					$offset--;
					
					//Under the max (min) offset
					if($offset <= $max_offset){
						return FALSE;
					}
					
				}

			}
			
		}
		
		//Page matched
		return $page;
		
	}
	
	//FUNC_FMPO - Fetch max page number
	public function fetch_max_page_order($on_display = FALSE){
		
		//Get the max order number
		$this->db->select_max('page_ordering');
		
		//If display flag is set, just get the last page "for display"
		if($on_display){
			$this->db->where('filename <>',NULL);
			$this->db->where('published <= "' . date('Y-m-d H:i:s',time()) . '"',NULL);
		}
		
		//Fetch
		$query = $this->db->get('comic');
		
		//No result = no pages to update!
		if($query->num_rows() == 0){
			return FALSE;
		}
		
		//Reassign result
		$result = $query->result();
		$result = $result[0]; //Should only be one result!
		
		//Return
		return $result->page_ordering;
		
	}
	
	//FUNC_MPO - Detects if comic pages are missing an order
	public function missing_page_ordering(){
		
		//Set SQL
		$sql = "SELECT * FROM `comic` WHERE `page_ordering` IS NULL";
		
		//DEBUG
		//echo $sql;
		
		//Generate query
		$query = $this->db->query($sql);
		
		//No result = no pages to update!
		if($query->num_rows() == 0){
			return FALSE;
		}
		return TRUE;
		
	}
	
	//FUNC_SEARCH - Search comic archive for a specific term
    public function search($term){
        
		//Escape the string
		$term = $this->db->escape_like_str($term);
		$term = "'%" . $term . "%'";
		
		//Sorry for massively complicated SQL...there's probably a way to write this with 
		//the CI query builder but it's just a lot damn quicker for me to write it out!
        $sql = "
			SELECT * FROM (
				SELECT `comic`.* FROM `comic` 
				WHERE `name` LIKE " . $term . "  
				OR `transcript` LIKE " . $term . " 
				OR `notes` LIKE " . $term . " 
				OR `title_text` LIKE " . $term . " 
				UNION
				SELECT `comic`.* FROM `characters` LEFT JOIN `comic_tags` ON 
				`characters`.characterid = `comic_tags`.linkid LEFT JOIN `comic` ON 
				`comic_tags`.pageid = `comic`.comicid 
				WHERE `comic_tags`.type = 'character' AND 
				`characters`.profile_active = 'Y' AND 
				(`characters`.name LIKE " . $term . " 
				OR `characters`.notes LIKE " . $term . ") 
				UNION 
				SELECT `comic`.* FROM `tags` LEFT JOIN `comic_tags` ON 
				`tags`.tagid = `comic_tags`.linkid LEFT JOIN `comic` ON 
				`comic_tags`.pageid = `comic`.comicid 
				WHERE `comic_tags`.type = 'tag' AND 
				(`tags`.label LIKE " . $term . " 
				OR `tags`.label LIKE " . $term . ")
			) AS search 
			WHERE search.filename IS NOT NULL AND 
			search.published < '" . date('Y-m-d',strtotime('+1 day')) . "' 
			ORDER BY search.page_ordering;
		";
		
        //Run query
		$query = $this->db->query($sql);
		
		//DEBUG
		//echo $this->db->last_query();
		
		//No result
		if($query->num_rows() == 0){
			return FALSE;
		}
		
		//Reassign result
		$result = $query->result();
		
		//Return!
		return $result;
        
    }
	
	//FUNC_ABOUT - Fetch about page details (if any!)
	public function fetch_about_page($fields){
		
		//Sanity check
		if(!$fields || empty($fields)){
			return FALSE;
		}
		
		//Assemble string of fields to get
		$db_fields = array();
		foreach($fields as $label => $fieldarray){
			
			//Add to array
			$db_fields[] = $this->db->escape($fieldarray['db_field']);
			
		}
		$db_fields[] = $this->db->escape('about_updated');
		
		//Check...
		if(empty($db_fields)){
			return FALSE;
		}
		
		//Form SQL
		$sql = "SELECT * FROM misc_storage WHERE ref IN (" . implode(',',$db_fields) . ")";
		
		//DEBUG
		//echo $sql;
		
		//Run query
		$query = $this->db->query($sql);
		
		//DEBUG
		//echo $this->db->last_query();
		
		//No result
		if($query->num_rows() == 0){
			return FALSE;
		}
		
		//Reassign result
		$result = $query->result();
		
		//DEBUG
		//print_r($result);
		
		//Format the result and collect if it's empty at the same time!
		$empty 	= TRUE;
		$format = array();
		foreach($result as $item){
			$format[$item->ref] = $item->details;
			if($item->details != "" && $item->ref != "about_updated"){
				$empty = FALSE;
			}
		}
		
		//Nothing to return!
		if($empty == TRUE){
			return FALSE;
		}
		
		//Return!
		return $format;
		
	}
	
	/***** UPDATE *****/
	
	//FUNC_UPD - Update OR insert a comic page
	public function update($pageid = FALSE,$input,$fields){
		
		//Do some formatting
		$input = $this->_format($input,$fields,$pageid);
		
		//DEBUG
		//print_r($input);die;
		
		//Check for characters and tags
		if(isset($input['characters'])){
			$characters = $input['characters'];
			unset($input['characters']);
		}
		if(isset($input['tags'])){
			$tags = $input['tags'];
			unset($input['tags']);
		}

		//Start sql array
		$sql = $sql_fields = array();
		
		//Insert or update?
		if($pageid == FALSE){
			$sql[] = "INSERT INTO";
		} else {
			$sql[] = "UPDATE";
		}
		
		//Add table
		$sql[] = "`comic` SET";
		
		//Loop and assemble SQL
		foreach($input as $db_fieldname => $value){
			$sql_fields[] = $this->db->protect_identifiers($db_fieldname) . " = " . $this->db->escape($value);
		}
		$sql[] = implode(',',$sql_fields);

		//If we're updating, add the id of the page we're updating
		if($pageid != FALSE){
			
			$sql[] = "WHERE `comicid` = " . $this->db->escape($pageid);
		
		//If we're inserting, we need to update the page order
		} else {
		
			//Fetch last page, add 1 and assign to SQL
			$last_page = $this->fetch_max_page_order();
			if(!$last_page){ //None, presumably no pages!
				$last_page = 0;
			}
			$sql[] = ", `page_ordering` = " . $this->db->escape($last_page+1);
			
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
			if($pageid == FALSE){
				
				$pageid 	= $this->db->insert_id();
				$response 	= $pageid;
			
			//ID = update successful
			} else {
			
				$response = TRUE;
			
			}
			
			//Characters OR tags = try processing
			if(isset($characters) || isset($tags)){
				
				$this->load->model('Tagging_model','Tagging');
			
				if(isset($characters)){
					$this->Tagging->add_page_tags($characters,$pageid,$type = "character");
				} else {
					$this->Tagging->delete_page_tags($pageid,$type = "character");
				}
				if(isset($tags)){
					$this->Tagging->add_page_tags($tags,$pageid,$type = "tag");
				} else {
					$this->Tagging->delete_page_tags($pageid,$type = "tag");
				}
			
			}
			
			//Output response
			return $response;
			
		}
		
	}
	
	//FUNC_UPF - Update file for a page
	//Note that not passing in no filename value wipes the field, ostensibly "deleting" the page
	public function update_page_file($pageid,$filename = NULL){
		
		//Query
		$sql = "UPDATE `comic` SET `filename` = " . $this->db->escape($filename) . " WHERE `comicid`= " . $this->db->escape($pageid);
		
		//Run
		if(!$this->db->query($sql)){
			return FALSE;
		}
		return TRUE;
		
	}
	
	//FUNC_UPO - Update a page's order
	public function update_page_order($pageid,$order){
		
		//Form SQL
		$sql = "UPDATE `comic` SET `page_ordering` = " . $this->db->escape($order) . " WHERE `comicid`= " . $this->db->escape($pageid);
		
		//DEBUG
		//echo $sql . "<br />";
		
		//Run
		if(!$this->db->query($sql)){
			return FALSE;
		}
		return TRUE;
		
	}
	
	//FUNC_UPC - Update a page's chapter
	public function update_page_chapter($pageid,$chapterid = NULL){
		
		//Form SQL
		$sql = "UPDATE `comic` SET `chapterid` = " . $this->db->escape($chapterid) . " WHERE `comicid`= " . $this->db->escape($pageid);
		
		//DEBUG
		//echo $sql . "<br />";
		
		//Run
		if(!$this->db->query($sql)){
			return FALSE;
		}
		return TRUE;
		
	}
	
	//FUNC_SDO - Default ordering for comic
	public function set_default_order(){
		
		//Get all pages
		$pages = $this->fetch_valid_pages_in_order($reverse = TRUE);
		
		//Sanity check - might not be any pages!
		if(!$pages){
			return FALSE;
		}
		
		//Set counter
		$page_counter = 1;
		
		//Loop
		foreach($pages as $chapter){
			
			//If pages...
			if(!empty($chapter->pages)){
				foreach($chapter->pages as $page){
					
					//Update page order
					$this->update_page_order($page->comicid,$page_counter);
					
					//Increment order
					$page_counter++;
					
				}
			}
			
			//Now subchapters...
			if(!empty($chapter->subchapters)){
				foreach($chapter->subchapters as $subchapter){
					
					//Update pages (if any)
					if(!empty($subchapter->pages)){
						foreach($subchapter->pages as $page){
							
							//Update page order
							$this->update_page_order($page->comicid,$page_counter);
					
							//Increment order
							$page_counter++;
							
						}
					}
					
				}
			}
			
		}
		
		//End function
		return TRUE;
		
	}
	
	//FUNC_UPABPG - Update (or create) the "about" page
	public function update_about_page($input,$fields){
		
		//Sanity check
		if(empty($fields) || empty($input)){
			return FALSE;
		}
		
		//Do some formatting
		$input = $this->_format_about($input,$fields);
		
		//Are the fields empty?
		$empty = TRUE;
		foreach($fields as $label => $field){
			if($input[$field['db_field']] != ""){
				$empty = FALSE;
			}
		}
		
		//No values = DELETE
		if($empty == TRUE){
			foreach($fields as $label => $field){
				$sql = "DELETE FROM misc_storage WHERE ref = " . $this->db->escape($field['db_field']);
				$this->db->query($sql);
			}
			return TRUE;
		}
		
		//DEBUG
		//print_r($input);die;
		
		//Set flag
		$success = TRUE;
		
		//Loop fields
		foreach($fields as $label => $field){
			
			//Check to see if there's an existing field in the misc data table
			$number = $this->db->where('ref',$field['db_field'])->count_all_results('misc_storage');
			
			//Start SQL
			if($number == 0){
				$sql = "INSERT INTO ";
			} else {
				$sql = "UPDATE ";
			}
			
			//Form SQL
			$sql .= "misc_storage SET ref = " . $this->db->escape($field['db_field']) . ", details = " . $this->db->escape($input[$field['db_field']]);
			
			//Update = set where clause
			if($number > 0){
				$sql .= " WHERE ref = " . $this->db->escape($field['db_field']);
			}
			
			//DEBUG
			//echo $sql . "<br />";
			
			//Set flag if query doesn't run
			if(!$this->db->query($sql)){
				$success = FALSE;
			}
			
		}
		
		//Output TRUE/FALSE
		return $success;
		
	}
	
	/***** DESTROY *****/
	
	//FUNC_DP - Delete page from db
	public function delete_page($pageid){
		
		//Set statement
		$this->db->where('comicid', $pageid);
		$this->db->delete('comic');
		
		//Check if run
		if(!$this->db->affected_rows()){
			return FALSE;
		}
		return TRUE;
		
	}
	
}
