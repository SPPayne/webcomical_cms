<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Banners_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	
	//FUNCTION INDEX - Search a function code to skip to that part of the file
	/* CREATE:
	 * FUNC_ANR 	- Creates a redirect entry
	 * 
	 * READ:
	 * FUNC_FAR 	- Grab the contents of the redirects table
	 * 
	 * UPDATE:
	 * FUNC_BANNVIS - Set whether a banner is "active" or not
	 * 
	 * DESTROY:
	 * FUNC_DELBANN - Delete banner from db
	 */
	
	/***** CREATE *****/
	
	//FUNC_ANR - Creates a redirect entry
	public function add_new_banner($filename){
		
		//Form the insert SQL
		$sql = "INSERT INTO `banners` SET `filename` = " . $this->db->escape($filename);
		
		//Run
		if(!$this->db->query($sql)){
			return FALSE;
		}
		return TRUE;
		
	}
	
	/***** READ *****/
	
	//FUNC_FAR - Grab the contents of the banners table, or just one banner
	public function fetch_banners($bannerid = FALSE,$active = FALSE){
		
		//Banner filter
		if($bannerid != FALSE && ctype_digit($bannerid)){
			$query = $this->db->order_by('id','ASC')->get_where('banners', array('id' => $bannerid), 1);
		} else {
			$this->db->select('*');
			$this->db->from('banners');
			$this->db->order_by('id','ASC');
			$query = $this->db->get();
		}

		//DEBUG
		//echo $this->db->last_query();
		
		//Result!
		if($query->num_rows() > 0){
			
			//We need to test for if banners are set to "active", so set flag
			$activated_flag = FALSE;
			
			//Format values into array with items assigned to a type
			$format 		= array();
			foreach($query->result() as $item){
				
				//Not great, but if the image is missing then we should just delete the db reference...
				if(!file_exists('./assets/banners/' . $item->filename)){
					//$this->delete_banner($item->id);
					continue;
				}
				
				//Filter for active banners
				if($active != FALSE && $item->banner_active == "N"){
					continue;
				}
				
				//Update flag to represent that there is at least one banner to show
				if($active != FALSE && $item->banner_active == "Y"){
					$activated_flag = TRUE;
				}
				
				//Assign to formatted array
				$format[] = $item;
				
			}
			
			//DEBUG
			//print_r($format);
			
			//No valid or activated banners?
			if(empty($format) || ($active != FALSE && $activated_flag == FALSE)){
				return FALSE;
			}
			
			//Return formatted array
			if($bannerid != FALSE){
				return $format[0];
			} else {
				return $format;
			}
			
		}
			
		//No result
		return FALSE;
		
	}
	
	/***** UPDATE *****/
	
	//FUNC_BANNVIS - Set whether a banner is "active" or not
	public function update_banner_visibility($id,$active){
		
		//Form SQL
		$sql = "UPDATE banners SET `banner_active` = " . $this->db->escape($active) . " WHERE id = " . $this->db->escape($id);
		
		//Run
		if(!$this->db->query($sql)){
			return FALSE;
		}
		return TRUE;
		
	}
	
	/***** DESTROY *****/
	
	//FUNC_DELBANN - Delete banner from db
	public function delete_banner($bannerid){
		
		//Set statement
		$this->db->where('id',$bannerid);
		$this->db->delete('banners');
		
		//Check if run
		if(!$this->db->affected_rows()){
			return FALSE;
		}
		return TRUE;
		
	}
	
}
