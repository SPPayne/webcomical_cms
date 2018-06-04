<?php defined('BASEPATH') OR exit('No direct script access allowed');

//Extends CI's native load function
class COMIC_Loader extends CI_Loader{
	
	//Construct
	function __construct(){
		parent::__construct();
	}
	
	//Load a js file
	function js($page){
		
		//Load helper
		$this->helper('file');
		
		//Form a path to check for javascript
		$js_path = 'js/' . $page . '.js';
		$test_path = './application/views/' . $js_path;
		
		//DEBUG
		/*echo $test_path . "<br />";
		if(!read_file($test_path)){
			echo "NO JS!";
		} else {
			echo "JS!";
		}*/
		
		//If a matching .js file exists, load it!
		if(read_file($test_path)){
			return $this->view($js_path,'',TRUE);
		}
		
		//End
		return FALSE;
		
	}
	
	//Admin views - custom loader
	//Ref: http://stackoverflow.com/questions/14805025/custom-my-loader-to-load-a-group-of-views
	function admin_view($page,$vars=array(),$return=FALSE){

		//Load header, main view, any .js for the page and footer
		$view = $this->view('admin/shared/admin_header',$vars,TRUE);
		$view .= $this->view('admin/'.$page,$vars,TRUE);
		$vars['js'] = $this->js('admin/'.$page);
		$view .= $this->view('admin/shared/admin_footer',$vars,TRUE);
		
		//If return value set, return variable
		if($return){
			return $view;
		} else {
			echo $view;
		}
		
	}
	
	//Auth views - custom loader
	function auth_view($page,$vars=array(),$return=FALSE){

		//Load header, main view, any .js for the page and footer
		$view = $this->view('admin/shared/admin_header',$vars,TRUE);
		$view .= $this->view($page,$vars,TRUE);
		$view .= $this->view('admin/shared/admin_footer',$vars,TRUE);
		
		//If return value set, return variable
		if($return){
			return $view;
		} else {
			echo $view;
		}
		
	}
	
}
