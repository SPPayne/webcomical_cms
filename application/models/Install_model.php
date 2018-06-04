<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

//The following is heavily based on Mike Crittenden's CodeIgniter Installer
//Ref: https://github.com/mikecrittenden/codeigniter-installer

class Install_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	
	//FUNCTION INDEX - Search a function code to skip to that part of the file
	/* CREATE:
	 * FUNC_CREATEDB 	- Function to the database and tables and fill them with the default data
	 * FUNC_CREATETAB 	- Function to create the tables and fill them with the default data
	 * 
	 * READ:
	 * FUNC_VAL 		- Function to validate the post data
	 * 
	 * UPDATE:
	 * FUNC_WTZ 		- Writes the contents of timezone.php
	 * FUNC_WBU 		- Writes some contents to config file, including base URL
	 * FUNC_DBCONFIG 	- Function to write the db config file
	 * FUNC_RESDBCONF 	- Resets the database config to its "pre-updated" state
	 * 
	 * DESTROY:
	 *
	 */
	
	/***** CREATE *****/
	
	//FUNC_CREATEDB - Function to the database and tables and fill them with the default data
	public function create_database($data){
		
		//Connect to the database
		//Ref: https://stackoverflow.com/questions/15553496/new-mysqli-how-to-intercept-an-unable-to-connect-error
		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
			$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],'');
		} catch (Exception $e ){
			return "Cannot connect to MySQL with provided credentials.";
		}

		//Check for errors
		if($mysqli->connect_error){
			return "Cannot connect to MySQL with provided credentials.";
		}

		//Create the prepared statement
		$mysqli->query("CREATE DATABASE IF NOT EXISTS " . $data['database']);

		//Close the connection
		$mysqli->close();

		//End!
		return FALSE;
		
	}
	
	//FUNC_CREATETAB - Function to create the tables and fill them with the default data
	public function create_tables($data){
		
		//Connect to the database
		//Ref: https://stackoverflow.com/questions/15553496/new-mysqli-how-to-intercept-an-unable-to-connect-error
		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
			$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);
		} catch (Exception $e ){
			return "Cannot connect to MySQL with provided credentials.";
		}

		//Check for errors
		if($mysqli->connect_error){
			return "Cannot connect to MySQL with provided credentials.";
		}

		//Open the default SQL file
		$path 	= './application/views/install/webcomic.sql';
		$query 	= file_get_contents($path);
		if(!$query){
			return "Could not fetch installation SQL from following path: " . trim($path,'.') . " - file may be missing!";
		}

		//Execute a multi query
		//Ref: https://stackoverflow.com/questions/14715889/strict-standards-mysqli-next-result-error-with-mysqli-multi-query
		$cumulative_rows = 0;
		if($mysqli->multi_query($query)){
			//Prevents PHP from continuing until db queries have ran!
			do {
				$cumulative_rows += $mysqli->affected_rows;
			} while($mysqli->more_results() && $mysqli->next_result());
		}
		
		if($error_mess = $mysqli->error){
			return "Error: " . $mysqli->error;
		}

		//Close the connection
		$mysqli->close();
			
		//End!
		return FALSE;

	}
	
	/***** READ *****/
	
	//FUNC_VAL - Function to validate the post data
	public function validate($input,&$success){
		
		//Set flag
		$success = FALSE;
		
		//Set error array
		$errors = array();
		
		//Sanity check!
		if(!$input || empty($input)){
			$errors[] = "Input is missing!";
			return $errors;
		}
		
		//Seperate out the website setup from the user setup
		$setup = array(
			'web_setup' 	=> array(),
			'user_setup' 	=> array()
		);
		foreach($input as $key => $value){
			if(stristr($key,'usr')){
				$setup['user_setup'][$key] = $value;
			} else {
				$setup['web_setup'][$key] = $value;
			}
		}
		
		//DEBUG
		//print_r($setup);die;
		
		//Load the user model to validate the user
		$this->load->model('User_model','User');
		
		//Validate
		$this->load->config('webcomic',TRUE);
		$user_errors = $this->User->validate($setup['user_setup'],$this->config->item('user','webcomic'),$userid = FALSE,$install = TRUE);
		
		//Any errors? Add 'em to the array!
		if(!empty($user_errors)){
			$errors = $user_errors;
		}
		
		//Load validation library
		$this->load->library('validation');
		
		//Loop the web setup input
		foreach($setup['web_setup'] as $key => $value){
			
			//Note password is optional! We also do minimal checking here as we're going to assume user is competent
			switch($key){
				case "username":
					
					//Check required value
					if(!$this->validation->exist_check($value)){
						$errors[] = ucfirst($key) . " is required.";
					}
					
				break;
				case "database":
					
					//Format
					$value 						= strtolower($value);
					$setup['web_setup'][$key] 	= $value;
					
					//Check required value
					if(!$this->validation->exist_check($value)){
						
						$errors[] = ucfirst($key) . " is required.";
						
					} else {
						
						//Alphanumeric (with allowed punctuation)
						if(!$this->validation->is_alphanumeric($value,$allowed = array('_'))){
							$errors[] = ucfirst($key) . " - letters, numbers and underscores only.";
						}
						
					}
					
				break;
				case "url":
					
					//Check required value
					if(!$this->validation->exist_check($value)){
						
						$errors[] = ucfirst($key) . " is required.";
					
					} else {
						
						//URL needs to be...well, a URL!
						if(!$this->validation->is_url($value)){
							$errors[] = "URL is not in a valid format!";
						}
						
						//Get this far, format the URL to have a slash on the end
						$setup['web_setup'][$key] = trim($value,'/') . '/';
						
					} 
					
				break;
				case "hostname":
				
					//Check required value
					if(!$this->validation->exist_check($value)){
						
						$errors[] = ucfirst($key) . " is required.";
					
					} else {
						
						//Hostname needs to be...a speckled chicken. What do you think it needs to be?
						if(!$this->validation->is_hostname($value)){
							$errors[] = "Hostname is not in a valid format!";
						}
						
					}
					
				break;
				case "timezone":
				
					//Check required value
					if(!$this->validation->exist_check($value)){
						
						$errors[] = ucfirst($key) . " is required.";
					
					} else {
						
						//Timezone needs to be...well, a zone of time.
						$timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
						if(!$this->validation->in_valid_range($value,$timezones)){
							$errors[] = "Timezone is not set to a recognised or valid value!";
						}
						
					} 
				
				break;
			}
			
		}
		
		//DEBUG
		//print_r($errors);die;
		//$errors[] = "TEST";
		
		//No errors
		if(empty($errors)){
			$success = TRUE;
			return $setup;
		}
		
		//Errors
		return $errors;
		
	}
	
	/***** UPDATE *****/
	
	//FUNC_WTZ - Writes the contents of timezone.php
	public function write_timezone($timezone){
		
		//File path
		$timezone_file = './timezone.php';
		
		//File not writable, attempt to chmod
		if(!is_writable($timezone_file)){
			@chmod($timezone_file,0777);
		}
		
		//If it's still not writable, throw an error!
		if(!is_writable($timezone_file)){
			return "File is not writable at " . trim($timezone_file,'.');
		}
		
		//File content is a one-liner
		$file_contents = "<?php date_default_timezone_set('" . $timezone . "'); ?>";
		
		//Write the new database.php file
		$handle = fopen($timezone_file,'w+');
		
		//Write the file
		if(!fwrite($handle,$file_contents)){
			return "File cannot be updated at " . trim($timezone_file,'.');
		}
		
		//Return the config file to proper permissions
		@chmod($timezone_file,0644);
		
		//No problems!
		return FALSE;
		
	}
	
	//FUNC_WBU - Writes some contents to config file, including base URL
	public function write_main_config($url){
		
		//Config path
		$config_file = './application/config/config.php';
		
		//File not writable, attempt to chmod
		if(!is_writable($config_file)){
			@chmod($config_file,0777);
		}
		
		//If it's still not writable, throw an error!
		if(!is_writable($config_file)){
			return "File is not writable at " . trim($config_file,'.');
		}
		
		//Attempt to fetch contents
		$config = file_get_contents($config_file);
		if(!$config){
			return "Cannot fetch file from " . trim($config_file,'.') . " - permissions may be too strict!";
		}
		
		//Replacement - base URL
		$new = str_replace('$config[\'base_url\'] = \'\';','$config[\'base_url\'] = \'' . $url . '\';',$config);
		
		//Replacement - encryption key
		//Ref: https://www.codeigniter.com/user_guide/libraries/encryption.html (I assume I'm doing this right!)
		$this->load->library('encryption');
		$key = base64_encode(str_ireplace("'",'',$this->encryption->create_key(16)));
		$new = str_replace('$config[\'encryption_key\'] = \'\';','$config[\'encryption_key\'] = \'' . base64_decode($key) . '\';',$new);
		
		//Replacement - cookie domain
		$domain = parse_url($url);
		$new 	= str_replace('$config[\'cookie_domain\'] = \'\';','$config[\'cookie_domain\'] = \'.' . $domain['host'] . '\';',$new);
		
		//Write the new config file
		$handle = fopen($config_file,'w+');
		
		//Write the file
		if(!fwrite($handle,$new)){
			return "File cannot be updated at " . trim($config_file,'.');
		}
		
		//Return the config file to proper permissions
		@chmod($config_file,0644);
		
		//No problems!
		return FALSE;
		
	}
	
	//FUNC_DBCONFIG - Function to write the db config file
	public function write_db_config($data){

		//Config path
		$config_file = './application/config/database.php';

		//File not writable, attempt to chmod
		if(!is_writable($config_file)){
			@chmod($config_file,0777);
		}
		
		//If it's still not writable, throw an error!
		if(!is_writable($config_file)){
			return "File is not writable at " . trim($config_file,'.');
		}
		
		//Open the file
		$database_file = file_get_contents($config_file);
		if(!$database_file){
			return "Cannot fetch file from " . trim($config_file,'.') . " - permissions may be too strict!";
		}
		
		//Replacements
		$new	= str_replace("%HOSTNAME%",$data['hostname'],$database_file);
		$new	= str_replace("%USERNAME%",$data['username'],$new);
		$new	= str_replace("%PASSWORD%",$data['password'],$new);
		$new	= str_replace("%DATABASE%",$data['database'],$new);

		//Write the new database.php file
		$handle = fopen($config_file,'w+');
		
		//Write the file
		if(!fwrite($handle,$new)){
			return "File cannot be updated at " . trim($config_file,'.');
		}
		
		//Return the config file to proper permissions
		@chmod($config_file,0644);
		
		//No problems!
		return FALSE;
		
	}
	
	//FUNC_RESDBCONF - Resets the database config to its "pre-updated" state
	public function reset_db_config(){
		
		//Config paths
		$config_file = './application/config/database.php';
		$backup_file = './application/views/install/database_config.php';

		//File not writable, attempt to chmod
		if(!is_writable($config_file)){
			@chmod($config_file,0777);
		}
		
		//If it's still not writable, throw an error!
		if(!is_writable($config_file)){
			return "File is not writable at " . trim($config_file,'.');
		}
		
		//Open the file
		$database_file = file_get_contents($backup_file);
		if(!$database_file){
			return "Cannot fetch file from " . trim($backup_file,'.') . " - file may be missing!";
		}

		//Write the new database.php file
		$handle = fopen($config_file,'w+');
		
		//Write the file
		if(!fwrite($handle,$database_file)){
			return "File cannot be updated at " . trim($config_file,'.');
		}
		
		//Return the config file to proper permissions
		@chmod($config_file,0644);
		
		//No problems!
		return FALSE;
		
	}
	
	/***** DESTROY *****/

}
