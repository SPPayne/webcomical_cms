<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Utilities_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	
	//FUNCTION INDEX - Search a function code to skip to that part of the file
	/* CREATE:
	 * FUNC_FUP 	- Perform a file upload
	 * 
	 * READ:
	 * FUNC_VALF 	- Validate a file for upload
	 * 
	 * UPDATE:
	 * FUNC_GENMAP 	- Generate a fresh sitemap
	 * 
	 * DESTROY:
	 * FUNC_REF 	- Remove a file from the server
	 */
	 
	/***** CREATE *****/
	
	//FUNC_FUP - Perform a file upload
	//Ref: http://www.tutorialspoint.com/codeigniter/codeigniter_file_uploading.htm
	public function file_upload($type,$name,$config,&$errors = array()){
		
		//Set config, load CI upload library
		$config['file_name'] 		= $name;
		$config['upload_path']		= './assets/' . $type; 
		$this->load->library('upload',$config);
		
		//Attempt upload
		if(!$this->upload->do_upload()){
            $errors[] = $this->upload->display_errors('', '');
			return FALSE;
        }
		
		//Return upload details
		return $this->upload->data();

	}
	
	/***** READ *****/
	
	//FUNC_VALF - Validate a file for upload
	public function validate_file(&$errors = array()){
		
		//File name?
		if(!isset($_FILES['userfile']['name']) || trim($_FILES['userfile']['name']== "")){
			$errors[] = 'No filename selected';
			return FALSE;
		}
		
		//Check file for malicious content
		if($this->security->xss_clean($_FILES['userfile']['name'],TRUE) === FALSE){
			$errors[] = 'This file contains potentially malicious information';
			return FALSE;
		}
		
		//Passes validation
		return TRUE;
		
	}
	
	/***** UPDATE *****/
	
	//FUNC_GENMAP - Generate a fresh sitemap
	public function generate_sitemap(){
		
		//Utilises Mitaka777's sitemap library with some blatant bugfixes I've had to make as the 
		//sodding thing didn't work first time (ta for that Mitaka777!)
		//Ref: https://github.com/Mitaka777/ci-sitemap
		$this->load->library('sitemap');

		//Create new instance
		$sitemap = new Sitemap();

		//Add items to your sitemap (url, date, priority, freq), examples:
		//$sitemap->add('http://mysite.tld/', '2012-08-25T20:10:00+02:00', '1.0', 'daily');
		//$sitemap->add('http://mysite.tld/page1', '2012-08-26T22:30:00+02:00', '0.6', 'monthly');
		//$sitemap->add('http://mysite.tld/page2', '2012-08-26T23:45:00+02:00', '0.9', 'weekly');
		
		//Set date/time
		$current_time = date('Y-m-dTH:i:sP');
		
		//Homepage
		$sitemap->add(base_url(), $current_time, '1.0', 'weekly');
		
		//About page
		$this->load->model('Comic_model','Comic');
		$about = $this->Comic->fetch_about_page($this->config->item('about','webcomic'));
		if($about != FALSE){
			$updated = date('Y-m-dTH:i:sP',strtotime($about['about_updated']));
			$sitemap->add(base_url().'about', $updated, '0.7', 'yearly');
		}
		
		//Episodes
		$archive = $this->Comic->fetch_valid_pages_in_order($reverse = FALSE,$active = TRUE);
		if($archive != FALSE){
			
			//Set array to capture archive URLs
			$archive_urls = array();
			
			//Set count
			$cnt = 0;
			
			//Set a value to capture most current timestamp
			$most_current = strtotime("0000-00-00 00:00:00");
			
			//Loop the archive
			foreach($archive as $chapter){
				if(!empty($chapter->pages) || !empty($chapter->subchapters)){ //Only show if pages or subchapters
					if(!empty($chapter->pages)){
						foreach($chapter->pages as $page){
							$archive_urls[$cnt]['url'] 			= base_url().'page/'.$page->slug;
							$archive_urls[$cnt]['timestamp'] 	= strtotime($page->last_updated);
							if($archive_urls[$cnt]['timestamp'] > $most_current){
								$most_current = $archive_urls[$cnt]['timestamp'];
							}
							$cnt++;
						}
					}
					if(!empty($chapter->subchapters)){
						foreach($chapter->subchapters as $subchapter){
							if(!empty($subchapter->pages)){ //Only show if pages
								foreach($subchapter->pages as $page){
									$archive_urls[$cnt]['url'] 			= base_url().'page/'.$page->slug;
									$archive_urls[$cnt]['timestamp'] 	= strtotime($page->last_updated);
									if($archive_urls[$cnt]['timestamp'] > $most_current){
										$most_current = $archive_urls[$cnt]['timestamp'];
									}
									$cnt++;
								}
							} else { continue; }
						}
					} else { continue; }
				}
			}
			
			//Sanity check
			if(!empty($archive_urls)){
				
				//Set archive page
				$sitemap->add(base_url().'archive', date('Y-m-dTH:i:sP',$most_current), '0.5', 'weekly');
				
				//Loop archive urls, add to sitemap
				foreach($archive_urls as $key => $urls){
					$sitemap->add($urls['url'], date('Y-m-dTH:i:sP',$urls['timestamp']), '0.5', 'yearly');
				}
				
			}
			
		}
		
		//Bio pages and character appearance pages
		$this->load->model('Characters_model','Characters');
		$cast = $this->Characters->fetch_all_characters(FALSE,TRUE);
		if($cast != FALSE){
			
			//Set array to capture archive URLs
			$archive_urls = array();
			
			//Set count
			$cnt = 0;
			
			//Set a value to capture most current timestamp
			$most_current = strtotime("0000-00-00 00:00:00");
			
			//Character bios
			foreach($cast as $character){
				
				//First URL - char bio page
				$archive_urls[$cnt]['url'] 			= base_url().'character_profiles/'.$character->slug;
				$archive_urls[$cnt]['timestamp'] 	= strtotime($character->last_updated);
				$cnt++;
				
				//Second URL - char appearances page
				$archive_urls[$cnt]['url'] 			= base_url().'character_appearances/'.$character->slug;
				$archive_urls[$cnt]['timestamp'] 	= strtotime($character->last_updated);
				
				//Check against "most recent" timestamp
				if($archive_urls[$cnt]['timestamp'] > $most_current){
					$most_current = $archive_urls[$cnt]['timestamp'];
				}
				
				//Increment again!
				$cnt++;
				
			}
			
			//Sanity check
			if(!empty($archive_urls)){
				
				//Set cast page
				$sitemap->add(base_url().'character_profiles', date('Y-m-dTH:i:sP',$most_current), '0.5', 'weekly');
				
				//Loop archive urls, add to sitemap
				foreach($archive_urls as $key => $urls){
					$sitemap->add($urls['url'], date('Y-m-dTH:i:sP',$urls['timestamp']), '0.5', 'yearly');
				}
				
			}
			
		}
		
		//Tag pages
		$this->load->model('Tagging_model','Tagging');
		$tags = $this->Tagging->fetch_all_tags();
		if($tags != FALSE){
			foreach($tags as $tag){
				$updated = date('Y-m-dTH:i:sP',strtotime($tag->added));
				$sitemap->add(base_url().'tags/'.$tag->slug, $updated, '0.3', 'monthly');
			}
		}
		
		//Show your sitemap (options: 'xml', 'google-news', 'sitemapindex' 'html', 'txt', 'ror-rss', 'ror-rdf')
		$sitemap_data = $sitemap->generate('xml');
		
		//Create the file if it doesn't exist
		if(($file = @fopen("sitemap.xml", "w")) == FALSE){
            return FALSE;
        }
		
		//Dump xml contents to file
		fwrite($file,$sitemap_data);
		fclose($file);
		
		//We also need to ensure that the site has a robots.txt file so search engines can find the damn thing
		$file = fopen("robots.txt", "w");
		if($file){
			fwrite($file, "Sitemap: " . base_url() . "sitemap.xml");
			fclose($file);
		}
		
		//End!
		return TRUE;
		
	}
	
	/***** DESTROY *****/
	
	//FUNC_REF - Remove a file from the server
	public function remove_file($type,$file){
		
		//File required
		if(!$file){
			return FALSE;
		}
		
		//Set file path
		$filepath = './assets/' . $type . '/' . $file;
		
		//DEBUG
		//echo $filepath; return FALSE;
		
		//Delete the file
		if(!unlink($filepath)){
			return FALSE;
		}
		
		//Success!
		return TRUE;
		
	}
	
}
