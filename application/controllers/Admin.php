<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	function __construct(){
		
		parent::__construct();

		//Load libraries
		$this->load->library(array('ion_auth','string_manip'));
		
		//You should only be here if logged in!
		if(!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}
		
		//Load Webcomic config
		$this->load->config('webcomic',TRUE);
		
		//Admin disabled?
		if($this->config->item('disable_admin','webcomic') == TRUE){
			redirect(base_url(), 'refresh');
		}
		
		//Set arrays of form configs pulled from config file
		$this->data['user_form'] 	= $this->config->item('user','webcomic');
		$this->data['webcomic'] 	= $this->config->item('comic_settings','webcomic');
		$this->data['page'] 		= $this->config->item('webcomic','webcomic');
		$this->data['chapter'] 		= $this->config->item('chapters','webcomic');
		$this->data['character'] 	= $this->config->item('characters','webcomic');
		$this->data['tag'] 			= $this->config->item('tags','webcomic');
		$this->data['redirect'] 	= $this->config->item('redirects','webcomic');
		$this->data['templates'] 	= $this->config->item('templates','webcomic');
		$this->data['navigation'] 	= $this->config->item('comic_nav','webcomic');
		$this->data['upload_rules'] = $this->config->item('uploads','webcomic');
		
		//Get current user's data
		$this->data['user'] = $this->ion_auth->user()->row();
		
		//Load utility model for all funcs to use
		$this->load->model('Utilities_model','Utilities');
		
		//Load settings model, get current settings
		$this->load->model('Settings_model','Settings');
		$this->data['settings'] = $this->Settings->fetch_site_values();
		
		//Load validation library
		$this->load->library('validation');
		
		//Set assets for all pages
		$this->data['assets'] = $this->config->item('assets','webcomic');
		
	}
	
	//FUNCTION INDEX - Search a function code to skip to that part of the file
	/* 
	 * FUNC_INDEX 	- Admin control panel
	 * FUNC_SA 		- Admin alert view
	 * FUNC_UG 		- Present user guide
	 * 
	 * *** User Management ***
	 * FUNC_CU 		- Create users panel
	 * FUNC_MU 		- Manage users panel - pass in user ID to show that user
	 * FUNC_UU 		- Validate user details and insert/update/delete (AJAX)
	 * 
	 * *** Webcomic Settings ***
	 * FUNC_WS 		- Webcomic settings panel
	 * FUNC_US 		- Validate settings details and update settings (AJAX)
	 * FUNC_UP_SIDE - Set whether the user's sidebar is opened or closed (AJAX)
	 * 
	 * *** Webcomic Appearance ***
	 * FUNC_WA 		- Webcomic appearance panel
	 * FUNC_UT 		- Update webcomic theme (AJAX)
	 *
	 * *** Webcomic Banners ***
	 * FUNC_WBANN 		- Webcomic banner management panel
	 * FUNC_UPBANN 		- Upload a website banner image to server (AJAX)
	 * FUNC_WBANNTABLE 	- Table view for the banners page
	 * FUNC_BANNTOGG 	- Toggle a banner to display on/off (AJAX)
	 * FUNC_DBANN 		- Delete a banner (AJAX)
	 *
	 * *** Webcomic Navigation ***
	 * FUNC_WEBNAV 	- Webcomic navigation panel
	 * FUNC_UN 		- Validate nav details and update navigation (AJAX)
	 * FUNC_UPNB 	- Upload navigation buttons sheet (AJAX)
	 *
	 * *** Webcomic Favicon ***
	 * FUNC_WEBFAV 	- Webcomic favicon panel
	 * FUNC_UPFV 	- Upload favicon (AJAX)
	 * 
	 * *** Comic Page Management ***
	 * FUNC_CP 		- Panel for adding a new comic page
	 * FUNC_MP 		- Manage existing pages panel
	 * FUNC_UCO 	- Validate comic page settings and insert/update (AJAX)
	 * FUNC_UPC 	- Upload a comic page to server (AJAX)
	 * FUNC_MCO 	- Move a comic page i.e. re-order it in sequence (AJAX)
	 * FUNC_DCO 	- Delete a comic page inc. file (AJAX)
	 * FUNC_ABT 	- Panel for editing the "about" page
	 * FUNC_UABO 	- Validate about page details and insert/update (AJAX)
	 * 
	 * *** Chapter Management ***
	 * FUNC_CCH 	- Add a new comic chapter or subchapter
	 * FUNC_MCH 	- Manage chapters
	 * FUNC_UCH 	- Validate chapter settings and insert/update (AJAX)
	 * FUNC_MOCH 	- Move a chapter i.e. re-order it in sequence (AJAX)
	 * FUNC_DCH 	- Delete a chapter (AJAX)
	 * 
	 * *** Characters and Tags Management ***
	 * FUNC_CCHAR 	- Panel for adding a character
	 * FUNC_MCHAR 	- Manage characters
	 * FUNC_UCHAR 	- Validate character settings and insert/update (AJAX)
	 * FUNC_DCHAR 	- Delete a character (AJAX)
	 * FUNC_MOCHAR 	- Move a character i.e. re-order it in profiles sequence (AJAX)
	 * FUNC_UPCHAR 	- Upload a character profile img (AJAX)
	 * FUNC_MTAG 	- Manage tags
	 * FUNC_CTAG 	- Panel for adding a tag
	 * FUNC_PTAG 	- Validate a tag and insert/update (AJAX)
	 * FUNC_DTAG 	- Delete a tag
	 * FUNC_STAG 	- Auto-suggest box for tags (AJAX)
	 * FUNC_NTAG 	- Determine if a page tag is a new one - if so, attempt to create it! (AJAX)
	 * FUNC_CTTC 	- Convert a tag to a character (AJAX)
	 * 
	 * *** Redirect Management ***
	 * FUNC_MRED 	- Redirects management panel
	 * FUNC_CRED 	- Panel for creating a new redirect
	 * FUNC_DRED 	- Delete a redirect (AJAX)
	 * FUNC_PRED 	- Validate redirect settings and insert/update (AJAX)
	 */
	
	//FUNC_INDEX - Admin control panel
	public function index(){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Load logging model
		$this->load->model('Logging_model','Logging');
		
		//Fetch stats
		$this->data['recently_viewed'] 	= $this->Logging->fetch_recently_viewed();
		$this->data['page_views'] 		= $this->Logging->fetch_page_views();
		$this->data['search_terms'] 	= $this->Logging->fetch_search_terms();
		
		//Load admin panel
		$this->load->admin_view('panels/admin_visitor_stats',$this->data);
		
	}
	
	//FUNC_SA - Admin alert view
	public function set_alert($message,$type = "success"){
		
		//Pass in details, output view
		$input = array(
			'message' 	=> $message,
			'type'		=> $type 
		);
		return $this->load->view('admin/shared/admin_alerts',$input,TRUE);
		
	}
	
	//FUNC_UG - Present user guide
	public function manual(){
		
		//Set page title
		$this->data['title'] = "User Manual";
		
		//Load auth config - this is used for grabbing the user timeout for display
		$this->load->config('ion_auth',TRUE);
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Load admin panel
		$this->load->admin_view('panels/admin_user_guide',$this->data);
		
	}
	
	/********** User Management **********/
	
	//FUNC_CU - Create users panel
	public function create_user(){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Set page title
		$this->data['title'] = "Add a New User";
		
		//Set fields
		$this->data['fields'] = $this->data['user_form'];
		
		//Load user management panel
		$this->load->admin_view('user/user_create',$this->data);
		
	}
	
	//FUNC_MU - Manage users panel - pass in user ID to show that user
	public function manage_users($userid = FALSE){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Set page title
		$this->data['title'] = "User Management";
		
		//User selected?
		if($userid != FALSE){
			$this->data['current_userid'] = $this->ion_auth->get_user_id();
			$this->data['user_edit'] = $this->ion_auth->user($userid)->row();
			if(!$this->data['user_edit']){ $this->data['user_edit'] = FALSE; }
		} else {
			$this->data['user_edit'] = FALSE;
			$this->data['users'] = $this->ion_auth->users()->result();
		}
		
		//Set fields
		$this->data['fields'] = $this->data['user_form'];
		
		//Load user management panel
		$this->load->admin_view('user/user_edit',$this->data);
		
	}
	
	//FUNC_UU - Validate user details and insert/update/delete (AJAX)
	//Sorry, I can't stand CI's controller-heavy default form validation so a lot of this uses custom models/libraries
	public function update_user($userid = FALSE,$return_id = FALSE){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//DEBUG
		//print_r($this->input->post());die;
		
		//Load user model
		$this->load->model('User_model','User');
		
		//If box is ticked, just delete the user
		if($this->input->post('delete_user') && $userid != FALSE){
			
			//Attempt
			$delete = $this->User->delete_user($userid);
			if($delete != TRUE){
				$this->data['errors'] = array($delete);
			} else {
				echo $this->set_alert("User deleted successfully!","success");
				return TRUE;
			}
		
		//Full update/insert
		} else {
		
			//Clean the input
			$input = array_map('trim',$this->input->post());
			
			//Validate the user
			$this->data['errors'] = $this->User->validate($input,$this->data['user_form'],$userid);
			
			//If valid, run the update
			if(empty($this->data['errors'])){
				
				//Run
				$update = $this->User->update($userid,$input,$this->data['user_form']);
				
				//No update
				if(!$update){
					
					//Different messages for different users
					if($userid != FALSE){
						$message = "Update did not run.";
					} else {
						$message = "User could not be created.";
					}
					
					//Return an error
					$this->data['errors'] = array($message);
					
				}
				
			}
			
		}
		
		//Present errors
		if(!empty($this->data['errors'])){
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Update
		if($return_id == FALSE){
		
			//Success!
			echo $this->set_alert("User updated successfully!","success");
			return TRUE;
		
		//Create
		} else {
			
			//Return new ID
			echo $update;
			return TRUE;
		
		}
		
	}
	
	/********** Webcomic Settings **********/
	
	//FUNC_WS - Webcomic settings panel
	public function webcomic_settings(){
		
		//Please note that settings are loaded in constructor so no need to specifically load them!
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Set page title
		$this->data['title'] = "Webcomic Settings";
		
		//Set fields
		$this->data['fields'] = $this->data['webcomic'];
		
		//Load settings panel
		$this->load->admin_view('panels/admin_webcomic_settings',$this->data);
		
	}
	
	//FUNC_US - Validate settings details and update settings (AJAX)
	public function update_settings(){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load settings model
		$this->load->model('Settings_model','Settings');
		
		//DEBUG
		//print_r($this->input->post());die;
		
		//Sanity check - input!
		if($this->input->post()){
		
			//Clean the input
			$input = array_map('trim',$this->input->post());
			
			//Validate the settings
			$this->data['errors'] = $this->Settings->validate($input,$this->data['webcomic']);
			
		//No input
		} else {
			
			//Add error
			$this->data['errors'] = array('Settings update could not be performed - input form appears to be empty.');
			
		}
		
		//If valid, run the update
		if(empty($this->data['errors'])){
			
			//Run
			$update = $this->Settings->update($input,$this->data['webcomic']);
			
			//No update
			if(!$update){
				
				//Return an error
				$this->data['errors'] = array('Settings update could not be performed.');
				
			}
			
		}
		
		//Present errors
		if(!empty($this->data['errors'])){
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Success!
		echo $this->set_alert("Settings updated successfully!","success");
		return TRUE;
		
	}
	
	//FUNC_UP_SIDE - Set whether the user's sidebar is opened or closed (AJAX)
	public function update_sidebar($direction){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Validate the sidebar
		if(!$this->validation->in_valid_range($direction,$range = array('OPEN','CLOSED'))){
			$direction = "OPEN";
		}
		
		//Load user model
		$this->load->model('User_model','User');
		
		//Run function
		$this->User->update_siderbar_preference($this->ion_auth->get_user_id(),$direction);
		return;
		
	}
	
	/********** Webcomic Appearance **********/
	
	//FUNC_WA - Webcomic appearance panel
	public function webcomic_appearance(){
		
		//Load settings and templating model
		$this->load->model('Settings_model','Settings');
		$this->load->model('Template_model','Templates');
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Set page title
		$this->data['title'] = "Webcomic Appearance";
		
		//Fetch the site values, get theme
		$settings = $this->Settings->fetch_site_values();
		$this->data['current_template'] = $settings['site_theme'];
		
		//Get other templates
		$this->data['themes'] = $this->Templates->fetch_templates($this->data['templates']);
		
		//Is the current template available? Set to default if it isn't...
		if($this->data['current_template'] != "default" && !$this->Templates->check_theme_exists($this->data['templates'],$this->data['current_template'])){
			$this->data['themes']['invalid'][$this->data['current_template']] = "Selected template '" . $this->data['current_template'] . "' is unavailable, defaulting the theme to 'default' system template.";
			$this->Settings->update($input = array('ste_theme' => "default"),$this->data['webcomic']);
			$this->data['current_template'] = "default";
		}
		
		//Load settings panel
		$this->load->admin_view('panels/admin_webcomic_appearance',$this->data);
		
	}
	
	//FUNC_UT - Update webcomic theme (AJAX)
	public function update_theme($theme){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//DEBUG
		//echo $theme;
		
		//Load settings and templating model
		$this->load->model('Settings_model','Settings');
		$this->load->model('Template_model','Templates');
		
		//Does the theme exist and is it valid?
		if($error = $this->Templates->validate_template($this->data['templates'],$theme,$override = TRUE)){
			$this->data['errors'] = array($error);
		}
		
		//Present errors (if any)
		if(!empty($this->data['errors'])){
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//DEBUG
		//echo "VALIDATES!";
		
		//Update settings to the new theme
		$this->Settings->update($input = array('ste_theme' => $theme),$this->data['webcomic']);
		
		//Feedback
		echo $this->set_alert("Template theme updated successfully!","success");
		return TRUE;
		
	}
	
	/********** Webcomic Banners **********/
	
	//FUNC_WBANN - Webcomic banner management panel
	public function webcomic_banners(){

		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Set page title
		$this->data['title'] = "Webcomic Banners";
		
		//Load settings panel
		$this->load->admin_view('panels/admin_webcomic_banners',$this->data);
		
	}
	
	//FUNC_WBANNTABLE - Table view for the banners page
	public function webcomic_banners_table(){
		
		//Load models
		$this->load->model('Banners_model','Banners');
		
		//Get the banners (if any)
		$this->data['banners'] = $this->Banners->fetch_banners();
		
		//Load banners table
		echo $this->load->view('admin/panels/admin_webcomic_banners_table',$this->data,TRUE);
		
	}
	
	//FUNC_UPBANN - Upload a website banner image to server (AJAX)
	public function upload_banner(){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load models
		$this->load->model('Banners_model','Banners');
		$this->load->model('Settings_model','Settings');
		
		//DEBUG
		//print_r($this->input->post());
		
		//Set file upload type
		$type = "banners";
		
		//Attempt file validation
		if(!$this->Utilities->validate_file($this->data['errors'])){
			
			//Present errors
			if(!empty($this->data['errors'])){
				$this->load->view('admin/shared/admin_form_errors',$this->data);
			}
			
			//Kill func
			return FALSE;
			
		}
		
		//"Slugify" the comic's name for the file name
		$name = $this->Settings->fetch_site_values("name");
		if(!$name){ $name = ""; } else { $name = $this->string_manip->slugify($name) . "_"; }
		$name .= date('YmdHis');
		
		//Set some restrictions...
		$config = $this->data['upload_rules'][$type];
		
		//Do file upload, pass in slugified name
		if(!$upload = $this->Utilities->file_upload($type,$name,$config,$this->data['errors'])){
			
			//Present errors
			if(!empty($this->data['errors'])){
				$this->load->view('admin/shared/admin_form_errors',$this->data);
			}
			
			//Kill func
			return FALSE;
			
		}
		
		//Attempt to save the banner to the db
		if(!$this->Banners->add_new_banner($upload['file_name'])){
			
			//Attempt to remove file
			$this->Utilities->remove_file($type,$upload['file_name']);
			
			//Feedback, kill func
			$this->data['errors'] = array("Banner could not be saved.");
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
			
		}

		//Success!
		echo $this->set_alert("Banner uploaded successfully.","success");
		return TRUE;
		
	}
	
	//FUNC_BANNTOGG - Toggle a banner to display on/off (AJAX)
	public function banner_toggle($bannerid){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load model
		$this->load->model('Banners_model','Banners');
		
		//Validation - attempt to fetch the banner
		$banner = $this->Banners->fetch_banners($bannerid);
		if(!$banner){
			$this->data['errors'] = array("Banner could not be found!");
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Determine the opposite of what the banner is currently set to
		$active 	= "Y";
		$active_msg = "";
		if($banner->banner_active == 'Y'){
			$active 	= "N";
			$active_msg = "not";
		}
		
		//Attempt to update the banner's status
		if(!$this->Banners->update_banner_visibility($bannerid,$active)){
			
			//Feedback
			$this->data['errors'] = array("Banner status could not be saved.");
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
			
		}

		//Success!
		echo $this->set_alert("Banner '" . $banner->filename . "' will " . $active_msg . " display on website.","success");
		return TRUE;
		
	}
	
	//FUNC_DBANN - Delete a banner (AJAX)
	public function delete_banner($bannerid){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load model
		$this->load->model('Banners_model','Banners');
		
		//Validation - attempt to fetch the banner
		$banner = $this->Banners->fetch_banners($bannerid);
		if(!$banner){
			$this->data['errors'] = array('Banner could not be found!');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Attempt file removal if page exists
		if($banner->filename != NULL){
			if(file_exists('./assets/banners/' . $banner->filename)){
				if(!$this->Utilities->remove_file($type="banners",$banner->filename)){
					$this->data['errors'] = array('Banner image file could not be removed from server.');
					$this->load->view('admin/shared/admin_form_errors',$this->data);
					return FALSE;
				}
			}
		}
		
		//Remove from db
		if(!$this->Banners->delete_banner($bannerid)){
			$this->data['errors'] = array('Banner entry could not be removed from the database.');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Success
		echo $this->set_alert("Banner deleted!","success");
		return TRUE;
		
	}
	
	/********** Webcomic Navigation **********/
	
	//FUNC_WEBNAV - Webcomic navigation panel
	public function webcomic_navigation(){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Fetch nav settings - note model is loaded in constructor
		$this->data['nav_settings'] = $this->Settings->fetch_site_nav();
		
		//If buttons file exists, set flag
		$this->data['nav_buttons'] = FALSE;
		if(file_exists('./assets/custom/navigation_buttons.png')){
			$this->data['nav_buttons'] = TRUE;
		}
		
		//Set page title
		$this->data['title'] = "Webcomic Navigation";
		
		//Load settings panel
		$this->load->admin_view('panels/admin_webcomic_navigation',$this->data);
		
	}
	
	//FUNC_UN - Validate nav details and update navigation (AJAX)
	public function update_navigation(){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load settings model
		$this->load->model('Settings_model','Settings');
		
		//DEBUG
		//print_r($this->input->post());die;
		
		//Sanity check - input!
		if($this->input->post()){
		
			//Clean the input
			$input = array_map('trim',$this->input->post());
			
			//Validate the settings
			$this->data['errors'] = $this->Settings->validate_nav($input,$this->data['navigation']);
			
		//No input
		} else {
			
			//Add error
			$this->data['errors'] = array('Navigation settings update could not be performed - input form appears to be empty.');
			
		}
		
		//If valid, run the update
		if(empty($this->data['errors'])){
			
			//Run
			$update = $this->Settings->update_nav($input,$this->data['navigation']);
			
			//No update
			if(!$update){
				
				//Return an error
				$this->data['errors'] = array('Navigation settings update could not be performed.');
				
			}
			
		}
		
		//Present errors
		if(!empty($this->data['errors'])){
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Success!
		echo $this->set_alert("Navigation settings updated successfully!","success");
		return TRUE;
		
	}
	
	//FUNC_UPNB - Upload navigation buttons sheet (AJAX)
	public function upload_nav_buttons(){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//DEBUG
		//print_r($this->input->post());
		
		//Set file upload type
		$type = "custom";
		
		//Attempt file validation
		if(!$this->Utilities->validate_file($this->data['errors'])){
			
			//Present errors
			if(!empty($this->data['errors'])){
				$this->load->view('admin/shared/admin_form_errors',$this->data);
			}
			
			//Kill func
			return FALSE;
			
		}
		
		//Set file name
		$name = "navigation_buttons";
		
		//Set some restrictions...
		$config = $this->data['upload_rules'][$name];
		
		//Get favicon destination...
		$custom_location = $this->config->item('custom_file_paths','webcomic');
		$custom_location = $custom_location['navigation_buttons'];
		
		//Remove existing file
		if(file_exists($custom_location)){
			if(!unlink($custom_location)){
				$this->data['errors'][] = "Existing sprite sheet file cannot be deleted - file permissions may be blocking it!";
				$this->load->view('admin/shared/admin_form_errors',$this->data);
			}
		}
		
		//Do file upload, pass in slugified name
		if(!$upload = $this->Utilities->file_upload($type,$name,$config,$this->data['errors'])){
			
			//Present errors
			if(!empty($this->data['errors'])){
				$this->load->view('admin/shared/admin_form_errors',$this->data);
			}
			
			//Kill func
			return FALSE;
			
		}
		//Success!
		echo $this->set_alert("Buttons uploaded successfully.","success");
		return TRUE;
		
	}
	
	/********** Webcomic Favicon **********/
	
	//FUNC_WEBFAV - Webcomic favicon panel
	public function webcomic_favicon(){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Fetch nav settings - note model is loaded in constructor
		$this->data['nav_settings'] = $this->Settings->fetch_site_nav();
		
		//If buttons file exists, set flag
		$this->data['favicon'] = FALSE;
		$locations = array('./assets/custom/favicon.png','./assets/custom/favicon.ico');
		foreach($locations as $location){
			if(file_exists($location)){
				$this->data['favicon'] = $location;
			}
		}
		
		//Set page title
		$this->data['title'] = "Webcomic Favicon";
		
		//Load settings panel
		$this->load->admin_view('panels/admin_webcomic_favicon',$this->data);
		
	}
	
	//FUNC_UPFV - Upload favicon (AJAX)
	public function upload_favicon(){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load models
		$this->load->model('Settings_model','Settings');
		
		//DEBUG
		//print_r($this->input->post());
		
		//Set file upload type
		$type = "custom";
		
		//Attempt file validation
		if(!$this->Utilities->validate_file($this->data['errors'])){
			
			//Present errors
			if(!empty($this->data['errors'])){
				$this->load->view('admin/shared/admin_form_errors',$this->data);
			}
			
			//Kill func
			return FALSE;
			
		}
		
		//Set file name
		$name = "favicon";
		
		//Set some restrictions...
		$config = $this->data['upload_rules'][$name];
		
		//Get favicon destination...
		$custom_locations = $this->config->item('custom_file_paths','webcomic');
		$custom_locations = $custom_locations['favicon'];
		
		//Remove existing file
		foreach($custom_locations as $location){
			if(file_exists($location)){
				if(!unlink($location)){
					$this->data['errors'][] = "Existing favicon file cannot be deleted - file permissions may be blocking it!";
					$this->load->view('admin/shared/admin_form_errors',$this->data);
				}
			}
		}
		
		//Do file upload, pass in slugified name
		if(!$upload = $this->Utilities->file_upload($type,$name,$config,$this->data['errors'])){
			
			//Present errors
			if(!empty($this->data['errors'])){
				$this->load->view('admin/shared/admin_form_errors',$this->data);
			}
			
			//Kill func
			return FALSE;
			
		}
		//Success!
		echo $this->set_alert("Favicon uploaded successfully.","success");
		return TRUE;
		
	}
	
	/********** Comic Page Management **********/
	
	//FUNC_CP - Panel for adding a new comic page
	public function create_page($pageid = FALSE){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Load models
		$this->load->model('Comic_model','Comic');
		$this->load->model('Chapters_model','Chapters');
		$this->load->model('Characters_model','Characters');
		$this->load->model('Tagging_model','Tagging');
		
		//Set page title
		$this->data['title'] = "Add a New Comic Page";
		
		//Load datepicker and ckeditor
		$this->data['datepicker'] = TRUE;
		$this->data['ckeditor'] = TRUE;
		
		//Set fields
		$this->data['fields'] = $this->data['page'];
		
		//Set view
		$view = "page_create";
		
		//Existing page = fetch details
		if($pageid != FALSE){

			//Check if page exists
			if($page = $this->Comic->fetch_page($filters = array('pageid' => $pageid))){
				
				//Get page nav
				$this->data['nav'] = $this->Comic->fetch_pages_nav($pageid);
				
				//Change title
				$this->data['title'] = "Modify Comic Page";
				
				//Change view
				$view = "page_edit";
				
				//Assign comic data
				$this->data['page'] = $page;
				
				//Fetch any tag-related items
				$this->data['characters_in_page'] 	= $this->Tagging->fetch_page_tags($pageid,$type = "character-all");
				$this->data['tags_in_page'] 		= $this->Tagging->fetch_page_tags($pageid,$type = "tag");
			
			//No page - redirect to page management panel 
			} else {
				redirect($this->session->userdata('last_admin_url'), 'refresh');
			}
			
		}
		
		//Get chapters
		$this->data['chapters'] = $this->Chapters->fetch_all_chapters(FALSE,FALSE);
		
		//Get characters
		$this->data['characters'] = $this->Characters->fetch_all_characters();
		
		//Load page creation panel
		$this->load->admin_view('page/'.$view,$this->data);
		
	}
	
	//FUNC_MP - Manage existing pages panel
	public function manage_pages($offset = 0){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Load comic model
		$this->load->model('Comic_model','Comic');
		
		//Set page title
		$this->data['title'] = "Manage Comic Pages";
		
		//Update page orders
		$this->Comic->set_default_order();
		
		//Get pages with file checks
		$this->data['pages'] = $this->Comic->fetch_valid_pages_in_order(FALSE,FALSE,FALSE);
		
		//DEBUG
		//print_r($this->data['pages']);
		
		//Set the offset
		if(!$offset){
			$offset = 1;
		}
		
		//Set pagination
		$this->data['pagination'] = FALSE;
		if(count($this->data['pages']) > 1){
			
			//Load library
			$this->load->library('pagination');
			
			//Load config
			$this->config->load('pagination',TRUE);
			$config = $this->config->item('admin_pagination','pagination');
			
			//Add config items
			$config['uri_segment'] 		= 3;
			$config['base_url'] 		= base_url() . $this->router->fetch_class() . '/' . $this->router->fetch_method();
			$config['first_url'] 		= $config['base_url'];
			$config['total_rows'] 		= count($this->data['pages']); //Offest is skewed by using page numbers
			$this->pagination->initialize($config);
			
			//Create pagination
			$this->data['pagination'] = $this->pagination->create_links();
			
		}
		
		//Set page offset - we minus 1 to account for an array starting at '0'
		if($offset && $this->data['pages']){
			$this->data['pages'] = array_splice($this->data['pages'],($offset-1),1);
		}
		
		//Show pages
		$this->load->admin_view('page/page_list',$this->data);
		
	}
	
	//FUNC_UCO - Validate comic page settings and insert/update (AJAX)
	public function update_comic($pageid = FALSE,$return_id = FALSE){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load comic model
		$this->load->model('Comic_model','Comic');
		
		//DEBUG
		//print_r($this->input->post());die;
		
		//Sanity check - input!
		if($this->input->post()){
		
			//Clean the input
			$input = $this->string_manip->trimify_array($this->input->post());
			
			//Validate the page
			$this->data['errors'] = $this->Comic->validate($input,$this->data['page']);
			
		//No input
		} else {
			
			//Add error
			$this->data['errors'] = array('Comic page update could not be performed - input form appears to be empty.');
			
		}
		
		//If valid, run the update
		if(empty($this->data['errors'])){
			
			//Run
			$update = $this->Comic->update($pageid,$input,$this->data['page']);
			
			//No update
			if(!$update){
				
				//Return an error
				$this->data['errors'] = array('Comic page update could not be performed.');
				
			}
			
			//Update page orders (in case the page we're updating has moved chapter)
			$this->Comic->set_default_order();
			
		}
		
		//Present errors
		if(!empty($this->data['errors'])){
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Generate sitemap - we evaluate to a var so script waits to execute function before moving to next step!
		$gen = $this->Utilities->generate_sitemap();
		
		//Update
		if($return_id == FALSE){
		
			//Success!
			echo $this->set_alert("Page updated successfully!","success");
			return TRUE;
		
		//Create
		} else {
			
			//Return new ID
			echo $update;
			return TRUE;
		
		}
		
	}
	
	//FUNC_UPC - Upload a comic page to server (AJAX)
	public function upload_comic($pageid){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load comic model
		$this->load->model('Comic_model','Comic');
		
		//DEBUG
		//print_r($this->input->post());
		
		//Set file upload type
		$type = "pages";
		
		//Attempt file validation
		if(!$this->Utilities->validate_file($this->data['errors'])){
			
			//Present errors
			if(!empty($this->data['errors'])){
				$this->load->view('admin/shared/admin_form_errors',$this->data);
			}
			
			//Kill func
			return FALSE;
			
		}
		
		//Fetch the page details
		$page = $this->Comic->fetch_page($filters = array('pageid' => $pageid));
		
		//Remove existing page (if set)
		if($page->filename != NULL){
			if(!$this->Comic->update_page_file($pageid) || !$this->Utilities->remove_file($type,$page->filename)){
				$this->data['errors'] = array("Existing page file could not be deleted.");
				$this->load->view('admin/shared/admin_form_errors',$this->data);
				return FALSE;
			}
		}
		
		//Set some restrictions...
		$config = $this->data['upload_rules'][$type];
		
		//Do file upload, pass in slugified name
		if(!$upload = $this->Utilities->file_upload($type,$page->slug,$config,$this->data['errors'])){
			
			//Present errors
			if(!empty($this->data['errors'])){
				$this->load->view('admin/shared/admin_form_errors',$this->data);
			}
			
			//Kill func
			return FALSE;
			
		}
		
		//Update page name in db
		if(!$this->Comic->update_page_file($pageid,$upload['file_name'])){
			
			//Attempt to remove file
			$this->Utilities->remove_file($type,$upload['file_name']);
			
			//Feedback, kill func
			$this->data['errors'] = array("Page could not be updated.");
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
			
		}
		
		//Success!
		echo $this->set_alert("Page uploaded successfully.","success");
		return TRUE;
		
	}
	
	//FUNC_MCO - Move a comic page i.e. re-order it in sequence (AJAX)
	public function move_comic($pageid,$direction){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load comic model
		$this->load->model('Comic_model','Comic');
		
		//Validate direction
		if(!$direction || !$this->validation->in_valid_range($direction,array("up","down"))){
			$this->data['errors'] = array("Direction of move required!");
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Fetch the page details
		$page = $this->Comic->fetch_page($filters = array('pageid' => $pageid));
		
		//No page!
		if(!$page){
			$this->data['errors'] = array("Page does not exist!");
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Reassign
		$page_order = $page->page_ordering;
		
		//Set the order
		switch($direction){
			case "up":
				$new_order = ($page_order+1);
			break;
			case "down":
				$new_order = ($page_order-1);
			break;
		}
		
		//Order can't be 0, which means we're trying to lower a page more than we should!
		if($new_order <= 0){
			return FALSE;
		}
		
		//Check for displaced page
		$displaced_page = $this->Comic->fetch_page($filters = array('ordering' => $new_order,'chapterid' => $page->chapterid));
		if($displaced_page == FALSE){
			return FALSE;
		}
		
		//Update pages
		if(
			!$this->Comic->update_page_order($page->comicid,$new_order) || 
			!$this->Comic->update_page_order($displaced_page->comicid,$page_order)
		){
			$this->data['errors'] = array('Comic page could not be moved.');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}

		//Success
		echo "Page moved " . $direction . "!";
		return TRUE;
		
	}
	
	//FUNC_DCO - Delete a comic page inc. file (AJAX)
	public function delete_comic($pageid){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load models
		$this->load->model('Comic_model','Comic');
		$this->load->model('Tagging_model','Tagging');
		$this->load->model('Redirects_model','Redirects');
		
		//Fetch the page details
		$page = $this->Comic->fetch_page($filters = array('pageid' => $pageid));
		
		//No page!
		if(!$page){
			$this->data['errors'] = array('Comic page does not exist!');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Attempt removal of any tags
		$this->Tagging->delete_page_tags($pageid);
		
		//Attempt file removal if page exists
		if($page->filename != NULL){
			if(file_exists('./assets/pages/' . $page->filename)){
				if(!$this->Utilities->remove_file($type="pages",$page->filename)){
					$this->data['errors'] = array('Comic page image file could not be removed from server.');
					$this->load->view('admin/shared/admin_form_errors',$this->data);
					return FALSE;
				}
			}
		}
		
		//Remove from db
		if(!$this->Comic->delete_page($pageid)){
			$this->data['errors'] = array('Comic page image file could not be removed from the database.');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Remove any redirects
		$this->Redirects->remove_redirect(FALSE,$redirect = $page->slug);
		
		//Generate sitemap - we evaluate to a var so script waits to execute function before moving to next step!
		$gen = $this->Utilities->generate_sitemap();
		
		//Success
		echo $this->set_alert("Page deleted!","success");
		return TRUE;
		
	}
	
	//FUNC_ABT - Panel for editing the "about" page
	public function about_page(){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Load model
		$this->load->model('Comic_model','Comic');
		
		//Fetch the page details
		$this->data['about'] = $this->Comic->fetch_about_page($this->config->item('about','webcomic'));
		
		//Set page title
		$this->data['title'] = "About the Comic";
		
		//Load ckeditor
		$this->data['ckeditor'] = TRUE;
		
		//Fetch the fields
		$this->data['fields'] = $this->config->item('about','webcomic');
		
		//Load settings panel
		$this->load->admin_view('panels/admin_webcomic_about',$this->data);
		
	}
	
	//FUNC_UABO - Validate about page details and insert/update (AJAX)
	public function update_about(){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load comic model
		$this->load->model('Comic_model','Comic');
		
		//DEBUG
		//print_r($this->input->post());die;
		
		//Sanity check - input!
		if($this->input->post()){
		
			//Clean the input
			$input = $this->string_manip->trimify_array($this->input->post());
			
			//Fetch the fields
			$this->data['fields'] = $this->config->item('about','webcomic');

			//Validate the page
			$this->data['errors'] = $this->Comic->validate_about($input,$this->data['fields']);
			
		//No input
		} else {
			
			//Add error
			$this->data['errors'] = array('About page update could not be performed - input form appears to be empty.');
			
		}
		
		//DEBUG
		//die;
		
		//If valid, run the update
		if(empty($this->data['errors'])){
			
			//Set some hidden data - update timestamp!
			$input['about_updated'] 						= date('Y-m-d H:i:s');
			$this->data['fields']['updated']['db_field'] 	= 'about_updated';
			
			//Run
			$update = $this->Comic->update_about_page($input,$this->data['fields']);
			
			//No update
			if(!$update){
				
				//Return an error
				$this->data['errors'] = array('About page update could not be performed.');
				
			}
			
		}
		
		//Present errors
		if(!empty($this->data['errors'])){
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Success!
		echo $this->set_alert("Page updated successfully!","success");
		return TRUE;
		
	}
	
	/********** Chapter Management **********/
	
	//FUNC_CCH - Add a new comic chapter or subchapter
	public function create_chapter($type = FALSE,$chapterid = FALSE){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Load chapters model
		$this->load->model('Chapters_model','Chapters');
		
		//Default type - move check to model?
		$valid_types = array("chapter","subchapter");
		if($type == FALSE){
			$type = "chapter";
		}
		if(!in_array($type,$valid_types)){
			return FALSE;
		}
		
		//Set title
		$this->data['title'] 	= "Add a New " . ucfirst($type);
		$this->data['type']	= $type;
		
		//Load datepicker and ckeditor
		$this->data['ckeditor'] = TRUE;
		
		//Set fields
		$this->data['fields'] = $this->data['chapter'];
		
		//Set view
		$view = "chapter_create";
		
		//If subchapter, we will need to fetch all the main chapters
		if($type == "subchapter"){
			
			//Fetch
			$this->data['chapters'] = $this->Chapters->fetch_all_main_chapters();
			
			//No chapters? Then you can't create a subchapter without a chapter!
			//Go to that chapter creation screen instead!
			if(!$this->data['chapters']){
				redirect('admin/create_chapter/chapter','refresh');
			}
			
		}
		
		//Existing chapter = fetch details
		if($chapterid != FALSE){
			
			//Check if chapter exists
			if($chapter = $this->Chapters->fetch_chapter($filters = array('chapterid' => $chapterid))){
				
				//Check type matches!
				if($type != $chapter->type){
					redirect('admin/manage_chapters', 'refresh');
				}
				
				//Change title
				$this->data['title'] = "Modify " . ucfirst($type);
				
				//Change view
				$view = "chapter_edit";
				
				//Assign comic data
				$this->data['chapter'] = $chapter;
			
			//No page - redirect to chapter management panel 
			} else {
				redirect('admin/manage_chapters', 'refresh');
			}
			
		}
		
		//Show chapter creation panel
		$this->load->admin_view('chapter/'.$view,$this->data);
		
	}
	
	//FUNC_MCH - Manage chapters
	public function manage_chapters(){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Load chapters model
		$this->load->model('Chapters_model','Chapters');
		
		//Set page title
		$this->data['title'] = "Manage Comic Chapters";
		
		//Update chapter orders - only run if system detects missing values!
		if($this->Chapters->missing_chapter_ordering()){
			$this->Chapters->reorder_all_chapters();
		}
		
		//Get chapters
		$this->data['chapters'] = $this->Chapters->fetch_all_chapters(FALSE,FALSE);
		
		//Show pages
		$this->load->admin_view('chapter/chapter_list',$this->data);
		
	}
	
	//FUNC_UCH - Validate chapter settings and insert/update (AJAX)
	public function update_chapter($chapterid = FALSE,$return_id = FALSE){
	
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Access forbidden";
			return FALSE;
		}
		
		//Load chapters model
		$this->load->model('Chapters_model','Chapters');
		
		//Sanity check - input!
		if($this->input->post()){
		
			//Clean the input
			$input = array_map('trim',$this->input->post());
			
			//Validate the chapter
			$this->data['errors'] = $this->Chapters->validate($input,$this->data['chapter']);
			
		//No input
		} else {
			
			//Add error
			$this->data['errors'] = array('Chapter update could not be performed - input form appears to be empty.');
			
		}
		
		//If valid, run the update
		if(empty($this->data['errors'])){
			
			//Run
			$update = $this->Chapters->update($chapterid,$input,$this->data['chapter']);
			
			//No update
			if(!$update){
				
				//Return an error
				$this->data['errors'] = array('Chapter update could not be performed.');
				
			}
			
		}
		
		//Present errors
		if(!empty($this->data['errors'])){
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Update
		if($return_id == FALSE){
		
			//Success!
			echo $this->set_alert("Chapter updated successfully!","success");
			return TRUE;
		
		//Create
		} else {
			
			//Return new ID
			echo $update;
			return TRUE;
		
		}
		
	}
	
	//FUNC_MOCH - Move a chapter i.e. re-order it in sequence (AJAX)
	public function move_chapter($chapterid,$direction){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load chapters model
		$this->load->model('Chapters_model','Chapters');
		
		//Validate direction
		if(!$direction || !$this->validation->in_valid_range($direction,array("up","down"))){
			$this->data['errors'] = array('Direction of move required!');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Fetch the page details
		$chapter = $this->Chapters->fetch_chapter($filters = array('chapterid' => $chapterid));
		
		//No chapter!
		if(!$chapter){
			$this->data['errors'] = array('Chapter does not exist!');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Reassign
		$chapter_order = $chapter->chapter_ordering;
		
		//Set the order
		switch($direction){
			case "down":
				$new_order = ($chapter_order-1);
			break;
			case "up":
				$new_order = ($chapter_order+1);
			break;
		}
		
		//Order can't be 0, which means we're trying to lower a chapter more than we should!
		if($new_order <= 0){
			return FALSE;
		}
		
		//Set filters array
		$filters = array(
			'type' => $chapter->type,
			'order' => $new_order
		);
		
		//To fetch a subchapter we need the main chapter id
		if($chapter->type == "subchapter"){
			$filters['main_chapterid'] = $chapter->masterid;
		}
		
		//Check for displaced page
		$displaced_chapter = $this->Chapters->fetch_chapter($filters);
		if($displaced_chapter == FALSE){
			return FALSE;
		}
		
		//DEBUG
		/*if($new_order <= 0 || $new_order == $chapter_order || $new_order > 3){
			echo "Current:";
			print_r($chapter);
			echo "<br />Displaced:";
			print_r($displaced_chapter);
			echo "<br />" . $chapter_order . " " . $new_order; die;
		}*/
		
		//Update pages
		if(
			!$this->Chapters->update_chapter_order($chapter->chapterid,$new_order) || 
			!$this->Chapters->update_chapter_order($displaced_chapter->chapterid,$chapter_order)
		){
			$this->data['errors'] = array('Comic chapter could not be moved.');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Success
		echo "Chapter moved " . $direction . "!";
		return TRUE;
		
	}
	
	//FUNC_DCH - Delete a chapter (AJAX)
	public function delete_chapter($chapterid){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load comic/chapters models
		$this->load->model('Comic_model','Comic');
		$this->load->model('Chapters_model','Chapters');
		
		//Fetch the chapter details
		$chapter = $this->Chapters->fetch_chapter($filters = array('chapterid' => $chapterid));
		
		//No page!
		if(!$chapter){
			$this->data['errors'] = array('Comic chapter does not exist!');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Get pages per chapter
		$pages = $this->Comic->fetch_all_pages(FALSE,$chapterid);
		
		//DEBUG
		//print_r($pages);die;
		
		//If this is a main chapter, remove the underlings!
		if($chapter->type == "chapter"){
			
			//Loop through pages (if any) and update chapter ID to NULL
			if($pages){
				foreach($pages as $page){
					$this->Comic->update_page_chapter($page->comicid);
				}
			}
			
			//Fetch subchapters
			$subs = $this->Chapters->fetch_all_subchapters($chapterid);
			
			//If subchapters, loop...
			if($subs){
				foreach($subs as $sub){
					
					//Fetch pages
					$pages = $this->Comic->fetch_all_pages(FALSE,$sub->chapterid);
					
					//Update pages subchapter ID to NULL
					if($pages){
						foreach($pages as $page){
							$this->Comic->update_page_chapter($page->comicid);
						}
					}
					
					//Try deleting
					if(!$this->Chapters->delete_chapter($sub->chapterid)){
						$this->data['errors'] = array('A subchapter of the deleted chapter could not be removed from the database.');
						$this->load->view('admin/shared/admin_form_errors',$this->data);
						return FALSE;
					}
					
				}
			}
		
		//Subchapter = need to reassign all subchapter pages to main chapter
		} elseif($chapter->type == "subchapter"){
			
			//Loop through pages (if any) and update chapter ID
			if($pages){
				foreach($pages as $page){
					$this->Comic->update_page_chapter($page->comicid,$chapter->masterid);
				}
			}
			
		}
		
		//Remove from db
		if(!$this->Chapters->delete_chapter($chapterid)){
			$this->data['errors'] = array('The chapter could not be removed from the database.');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Success
		echo $this->set_alert("Chapter deleted!","success");
		return TRUE;
		
	}
	
	/********** Characters and Tags Management **********/
    
	//FUNC_CCHAR - Panel for adding a character
	public function create_character($characterid = FALSE){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Load characters model
		$this->load->model('Characters_model','Characters');
		
		//Set page title
		$this->data['title'] = "Add a New Character";
		
		//Load datepicker and ckeditor
		$this->data['ckeditor'] = TRUE;
		
		//Set fields
		$this->data['fields'] = $this->data['character'];
		
		//Set view
		$view = "character_create";
		
		//Existing chracters = fetch details
		if($characterid != FALSE){
			
			//Check if page exists
			if($chr = $this->Characters->fetch_character($filters = array('characterid' => $characterid))){
				
				//Change title
				$this->data['title'] = "Modify Character - " . $chr->name;
				
				//Change view
				$view = "character_edit";
				
				//Assign comic data
				$this->data['character'] = $chr;
			
			//No page - redirect to page management panel 
			} else {
				redirect($this->session->userdata('last_admin_url'), 'refresh');
			}
			
		}
		
		//Load character creation panel
		$this->load->admin_view('character/'.$view,$this->data);
		
	}
	
	//FUNC_MCHAR - Manage characters
	public function manage_characters(){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Load characters model
		$this->load->model('Characters_model','Characters');
		
		//Set page title
		$this->data['title'] = "Manage Comic Characters";
		
		//Update character orders - only run if system detects missing values!
		if($this->Characters->missing_character_ordering()){
			$this->Characters->reorder_all_characters();
		}
		
		//Verify character profile images are "intact"
		$this->Characters->verify_profileimg_integrity();
		
		//Get characters
		$this->data['characters'] = $this->Characters->fetch_all_characters();
		
		//Show characters
		$this->load->admin_view('character/character_list',$this->data);
		
	}
	
	//FUNC_UCHAR - Validate character settings and insert/update (AJAX)
	public function update_character($characterid = FALSE,$return_id = FALSE){
	
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load characters model
		$this->load->model('Characters_model','Characters');
		
		//Sanity check - input!
		if($this->input->post()){
		
			//Clean the input
			$input = array_map('trim',$this->input->post());
		
			//Validate the character
			$this->data['errors'] = $this->Characters->validate($input,$this->data['character']);
		
		//No input
		} else {
			
			//Add error
			$this->data['errors'] = array('Character update could not be performed - input form appears to be empty.');
			
		}
		
		//If valid, run the update
		if(empty($this->data['errors'])){
			
			//Run
			$update = $this->Characters->update($characterid,$input,$this->data['character']);
			
			//No update
			if(!$update){
				
				//Return an error
				$this->data['errors'] = array('Character update could not be performed.');
				
			}
			
		}
		
		//Present errors
		if(!empty($this->data['errors'])){
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Generate sitemap - we evaluate to a var so script waits to execute function before moving to next step!
		$gen = $this->Utilities->generate_sitemap();
		
		//Update
		if($return_id == FALSE){
		
			//Success!
			echo $this->set_alert("Character updated successfully!","success");
			return TRUE;
		
		//Create
		} else {
			
			//Return new ID
			echo $update;
			return TRUE;
		
		}
		
	}
	
	//FUNC_DCHAR - Delete a character (AJAX)
	public function delete_character($characterid){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load models
		$this->load->model('Characters_model','Characters');
		$this->load->model('Redirects_model','Redirects');
		
		//Fetch the chapter details
		$character = $this->Characters->fetch_character($filters = array('characterid' => $characterid));
		
		//No page!
		if(!$character){
			$this->data['errors'] = array('Character does not exist!');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Attempt file removal if profile img exists
		if($character->filename != NULL){
			if(!$this->Utilities->remove_file($type="characters",$character->filename)){
				$this->data['errors'] = array('Character profile image file could not be removed from server.');
				$this->load->view('admin/shared/admin_form_errors',$this->data);
				return FALSE;
			}
		}
		
		//Remove from db
		if(!$this->Characters->delete_character($characterid)){
			$this->data['errors'] = array('The character could not be removed from the database.');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Remove any redirects
		$this->Redirects->remove_redirect(FALSE,$redirect = $character->slug,FALSE,'character');
		
		//Generate sitemap - we evaluate to a var so script waits to execute function before moving to next step!
		$gen = $this->Utilities->generate_sitemap();
		
		//Success
		echo $this->set_alert("Character deleted!","success");
		return TRUE;
		
	}
	
	//FUNC_MOCHAR - Move a character i.e. re-order it in profiles sequence (AJAX)
	public function move_character($characterid,$direction){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load characters model
		$this->load->model('Characters_model','Characters');
		
		//Validate direction
		if(!$direction || !$this->validation->in_valid_range($direction,array("up","down"))){
			$this->data['errors'] = array('Direction of move required!');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Fetch the page details
		$character = $this->Characters->fetch_character($filters = array('characterid' => $characterid));
		
		//No chapter!
		if(!$character){
			$this->data['errors'] = array('Character does not exist!');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Reassign
		$character_order = $character->character_ordering;
		
		//Set the order
		switch($direction){
			case "down":
				$new_order = ($character_order+1);
			break;
			case "up":
				$new_order = ($character_order-1);
			break;
		}
		
		//Order can't be 0, which means we're trying to lower a chapter more than we should!
		if($new_order <= 0){
			return FALSE;
		}
		
		//Set filters array
		$filters = array('order' => $new_order);
		
		//Check for displaced page
		$displaced_character = $this->Characters->fetch_character($filters);
		if($displaced_character == FALSE){
			return FALSE;
		}
		
		//DEBUG
		/*if($new_order <= 0 || $new_order == $character_order || $new_order > 3){
			echo "Current:";
			print_r($character);
			echo "<br />Displaced:";
			print_r($displaced_character);
			echo "<br />" . $character_order . " " . $new_order; die;
		}*/
		
		//Update pages
		if(
			!$this->Characters->update_character_order($character->characterid,$new_order) || 
			!$this->Characters->update_character_order($displaced_character->characterid,$character_order)
		){
			$this->data['errors'] = array('Character could not be moved.');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Success
		echo "Character moved " . $direction . "!";
		return TRUE;
		
	}
	
	//FUNC_UPCHAR - Upload a character profile img (AJAX)
	public function upload_profile_img($characterid){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load characters model
		$this->load->model('Characters_model','Characters');
		
		//DEBUG
		//print_r($this->input->post());
		
		//Set file upload type
		$type = "characters";
		
		//Attempt file validation
		if(!$this->Utilities->validate_file($this->data['errors'])){
			
			//Present errors
			if(!empty($this->data['errors'])){
				$this->load->view('admin/shared/admin_form_errors',$this->data);
			}
			
			//Kill func
			return FALSE;
			
		}
		
		//Fetch the character details
		$character = $this->Characters->fetch_character($filters = array('characterid' => $characterid));
		
		//Remove existing character (if set)
		if($character->filename != NULL){
			if(!$this->Characters->update_profileimg_file($characterid) || !$this->Utilities->remove_file($type,$character->filename)){
				$this->data['errors'] = array("Existing profile image file could not be deleted.");
				$this->load->view('admin/shared/admin_form_errors',$this->data);
				return FALSE;
			}
		}
		
		//Set some restrictions...
		$config = $this->data['upload_rules']['profile_img'];
		
		//Do file upload, pass in slugified name
		if(!$upload = $this->Utilities->file_upload($type,$character->slug,$config,$this->data['errors'])){
			
			//Present errors
			if(!empty($this->data['errors'])){
				$this->load->view('admin/shared/admin_form_errors',$this->data);
			}
			
			//Kill func
			return FALSE;
			
		}
		
		//Update page name in db
		if(!$this->Characters->update_profileimg_file($characterid,$upload['file_name'])){
			
			//Attempt to remove file
			$this->Utilities->remove_file($type,$upload['file_name']);
			
			//Feedback, kill func
			$this->data['errors'] = array("Profile image could not be updated.");
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
			
		}
		
		//Success!
		echo $this->set_alert("Profile image uploaded successfully.","success");
		return TRUE;
		
	}
	
	//FUNC_MTAG - Manage tags
	public function manage_tags(){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Load tags model
		$this->load->model('Tagging_model','Tagging');
		
		//Set page title
		$this->data['title'] = "Manage Comic Tags";
		
		//Get characters
		$this->data['tags'] = $this->Tagging->fetch_all_tags($cnt = TRUE);
		
		//Show characters
		$this->load->admin_view('tag/tag_list',$this->data);
		
	}
	
	//FUNC_CTAG - Panel for adding a tag
	public function create_tag($tagid = FALSE){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Set page title
		$this->data['title'] = "Add a New Tag";
		
		//Set fields
		$this->data['fields'] = $this->data['tag'];
		
		//Set view
		$view = "tag_create";
		
		//Existing chracters = fetch details
		if($tagid != FALSE){
			
			//Load model
			$this->load->model('Tagging_model','Tagging');
			
			//Check if tag exists
			if($tag = $this->Tagging->fetch_tag($tagid)){

				//Change title
				$this->data['title'] = "Modify Tag - " . $tag->label;
				
				//Change view
				$view = "tag_edit";
				
				//Assign comic data
				$this->data['tag'] = $tag;
			
			//No page - redirect to page management panel 
			} else {
				redirect($this->session->userdata('last_admin_url'), 'refresh');
			}
			
		}
		
		//Load character creation panel
		$this->load->admin_view('tag/'.$view,$this->data);
		
	}
	
	//FUNC_PTAG - Validate a tag and insert/update (AJAX)
	public function process_tag($tagid = FALSE){
	
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load tagging model
		$this->load->model('Tagging_model','Tagging');
		
		//Sanity check - input!
		if($this->input->post()){
		
			//Clean the input
			$input = array_map('trim',$this->input->post());
		
			//Validate the character
			$this->data['errors'] = $this->Tagging->validate($input,$this->data['tag']);
		
		//No input
		} else {
			
			//Add error
			$this->data['errors'] = array('Tag creation could not be performed - input form appears to be empty.');
			
		}
		
		//If valid, run the update
		if(empty($this->data['errors'])){
			
			//Run
			if($tagid == FALSE){
				$create = $this->Tagging->add_new_tag($input['tags_tag']);
			} else {
				$create = $this->Tagging->update_tag($tagid,$input['tags_tag']);
			}
			
			//No creation
			if(!$create){
				
				//Return an error
				$this->data['errors'] = array('Tag could not be processed.');
				
			}
			
		}
		
		//Present errors
		if(!empty($this->data['errors'])){
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Success!
		echo $this->set_alert("Tag successfully created!","success");
		return TRUE;
		
	}
	
	//FUNC_DTAG - Delete a tag
	public function delete_tag($tagid){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load tagging model
		$this->load->model('Tagging_model','Tagging');
		
		//Fetch the tag
		$tag = $this->Tagging->fetch_tag($tagid);
		
		//DEBUG
		//echo "Error:";print_r($tag);die;
		
		//No tag!
		if(!$tag){
			$this->data['errors'] = array('Tag does not exist!');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Remove the tag
		if(!$this->Tagging->remove_tag($tagid)){
			$this->data['errors'] = array('The tag could not be removed from the database.');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Generate sitemap - we evaluate to a var so script waits to execute function before moving to next step!
		$gen = $this->Utilities->generate_sitemap();
		
		//Success
		echo $this->set_alert("Tag deleted!","success");
		return TRUE;
		
	}
	
	//FUNC_STAG - Auto-suggest box for tags (AJAX)
	public function search_tags(){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load tagging model
		$this->load->model('Tagging_model','Tagging');
		
		//DEBUG
		//print_r($this->input->post());
		
		//Sanity check - input!
		if(!$this->input->post('tag')){
			return FALSE;
		} else {
			$tag = $this->input->post('tag');
		}
		
		//Attempt matches
		$matches = $this->Tagging->search_tags($tag);
		
		//No matches = nothing to show
		if(!$matches){
			return FALSE;
		} else {
			$this->load->view('/admin/tag/tag_autosuggest',$input = array('matches' => $matches));
		}
		
		return;
		
	}
	
	//FUNC_NTAG - Determine if a page tag is a new one - if so, attempt to create it! (AJAX)
	public function is_tag_new(){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load tagging model
		$this->load->model('Tagging_model','Tagging');
		
		//DEBUG
		//print_r($this->input->post());
		
		//Sanity check - input!
		if($this->input->post()){
		
			//Clean the input
			$input = array_map('trim',$this->input->post());
		
			//Does tag exist?
			$match = $this->Tagging->fetch_tag(FALSE,$input['tags_tag']);
			
			//Set tag ID
			$tagid = FALSE;
			
			//New tag
			if(!$match){
				
				//Validate the character
				$this->data['errors'] = $this->Tagging->validate($input,$this->data['tag']);
				
				//If valid, run the update
				if(empty($this->data['errors'])){
					
					//Run
					$tagid = $this->Tagging->add_new_tag($input['tags_tag']);
					
					//No creation
					if(!$tagid){
						
						//Return an error
						$this->data['errors'] = array('New tag could not be created.');
						
					}
					
				}
				
			//Existing tag - reassign ID
			} else {
				
				$tagid = $match->tagid;
			
			}

		//No input
		} else {
			
			//Add error
			$this->data['errors'] = array('Tag creation could not be performed - input form appears to be empty.');
			
		}

		//Present errors
		if(!empty($this->data['errors'])){
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//No ID...
		if(!$tagid){
			$this->data['errors'] = array('Tag creation could not be performed - tag ID could not be retrieved.');
		}
		
		//Success!
		echo $tagid;
		return TRUE;

	}
	
	//FUNC_CTTC - Convert a tag to a character (AJAX)
	public function convert_tag_to_character($tagid = FALSE){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Tag ID required
		if(!$tagid || !ctype_digit($tagid)){
			$this->data['errors'] = array('Tag could not be converted - parameter is missing.');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Load tagging model
		$this->load->model('Tagging_model','Tagging');
		
		//Fetch the tag
		$tag = $this->Tagging->fetch_tag($tagid);
		
		//DEBUG
		//echo "Error:";print_r($tag);die;
		
		//No tag!
		if(!$tag){
			$this->data['errors'] = array('Tag does not exist!');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Load character model
		$this->load->model('Characters_model','Character');
		
		//Setup character array
		$character = array(
			'character_name' 	=> $tag->label,
			'character_active'	=> 'Y'
		);
		
		//Create new character
		$create = $this->Character->update(FALSE,$character,$fields = $this->data['character']);
		
		//No creation!
		if(!$create){
			$this->data['errors'] = array('Character could not be created from tag details.');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Update tag links
		$this->Tagging->update_tag_links($create,$tag->tagid,'character','tag');
		
		//Remove redirects
		$this->load->model('Redirects_model','Redirects');
		$this->Redirects->remove_redirect(FALSE,$tag->slug,FALSE,$type = "tag");
		
		//Remove the tag!
		$this->Tagging->remove_tag($tagid);
		
		//Done!
		echo $this->set_alert("Tag successfully converted to a character!","success");
		return TRUE;
		
		
	}
	
	/********** Redirect Management **********/
	
	//FUNC_MRED - Redirects management panel
	public function manage_redirects(){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Load redirects model
		$this->load->model('Redirects_model','Redirects');
		
		//Set page title
		$this->data['title'] = "Manage Redirects";
		
		//Get redirects
		$this->data['redirects'] = $this->Redirects->fetch_all_redirects();
		
		//Show characters
		$this->load->admin_view('redirect/redirect_list',$this->data);
		
	}
	
	//FUNC_CRED - Panel for creating a new redirect
	public function create_redirect(){
		
		//Capture current URL
		$this->session->set_userdata('last_admin_url',current_url());
		
		//Load redirects model
		$this->load->model('Redirects_model','Redirects');
		
		//Set page title
		$this->data['title'] = "Add a New Redirect";
		
		//Set fields
		$this->data['fields'] = $this->data['redirect'];
		
		//Load page creation panel
		$this->load->admin_view('redirect/redirect_create',$this->data);
		
	}
		
	//FUNC_DRED - Delete a redirect (AJAX)
	public function delete_redirect($redirectid){
		
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Error: access forbidden";
			return FALSE;
		}
		
		//Load redirects model
		$this->load->model('Redirects_model','Redirects');
		
		//Fetch the redirect
		$redirect = $this->Redirects->fetch_redirect($redirectid);
		
		//DEBUG
		//echo "Error:";print_r($redirect);die;
		
		//No redirect!
		if(!$redirect){
			$this->data['errors'] = array('Redirect does not exist!');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Remove the redirect
		if(!$this->Redirects->remove_redirect($redirectid,FALSE,FALSE,$redirect->type)){
			$this->data['errors'] = array('The redirect could not be removed from the database.');
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Success
		echo $this->set_alert("Redirect deleted!","success");
		return TRUE;
		
	}
	
	//FUNC_PRED - Validate redirect settings and insert/update (AJAX)
	public function process_redirect(){
	
		//Check for AJAX request - kill if false
		if($this->validation->is_ajax_request() == FALSE){
			echo "Access forbidden";
			return FALSE;
		}
		
		//Load redirects model
		$this->load->model('Redirects_model','Redirects');
		
		//Sanity check - input!
		if($this->input->post()){
		
			//Clean the input
			$input = array_map('trim',$this->input->post());
		
			//Validate the character
			$this->data['errors'] = $this->Redirects->validate($input,$this->data['redirect']);
		
		//No input
		} else {
			
			//Add error
			$this->data['errors'] = array('Redirect creation could not be performed - input form appears to be empty.');
			
		}
		
		//If valid, run the update
		if(empty($this->data['errors'])){
			
			//Run
			$create = $this->Redirects->add_new_redirect($input['redirect_type'],$input['redirect_url'],$input['redirect_redirect']);
			
			//No creation
			if(!$create){
				
				//Return an error
				$this->data['errors'] = array('Redirection could not be created.');
				
			}
			
		}
		
		//Present errors
		if(!empty($this->data['errors'])){
			$this->load->view('admin/shared/admin_form_errors',$this->data);
			return FALSE;
		}
		
		//Success!
		echo $this->set_alert("Redirect successfully created!","success");
		return TRUE;
		
	}
	
}
