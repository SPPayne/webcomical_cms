<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Template_model extends CI_Model {

	public function __construct(){
		
		parent::__construct();
		
		//Get contents of template replacements folder
		$replacements_path 	= "./application/views/comic/template_replacements/";
		$this->replacements = array_diff(scandir($replacements_path),array('..','.','index.html'));
		
	}
	
	//FUNCTION INDEX - Search a function code to skip to that part of the file
	/* CREATE:
	 * 
	 * READ:
	 * FUNC_FTEMP 		- Fetch all available, valid templates
	 * FUNC_RTEMPDIR 	- Fetch the contents of the templates directory (PRIV)
	 * FUNC_FVALTEMP 	- Reads templates directory and returns "valid" templates (along with invalid ones + reason why invalid) (PRIV)
	 * FUNC_VALTMP 		- Validate a single template
	 * FUNC_CTE 		- Check that a theme exists via directory name
	 * FUNC_LOADTMP 	- Attempt to load and render a template for a given page
	 * FUNC_PROTEMP 	- Process a custom template for display (PRIV)
	 * 
	 * UPDATE:
	 * 
	 * DESTROY:
	 */
	 
	/***** CREATE *****/
	
	/***** READ *****/
	
	//FUNC_FTEMP - Fetch all available, valid templates
	public function fetch_templates($config){
		
		//Attempt to fetch contents of template directory
		$templates = $this->_read_template_dir($config['template_dir']);
		
		//No templates OR the folder is missing!
		/*if(!$templates){
			return FALSE;
		}*/
		
		//Validate and format any valid templates in the template directory
		$templates = $this->_fetch_validated_templates($config,$templates);
		
		//DEBUG
		//print_r($templates);
		
		//Output
		return $templates;
		
	}
	
	//FUNC_RTEMPDIR - Fetch the contents of the templates directory (PRIV)
	private function _read_template_dir($path){
		
		//Is the path in the config a directory? (It bloody well should be!)
		if(!is_dir($path)){
			return FALSE;
		}
		
		//Fetch folders
		//Ref: http://php.net/manual/en/function.scandir.php
		$dirs = array_diff(scandir($path),array('..','.'));
		
		//Loop directory items and remove items that aren't directories
		if($dirs){
			foreach($dirs as $key => $dir){
				if(!is_dir($path . $dir)){
					unset($dirs[$key]);
				}
			}
		}
		
		//DEBUG
		//print_r($dirs);
		
		//Sanity check - any directories left?
		if(empty($dirs)){
			return FALSE;
		}
		
		//Return directories
		return $dirs;
		
	}
	
	//FUNC_FVALTEMP - Reads templates directory and returns "valid" templates (along with invalid ones + reason why invalid) (PRIV)
	private function _fetch_validated_templates($config,$dirs){
		
		//Redundancy - you never know!
		if(!$config){
			return FALSE;
		}
		
		//Load string manipulation library
		$this->load->library('string_manip');
		
		//Loop and validate each directory for files
		$format = array();
		if($dirs){
			
			foreach($dirs as $dir){
				
				//Validate the template - if there's an error then append to results array
				if($error = $this->validate_template($config,$dir)){
					$format['invalid'][$dir] = $error;
					continue;
				}
				
				//Set files to check
				$template 				= array();
				$template['template'] 	= $config['template_dir'] . $dir . '/' . $config['template_file'];
				$template['info'] 		= $config['template_dir'] . $dir . '/' . $config['template_info'];
				$template['preview'] 	= $config['template_dir'] . $dir . '/' . $config['template_preview'];
				
				//Set dir values to be empty
				$format['valid'][$dir]['name'] 			= "";
				$format['valid'][$dir]['description'] 	= "";
				$format['valid'][$dir]['preview'] 		= $config['default_preview'];
				
				//Check the info file exists
				if(!file_exists($template['info'])){
					$format['valid'][$dir]['name'] 			= "Unknown (directory '" . $dir . "')";
					$format['valid'][$dir]['description'] 	= $config['template_info'] . " file is missing, no details provided.";
					continue;
				}
				
				//Get the contents of the info file, populate valid items
				$template['info'] = file($template['info']);
				if(isset($template['info'][0])){ $format['valid'][$dir]['name'] 		= trim($this->string_manip->make_tame($template['info'][0])); }
				if(isset($template['info'][1])){ $format['valid'][$dir]['description'] 	= trim($this->string_manip->make_tame($template['info'][1])); }
				
				//DEBUG
				//print_r($info);
				
				//Preview image
				if(file_exists($template['preview'])){
					
					//Validate img dimensions and type
					$img_properties = getimagesize($config['template_dir'] . $dir . '/' . $config['template_preview']);
					$img_properties = array("width" => $img_properties[0], "height" => $img_properties[1], "mime" => $img_properties['mime']);
					if(!$this->validation->img_has_valid_dimensions($img_properties,$config['preview_img_dimensions']) || $img_properties['mime'] != "image/png"){
						$format['valid'][$dir]['preview'] = $config['default_preview'];
					} else {
						$format['valid'][$dir]['preview'] = trim($template['preview'],'.');
					}

				//No image
				} else {
					$format['valid'][$dir]['preview'] = $config['default_preview'];
				}
				
			}
			
		}
		
		//Add default template
		$format['valid']['default']['name'] 		= "Default";
		$format['valid']['default']['description'] 	= "Use the " . $this->config->item('app_name','webcomic') . " default display (not customisable!).";
		$format['valid']['default']['preview'] 		= $config['default_preview'];
		
		//Output validated templates
		foreach($format as $type => $themes){
			ksort($format[$type]);
		}
		ksort($format);
		return $format;
		
	}
	
	//FUNC_VALTMP - Validate a single template
	public function validate_template($config,$template,$default_override = FALSE){
		
		//Set error prefix
		$error_prefix = "Template error - ";
		
		//Redundancy - you never know!
		if(!$config){
			return "Config is missing - template cannot be validated.";
		}
		
		//Load validation library
		$this->load->library('validation');
		
		//Default override allows us to update the theme to "system default"
		if($default_override == FALSE){
			
			//Is the directory name "default"? We can't allow that!
			if(strtolower($template) == "default"){
				return $error_prefix . "directory cannot be named 'default' as that term is a reserved name.";
			}
			
			//Is the directory name "tame" i.e. doesn't contain funny characters?
			if(!$this->validation->is_alphanumeric($template,$ignore=array('-'))){
				return $error_prefix . "directory name contains illegal characters (must be alphanumeric with optional underscores or dashes).";
			}
			
			//Set template file to check
			$template = $config['template_dir'] . $template . '/' . $config['template_file'];
			
			//Check the main template file exists
			if(!file_exists($template)){
				return $error_prefix . "missing " . $config['template_file'] . " file.";
			}
			
			//Is the main template file in HTML format?
			if(!$this->validation->is_html(file_get_contents($template))){
				return $error_prefix . $config['template_file'] . " file does not contain HTML!";
			}
			
		}
		
		//Validates...so we actually return FALSE to represent there's nothing wrong
		return FALSE;
		
	}
	
	//FUNC_CTE - Check that a theme exists via directory name
	public function check_theme_exists($config,$theme){
		
		//DEBUG
		//print_r($config);
		
		//Load validation library
		$this->load->library('validation');
		
		//DEBUG
		//echo $config['template_dir'] . $theme . "<br />";
		
		//Does the directory exist or is directory name invalid?
		if(!is_dir($config['template_dir'] . $theme) || !$this->validation->is_alphanumeric($theme,$ignore=array('-'))){
			return FALSE;
		}
		
		//Is the template valid?
		if($this->validate_template($config,$theme)){
			return FALSE;
		}
		
		//Valid!
		return TRUE;
		
	}
	
	//FUNC_LOADTMP - Attempt to load and render a template for a given page
	public function load_template($config,$page,$data){
		
		//For a custom template, we need to check that the corresponding file actually exists!
		$template = $config['template_dir'] . $data['site']['site_theme'] . "/" . $config['template_mappings'][$page];
		
		//Doesn't exist...
		if(!file_exists($template)){
			
			//FAIL
			return FALSE;
			
		//File does exist
		} else {

			//Attempt to get the contents of the file
			if(!$template = file_get_contents($template)){
				
				//FAIL AGAIN!
				return FALSE;
			
			//Got contents
			} else {
				
				//There's nothing in the file!
				if(empty($template)){
							
					//FAILURE THE THIRD, HEIR TO THE FAILURE TREASURY!
					return FALSE;
				
				//File has contents...
				} else {
					
					//If we get this far the template presumably exists, so process placeholder replacements...
					$template = $this->_process_template($template,$data);
					
					//If the template couldn't be processed, then serve up the system default (again)
					if($template == FALSE || empty($template)){
						
						//YOU HAVE FAILED ME FOR THE LAST TIME!
						return FALSE;
						
					}
					
				}
				
			}
			
		}
		
		//We get this far...everything should be hunky dory, whatever that means?
		return $template;
		
	}
	
	//FUNC_PROTEMP - Process a custom template for display (PRIV)
	private function _process_template($template,$data){
		
		//I'm leaving this note here to say yeah, we probably should validate that the file is HTML.
		//However, that's like asking how long a piece of string is!
		//If you want to play silly buggers with your template files, don't come crying to me when things break!
		
		//If for some baffling reason the placeholder replacements are missing
		if(empty($this->replacements)){
			return FALSE;
		}
		
		//Reassign
		$replacements = $this->replacements;
		
		//Loop and clean up
		foreach($replacements as $key => $value){
			$replacements[$key] = strtolower(basename($value,".php"));
		}
		
		//Loop again, handle replacements 
		foreach($replacements as $replacement){
			
			//Match placeholder
			$placeholder = "[%" . strtoupper($replacement) . "%]";
			
			//If a match...
			if(stristr($template,$placeholder)){
				
				//DEBUG
				//echo $placeholder . " is present<br />";
				
				//Get replacement string HTML
				$replacement = $this->load->view('comic/template_replacements/'.$replacement,$data,TRUE);
				
				//Replace tag with string
				$template = str_ireplace($placeholder,$replacement,$template);
				
			}
			
		}
		
		//Output template string
		return $template;
		
	}
	
	/***** UPDATE *****/
	
	/***** DESTROY *****/
	
}
