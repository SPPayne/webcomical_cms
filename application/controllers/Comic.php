<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comic extends CI_Controller {
	
	function __construct(){
		
		parent::__construct();
		
		//Load Webcomic config
		$this->load->config('webcomic',TRUE);
		
		//First time load? Stop constructor from loading more!
		$this->install = FALSE;
		if($this->_check_first_load() == TRUE){
			$this->install = TRUE;
			return;
		}
		
		//Load libraries
		$this->load->library(array('ion_auth','string_manip'));
		
		//Load models
		$this->load->model('Banners_model','Banners');
		$this->load->model('Comic_model','Comic');
		$this->load->model('Settings_model','Settings');
		$this->load->model('Chapters_model','Chapters');
		$this->load->model('Characters_model','Characters');
		$this->load->model('Tagging_model','Tags');
		$this->load->model('Template_model','Template');
		$this->load->model('Redirects_model','Redirect');
		$this->load->model('Logging_model','Logging');
		
		//Set navigation modifiers
		$this->navigation = $this->Settings->fetch_structured_site_nav();
		
		//Get site values and then append other items, like favicon, about page, etc.
		$this->site_values 	= $this->Settings->fetch_site_values();
		$this->data['site'] = $this->Settings->fetch_tertiary_site_values($this->site_values);
		
		//Fetch banners
		$this->data['banners'] = $this->Banners->fetch_banners(FALSE,TRUE);
		
	}
	
	//FUNCTION INDEX - Search a function code to skip to that part of the file
	/* 
	 * FUNC_INDEX 	- Main page, handled by page() (FUNC_PAGE)
	 * FUNC_RENDR 	- Renders page view, either from template or using system defaults (PRIV)
	 * FUNC_DEFAULT - Loads system default templates (PRIV)
	 *
	 * *** Comic Pages ***
	 * FUNC_PAGE 	- View any comic page
	 * FUNC_LDPGCUS - Load selected custom template for comic pages (PRIV)
	 *
	 * *** Lists ***
	 * FUNC_ARCHIVE 	- Show comic archive, a list of episodes
	 * FUNC_TAG 		- List pages by a specific tag, handled by _load_tags_template() (FUNC_LTT)
	 * FUNC_APPEAR 		- List pages that contain a specific character, handled by _load_tags_template() (FUNC_LTT)
	 * FUNC_SEARCH 		- Search the comic archive for a term, handled by _load_tags_template() (FUNC_LTT)
	 * FUNC_LTT 		- Handling for returning episodes based on a phrase (tag, search term, etc.) (PRIV)
	 *
	 * *** Characters ***
	 * FUNC_CHARIND 	- No slug = list character profiles; slug = load a specific character's profile
	 * FUNC_CHARLIST 	- Present the cast of characters as a list (PRIV)
	 * FUNC_CHARPRO 	- Present character profile (PRIV)
	 *
	 * *** Bookmarks ***
	 * FUNC_SVBKMRK - Save a bookmark (AJAX)
	 * FUNC_LDBKMRK - Load a bookmark (AJAX)
	 *
	 * *** Misc Pages ***
	 * FUNC_ABOUT 		- "About" page
	 * FUNC_RSS 		- RSS Feed
	 * FUNC_404 		- 404 page not found
	 *
	 * *** Installation ***
	 * FUNC_CHKFRSTLD 	- Checks if the comic is being loaded for the first time (PRIV)
	 * FUNC_INSTALL 	- Installation of the app (PRIV)
	 * FUNC_INSTERR 	- Handle errors with installation (passes to FUNC_RENDINST) (PRIV)
	 * FUNC_RENDINST 	- Render install page (PRIV)
	 */
	
	//FUNC_INDEX - Main page, handled by page()
	public function index(){
		
		//First time load?
		if($this->install == TRUE){
			$this->_install();
			return;
		}
		
		//By default, load the page!
		$this->page();
		
	}
	
	//FUNC_RENDR - Renders page view, either from template or using system defaults (PRIV)
	private function _render_page_view($type,$data){
		
		//If the site is default then we can render using regular views
		if($this->data['site']['site_theme'] == "default"){
			$this->_load_default_template($type,$data);
			return;
		}
		
		//Attempt to load the template
		$config 	= $this->config->item('templates','webcomic');
		$template 	= $this->Template->load_template($config,$type,$data);

		//If template can't be loaded, use the default...
		if($template == FALSE){
			$this->_load_default_template($type,$data);
			return;
		}
		
		//Output custom template, end
		echo $template;
		return;
		
	}
	
	//FUNC_DEFAULT - Loads system default templates (PRIV)
	private function _load_default_template($type,$data){
		
		//Set path to the default template folder
		$dir = "comic/default_template/";
		
		//HTML header
		$this->load->view($dir.'header',$data);
		
		//If logged in show admin toolbar
		if($this->ion_auth->logged_in()){
			$this->load->view('admin/shared/admin_toolbar');
		}
		
		//Header (banner, title)
		$this->load->view($dir.'page_header',$data);
		
		//Site navigation (cast, archive, etc.)
		$this->load->view($dir.'site_navigation',$data);
		
		//View to render will depend on the page
		switch($type){
			case "pages":
			
				//Navbar top
				$data['nav_place'] = "top";
				$this->load->view($dir.'comic_navigation',$data);
				
				//Actual comic page
				$this->load->view($dir.'page',$data);
				
				//Navbar bottom
				$data['nav_place'] = "bottom";
				$this->load->view($dir.'comic_navigation',$data);
				
				//Footer (blog, transcript, comments)
				$this->load->view($dir.'page_footer',$data);
			
			break;
			case "archive":
			case "about":
			case "tags":
			case "cast":
			case "profile":
				$this->load->view($dir . $type . '_page',$data);
			break;
			case "search":
				$this->load->view($dir.'search_form',$data);
			break;
			case "404":
				$this->load->view('comic/404',$data);
			break;
		}

		//Footer
		$this->load->view($dir.'footer',$data);
		
		//End of default template
		return;
		
	}
	
	/********** Comic Pages **********/
	
	//FUNC_PAGE - View any comic page
	public function page($slug = FALSE){
		
		//To save duplicate pages, redirect to / when no slug
		if($this->uri->uri_string() == "page" && $slug == FALSE){
			redirect(base_url(),'refresh');
		}
		
		//Is this page being redirected?
		$redirect = $this->Redirect->fetch_redirect(FALSE,$slug,'comic');
		if($redirect){
			redirect(base_url() . 'page/' . $redirect->redirect,'location',301);
		}
		
		$filters = array();
		
		//Set page filters
		if(!$this->ion_auth->logged_in()){ //Site visitor
			$filters['verified'] = TRUE;
			$nav_flag = TRUE;
		} else { //Admin user logged in, bypasses need for page to be published for preview purposes
			if($preview == FALSE){
				$filters['verified'] = TRUE;
			}
			$nav_flag = FALSE; //We use this to represent whether the "verified" flag is set in nav formation otherwise it throws a wobbly
		}
		
		//Pass slug to page filters
		if($slug != FALSE){
			$filters['slug'] = $slug;
		}
		
		//Get the page - file required
		$this->data['page'] = $this->Comic->fetch_page($filters);
		
		//No page = 404
		if($this->data['page'] == FALSE){
			$this->page_not_found();
			return;
		}
		
		//Title
		if($slug != FALSE){
			$this->data['title'] = $this->data['page']->name;
		}
		
		//Fetch user settings, page links for navigation
		$this->data['nav_config'] 	= $this->navigation;
		$this->data['nav'] 			= $this->Comic->fetch_pages_nav(FALSE,$this->data['page']->slug,$nav_flag,TRUE);
		
		//Is an admin logged in? Then we're previewing everything
		$this->data['nav']['preview'] = FALSE;
		if($nav_flag == FALSE){
			$this->data['nav']['preview'] = TRUE;
		}
		
		//Grab all the tags
		$this->data['tags'] = $this->Tags->fetch_page_tags_collated($this->data['page']->comicid);
		
		//If chapters, get current chapter
		if($this->data['page']->chapterid){
			$chapter = $this->Chapters->fetch_chapter($filters = array('chapterid' => $this->data['page']->chapterid));
			if($chapter){
				$this->data['current_chapter'] 			= $chapter->name;
				$this->data['current_chapter_blurb'] 	= $chapter->description;
			}
		}
		
		//Meta
		$this->data['meta'] = array('url' => base_url(uri_string()));
		if(!isset($this->data['title'])){
			$this->data['meta']['title']		= $this->data['site']['site_name'];
			$this->data['meta']['description']	= $this->data['site']['site_slogan'];
			if($this->data['banners']){
				$this->data['meta']['image'] = base_url() . 'assets/banners/' . $this->data['banners'][array_rand($this->data['banners'],1)]->filename;
			} else {
				$this->data['meta']['image'] = base_url() . 'assets/pages/' . $this->data['page']->filename;
			}
		} else {
			$this->data['meta']['title']		= $this->data['title'] . ' | ' . $this->data['site']['site_name'];
			$this->data['meta']['description']	= $this->data['page']->excerpt;
			$this->data['meta']['image']		= base_url() . 'assets/pages/' . $this->data['page']->filename;
		}
		$this->data['meta'] = array_filter($this->data['meta']);

		//Log page view
		if(!$this->ion_auth->logged_in() && $this->router->fetch_method() != "index"){
			$url = '/' . $this->router->fetch_method() . '/' . $slug;
			$this->Logging->page_count_update($url,$type = "page");
		}
		
		//DEBUG
		//print_r($this->data['nav']);
		//print_r($page);
		//print_r($this->data['site']);
		
		//Serve up the view
		$this->_render_page_view('pages',$this->data);
		
		//End!
		return;
		
	}
	
	/********** Lists **********/
	
	//FUNC_ARCHIVE - Show comic archive, a list of episodes
	public function archive(){
	
		//Title
		$this->data['title'] = $this->site_values['site_archive_term'];
		
		//Meta
		$this->data['meta'] = array(
			'title' 		=> $this->site_values['site_archive_term'] . ' | ' . $this->data['site']['site_name'],
			'description' 	=> 'The ' . strtolower($this->site_values['site_archive_term']) . ' for ' . $this->data['site']['site_name'],
			'url'			=> base_url(uri_string())
		);
		if($this->data['banners']){
			$this->data['meta']['image'] = base_url() . 'assets/banners/' . $this->data['banners'][array_rand($this->data['banners'],1)]->filename;
		}
		$this->data['meta'] = array_filter($this->data['meta']);
		
		//Fetch entire pages and chapters
		$this->data['archive'] = $this->Comic->fetch_valid_pages_in_order($reverse = TRUE,$active = TRUE,$subchapter_reverse = TRUE);
		
		//Render view
		$this->_render_page_view('archive',$this->data);
		
		//End!
		return;

	}
	
	//FUNC_TAG - List pages by a specific tag, handled by _load_tags_template() (FUNC_LTT)
	public function tags($slug = FALSE,$offset = 0){
		$this->_load_tags_template($slug,$offset,"tags");
	}
	
	//FUNC_APPEAR - List pages that contain a specific character, handled by _load_tags_template() (FUNC_LTT)
	public function character_appearances($slug = FALSE,$offset = 0){
		$this->_load_tags_template($slug,$offset,"characters");
	}
	
	//FUNC_SEARCH - Search the comic archive for a term, handled by _load_tags_template() (FUNC_LTT)
	public function search($slug = FALSE,$offset = FALSE){
	
		//DEBUG
		//print_r($this->input->post('comic_search'));
		
		//Pass search term
		if($this->input->post('comic_search')){
			
			//Set search term
			$this->session->set_userdata('search_term',$this->string_manip->make_tame($this->input->post('comic_search')));
		
			//Redirect if slug is not set for SEO purposes
			if($slug == FALSE){
				redirect(base_url().$this->router->fetch_method().'/'.$this->string_manip->slugify($this->input->post('comic_search')),'refresh');
			}
		
		//No search term but one is set!
		} elseif(!$this->input->post('comic_search') && $this->session->userdata('search_term')){
			
			//Redirect
			if($slug == FALSE){
				redirect(base_url().$this->router->fetch_method().'/'.$this->string_manip->slugify($this->session->userdata('search_term')),'refresh');
			}
		
		//No search term	
		} else {
			
			//Title
			$this->data['title'] = 'Search the Comic';
			
			//Meta
			$this->data['meta'] = array(
				'title' 		=> $this->data['title'] . ' | ' . $this->data['site']['site_name'],
				'description' 	=> 'Search for comics on ' . $this->data['site']['site_name'],
				'url'			=> base_url(uri_string())
			);
			if($this->data['banners']){
				$this->data['meta']['image'] = base_url() . 'assets/banners/' . $this->data['banners'][array_rand($this->data['banners'],1)]->filename;
			}
			$this->data['meta'] = array_filter($this->data['meta']);
			
			//Render
			$this->_render_page_view('search',$this->data);
			
			//End here
			return;
			
		}

		//Load search with results
		$this->_load_tags_template($this->session->userdata('search_term'),$offset,"search");
		
	}
	
	//FUNC_LTT - Handling for returning episodes based on a phrase (tag, search term, etc.) (PRIV)
	private function _load_tags_template($slug = FALSE,$offset = 0,$type = "tags"){
		
		//Decode
		if($slug){
			$slug = str_ireplace('_',' ',$slug);
		}
		
		//Two different paths to take
		switch($type){
			case "tags":
			default:
				
				//Is this page being redirected?
				$redirect = $this->Redirect->fetch_redirect(FALSE,$slug,'tag');
				if($redirect){
					redirect(base_url() . 'tags/' . $redirect->redirect,'location',301);
				}
				
				//Fetch tag details
				$this->data['tag'] = $this->Tags->fetch_tag(FALSE,FALSE,$slug);
				
				//Tag doesn't exist!
				if(!$this->data['tag']){
					$this->page_not_found();
					return FALSE;
				}

				//Fetch all pages with this tag
				$this->data['pages'] = $this->Tags->fetch_pages_by_tag($slug,$type = "tag");
				
				//Title
				$this->data['title'] = $this->site_values['site_page_term'] . 's tagged with "' . $this->data['tag']->label . '"';
				
				//Log tag view
				if(!$this->ion_auth->logged_in()){
					$url = '/' . $this->router->fetch_method() . '/' . $slug;
					$this->Logging->page_count_update($url,$type = "tag");
				}
				
			break;
			case "characters":
				
				//Is this page being redirected?
				$redirect = $this->Redirect->fetch_redirect(FALSE,$slug,'character');
				if($redirect){
					redirect(base_url() . $this->router->fetch_method() . '/' . $redirect->redirect,'location',301);
				}
				
				//Fetch tag details
				$this->data['tag'] = $this->Characters->fetch_character($filters = array('slug' => $slug));
				
				//Tag doesn't exist!
				if(!$this->data['tag']){
					$this->page_not_found();
					return FALSE;
				}
				
				//Reassign name
				$this->data['tag']->label = $this->data['tag']->name;

				//Fetch all pages with this tag
				$this->data['pages'] = $this->Tags->fetch_pages_by_tag($slug,$type = "character");
				
				//Title
				$this->data['title'] = $this->site_values['site_page_term'] . 's Featuring ' . $this->data['tag']->label;
				
				//Log character view
				if(!$this->ion_auth->logged_in()){
					$url = '/' . $this->router->fetch_method() . '/' . $slug;
					$this->Logging->page_count_update($url,$type = "character appearances");
				}
				
			break;
			case "search":
				
				//Featch search results
				$this->data['pages'] = $this->Comic->search($slug);
				
				//Title
				$this->data['title'] = $this->site_values['site_page_term'] . ' Search Results for the Term "' . $slug . '"';
				
				//Log character view
				if(!$this->ion_auth->logged_in()){
					$this->Logging->page_count_update($slug,$type = "search term");
				}
				
			break;
		}
		
		//Only run if there are results...
		if(!empty($this->data['pages'])){
		
			//Load library
			$this->load->library('pagination');
			
			//Load config
			$this->config->load('pagination',TRUE);
			$config = $this->config->item('comic_pagination','pagination');
			
			//Add config items
			$config['uri_segment'] 		= 3;
			$config['base_url'] 		= base_url() . '/' . $this->router->fetch_method() . '/' . $this->string_manip->slugify($slug);
			$config['first_url'] 		= $config['base_url'];
			$config['total_rows'] 		= count($this->data['pages']);
			$config['attributes'] 		= array('class' => 'tag_nav_link');
			$config['next_tag_open'] 	= "<li id='tag_next'>";
			$config['prev_tag_open'] 	= "<li id='tag_prev'>";
			$config['prev_tag_close'] = $config['next_tag_close'] = "</li>";
			$this->pagination->initialize($config);
			
			//Create pagination
			$this->data['pagination'] = $this->pagination->create_links();
			
			//Set the offset (page numbers dictate offset)
			if($offset != 0){
				$offset = ($offset-1);
			}
			
			//Splice the pages!
			$this->data['pages'] 		= array_splice($this->data['pages'],($offset*$config['per_page']),$config['per_page']);
			$this->data['per_page'] 	= $config['per_page'];
			
		}
		
		//Meta
		$this->data['meta'] = array(
			'title' 		=> $this->data['title'] . ' | ' . $this->data['site']['site_name'],
			'url'			=> base_url(uri_string())
		);
		if($this->data['banners']){
			$this->data['meta']['image'] = base_url() . 'assets/banners/' . $this->data['banners'][array_rand($this->data['banners'],1)]->filename;
		}
		$this->data['meta'] = array_filter($this->data['meta']);
		
		//Load tags view
		$this->_render_page_view('tags',$this->data);
		return;
		
	}
	
	/********** Characters **********/
	
	//FUNC_CHARIND - No slug = list character profiles; slug = load a specific character's profile
	public function character_profiles($slug = FALSE){
		
		//No slug = list profiles
		if($slug == FALSE){
			$this->_load_character_list();
			return;
		}
		
		//Load character
		$this->_load_character_profile($slug);
		
		//End!
		return;
		
	}
	
	//FUNC_CHARLIST - Present the cast of characters as a list (PRIV)
	private function _load_character_list(){
		
		//Title
		$this->data['title'] = $this->site_values['site_cast_term'];
		
		//Meta
		$this->data['meta'] = array(
			'title' 		=> $this->data['title'] . ' | ' . $this->data['site']['site_name'],
			'url'			=> base_url(uri_string())
		);
		if($this->data['banners']){
			$this->data['meta']['image'] = base_url() . 'assets/banners/' . $this->data['banners'][array_rand($this->data['banners'],1)]->filename;
		}
		$this->data['meta'] = array_filter($this->data['meta']);
		
		//Fetch cast
		$this->data['cast'] = $this->Characters->fetch_all_characters(FALSE,TRUE);
		
		//Load cast page
		$this->_render_page_view('cast',$this->data);
		return;
		
	}
	
	//FUNC_CHARPRO - Present character profile (PRIV)
	private function _load_character_profile($slug){
		
		//Is this page being redirected?
		$redirect = $this->Redirect->fetch_redirect(FALSE,$slug,'character');
		if($redirect){
			redirect(base_url() . 'character_profiles/' . $redirect->redirect,'location',301);
		}
		
		//Slug exists = attempt to fetch
		$this->data['character'] = $this->Characters->fetch_character(array('slug' => $slug));
		
		//DEBUG
		//echo "CHAR: "; print_r($this->data['character']);
		
		//No character = 404
		if(!$this->data['character']){
			$this->page_not_found();
			return;
		}
		
		//Title
		$this->data['title'] = 'Profile: ' . $this->data['character']->name;
		
		//Meta
		$this->data['meta'] = array(
			'title' 		=> $this->data['title'] . ' | ' . $this->data['site']['site_name'],
			'description' 	=> strip_tags($this->data['character']->excerpt),
			'url'			=> base_url(uri_string())
		);
		if($this->data['character']->filename){
			$this->data['meta']['image'] = base_url() . 'assets/characters/' . $this->data['character']->filename;
		} else {
			if($this->data['banners']){
				$this->data['meta']['image'] = base_url() . 'assets/banners/' . $this->data['banners'][array_rand($this->data['banners'],1)]->filename;
			}
		}
		$this->data['meta'] = array_filter($this->data['meta']);
		
		//Log character view
		if(!$this->ion_auth->logged_in()){
			$url = '/' . $this->router->fetch_method() . '/' . $slug;
			$this->Logging->page_count_update($url,$type = "character profile");
		}
		
		//Load profile page
		$this->_render_page_view('profile',$this->data);
		return;
		
	}
	
	/********** Bookmarks **********/
	
	//FUNC_SVBKMRK - Save a bookmark (AJAX)
	public function save_bookmark(){
		
		//Check for AJAX request - kill if false
		$this->load->library('validation');
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Input?
		if(!$this->input->post("bookmark") || !stristr($this->input->post("bookmark"),base_url().'page')){
			echo "Error: bookmark could not be saved!";
			return FALSE;
		}
		
		//Set session
		$this->session->set_userdata('bookmark',$this->input->post("bookmark"));
		
		//Success!
		echo "Your bookmark has been saved successfully.<br /><br />
		The next time you visit this site, just click 'load bookmark' and you will be redirected to this page automatically.<br /><br />";
		return TRUE;
		
	}
	
	//FUNC_LDBKMRK - Load a bookmark (AJAX)
	public function load_bookmark(){
		
		//Check for AJAX request - kill if false
		$this->load->library('validation');
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Bookmarked?
		if($this->session->userdata('bookmark')){
			$bookmark = $this->session->userdata('bookmark');
			$this->session->unset_userdata('bookmark');
			echo $bookmark;
			return TRUE;
		}
		
		//NOWT!
		echo "Error: no bookmark!";
		return FALSE;
		
	}
	
	/********** Misc Pages **********/
	
	//FUNC_ABOUT - "About" page
	public function about(){
		
		//Title
		$this->data['title'] = $this->site_values['site_about_term'];
		
		//Meta
		$this->data['meta'] = array(
			'title' 		=> $this->site_values['site_about_term'] . ' | ' . $this->data['site']['site_name'],
			'description' 	=> 'Learn about ' . $this->data['site']['site_name'],
			'url'			=> base_url(uri_string())
		);
		if($this->data['banners']){
			$this->data['meta']['image'] = base_url() . 'assets/banners/' . $this->data['banners'][array_rand($this->data['banners'],1)]->filename;
		}
		$this->data['meta'] = array_filter($this->data['meta']);
		
		//About page
		$this->data['about'] = $this->Comic->fetch_about_page($this->config->item('about','webcomic'));
		
		//No about page = 404
		if(!$this->data['about']){
			$this->page_not_found();
			return;
		}
		
		//Render view
		$this->_render_page_view('about',$this->data);
		
		//End!
		return;
		
	}
	
	//FUNC_RSS - RSS Feed
	public function feed(){
		
		//Fetch entire pages and chapters
		$this->data['pages'] = $this->Comic->fetch_valid_pages_in_order($reverse = FALSE,$active = TRUE);
		
		//Load the feed
		$xml = $this->load->view('comic/feed',$this->data,TRUE);
		
		//Output XML
		header('Content-Type: application/xml; charset=utf-8');
		echo $xml;
		return;
		
	}
	
	//FUNC_404 - 404 page not found
	public function page_not_found(){
		
		//Set title
		$this->data['title'] = "404! Page not found!";
	
		//Render 404 page
		$this->_render_page_view('404',$this->data);
		
		//End!
		return;
	
	}
	
	/********** Installation **********/
	
	//FUNC_CHKFRSTLD - Checks if the comic is being loaded for the first time (PRIV)
	private function _check_first_load(){
		
		//Load database config
		$this->load->config('database',TRUE);
		
		//Get database item
		$database = $this->config->item('database','database');
		
		//DEBUG
		//print_r($database);die;
		
		//Simple test - if database hasn't been populated then this is the first-time load!
		if($database['default']['database'] == '%DATABASE%'){
			return TRUE;
		}
		
		//Not first load!
		return FALSE;
		
	}
	
	//FUNC_INSTALL - Installation of the app (PRIV)
	private function _install(){
		
		//Fix for CI throwing a wobbly
		$data = array();
		
		//The following is heavily based on Mike Crittenden's CodeIgniter Installer
		//Ref: https://github.com/mikecrittenden/codeigniter-installer
		
		//If user submitted the form
		if($this->input->post()){
			
			//Load installation model
			$this->load->model('Install_model','Installer');
			
			//Some reassignment and cleanup
			$input = array_map('trim',$this->input->post());
			
			//Validate the post data
			$result = $this->Installer->validate($input,$success);
			if($success == FALSE && !empty($result)){
				$this->_install_error($result,$data);
				return;
			}
			
			//If we get this far the result of validate() is a nice array of gubbins
			$gubbins = $result;
			
			//Attempt to write to timezone file
			//Just a note for anyone wondering why I'm not updating the config item in CI, it's because changing that value did
			//sod all for me? This writes to timezone.php which is then included in index.php
			$error = $this->Installer->write_timezone($gubbins['web_setup']['timezone']);
			if($error != FALSE){
				$this->_install_error($error,$data);
				return;
			}
			
			//Attempt to main config file for base_url()
			$error = $this->Installer->write_main_config($gubbins['web_setup']['url']);
			if($error != FALSE){
				$this->_install_error($error,$data);
				return;
			}
			
			//Attempt to create database if it doesn't exist
			$error = $this->Installer->create_database($gubbins['web_setup']);
			if($error != FALSE){
				$this->_install_error($error,$data);
				return;
			}
			
			//Attempt to create and populate tables
			$error = $this->Installer->create_tables($gubbins['web_setup']);
			if($error != FALSE){
				$this->_install_error($error,$data);
				return;
			}
			
			//Attempt to write to db config file for db connection
			$error = $this->Installer->write_db_config($gubbins['web_setup']);
			if($error != FALSE){
				$this->_install_error($error,$data);
				return;
			}
			
			//We manually override the db here as some systems cache the old temp db config file for some reason
			$dsn = 'mysqli://'.$gubbins['web_setup']['username'].':'.$gubbins['web_setup']['password'].'@'.$gubbins['web_setup']['hostname'].'/'.$gubbins['web_setup']['database'];
			$this->load->database($dsn);
			
			//Attempt to create a user - we do this at this point rather than last because the "first time" load 
			//which determines whether to run the installer depends on the database config being written!
			$this->load->model('User_model','User');
			$insert = $this->User->update($userid = FALSE,$gubbins['user_setup'],$this->config->item('user','webcomic'));
			if(!$insert){
				
				//Attempt to reset the db config so we can have another stab at this!
				$error = $this->Installer->reset_db_config();
				if($error != FALSE){
					$this->_install_error($error,$data);
					return;
				}
				
				//Throw error
				$this->_install_error($error = "User could not be created.",$data);
				return;
				
			}
			
			//Redirect to the login page!
			redirect($gubbins['web_setup']['url'] . "auth/login");
			
		}
		
		//Render installer page
		$this->_render_installer($data);
		return;
		
	}
	
	//FUNC_INSTERR - Handle errors with installation (passes to FUNC_RENDINST) (PRIV)
	private function _install_error($errors,$data){
		
		//String? Convert to array
		if(is_string($errors)){
			$errors = array($errors);
		}
		
		//Add errors to output array
		$data['errors'] = $this->load->view('admin/shared/admin_form_errors',array('errors' => $errors),TRUE);

		//Render installer page
		$this->_render_installer($data);
		return;
		
	}
	
	//FUNC_RENDINST - Render install page (PRIV)
	private function _render_installer($data){
		
		//Set title
		$data['title'] = "Webcomic Installation";
		
		//Set flag
		$data['install'] = TRUE;
		
		//Set assets
		$data['assets'] = $this->config->item('assets','webcomic');
		$data['assets']['css'][] = '/assets/css/auth.css';
		
		//Some items for user creation
		$data['fields'] = $this->config->item('user','webcomic');
		
		//Load first time install form
		$this->load->view('admin/shared/admin_header',$data);
		$this->load->view('install/install_form',$data);
		$this->load->view('admin/shared/admin_footer',$data);
		return;
		
	}

}
