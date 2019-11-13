<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Logging_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	
	//FUNCTION INDEX - Search a function code to skip to that part of the file
	/* CREATE:
	 * 
	 * READ:
	 * FUNC_FPV - Fetch pages in order of most viewed
	 * FUNC_FST - Fetch search terms in order of most popular
	 * 
	 * UPDATE:
	 * FUNC_PCU - Log that a page has been viewed
	 * 
	 * DESTROY:
	 */
	 
	/***** CREATE *****/
	
	
	/***** READ *****/
	
	//FUNC_FPV - Fetch pages in order of most viewed
	public function fetch_page_views(){
		
		$sql = "SELECT * FROM log_page_views WHERE page_type <> 'search term' ORDER BY views DESC, url LIMIT 50";
		
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
	
	//FUNC_FST - Fetch search terms in order of most popular
	public function fetch_search_terms(){
		
		$sql = "SELECT * FROM log_page_views WHERE page_type = 'search term' ORDER BY views DESC, url LIMIT 50";
		
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
	
	//FUNC_FRV - Fetch the most recently viewed pages
	public function fetch_recently_viewed(){
		
		$sql = "SELECT * FROM log_page_views WHERE page_type <> 'search term' ORDER BY last_viewed DESC, url LIMIT 10";
		
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
	
	//FUNC_PCU - Log that a page has been viewed
	public function page_count_update($slug,$type){
		
		//Sanity check
		if(!$slug || !$type){
			return FALSE;
		}
		
		//Check for an existing entry
		$sql = "SELECT id FROM log_page_views WHERE url = " . $this->db->escape($slug) . " AND page_type = " . $this->db->escape($type) . " LIMIT 1";
		
		//Run query
		$query = $this->db->query($sql);
		
		//No existing result = INSERT
		if($query->num_rows() == 0){
			$log_sql 	= "INSERT INTO ";
			$id 		= FALSE;
		} else {
			$log_sql 	= "UPDATE ";
			$result 	= $query->result();
			$id 		= $result[0]->id;
		}
		
		$log_sql .= " log_page_views SET url = " . $this->db->escape($slug) . ", page_type = " . $this->db->escape($type) . ", views = (views+1)";
		
		if($id != FALSE){
			$log_sql .= " WHERE id = " . $this->db->escape($id);
		}
		
		if(!$this->db->query($log_sql)){
			return FALSE;
		}
		return TRUE;
		
	}
	
	/***** DESTROY *****/
	
}
