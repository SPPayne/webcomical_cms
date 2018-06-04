<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Admin
| -------------------------------------------------------------------------
| Admin pagination config
*/
$config['admin_pagination'] = array(
	'use_page_numbers' 	=> TRUE,
	'per_page' 			=> 1,
	'num_links' 		=> 5,
	'full_tag_open' 	=> '<nav class="navbar navbar-default"><div class="container-fluid"><ul class="nav navbar-nav">',
	'full_tag_close' 	=> '</ul></div></nav>',
	'first_link' 		=> '&laquo; First',
	'last_link' 		=> 'Last &raquo;',
	'next_link' 		=> 'Next &rsaquo;',
	'prev_link'	 		=> '&lsaquo; Previous',
	'cur_tag_open' 		=> '<li class="active"><a href="">',
	'cur_tag_close' 	=> '</a></li>',
	'first_tag_open' 	=> '<li>',
	'last_tag_open' 	=> '<li>',
	'next_tag_open' 	=> '<li>',
	'prev_tag_open' 	=> '<li>',
	'num_tag_open' 		=> '<li>',
	'first_tag_close' 	=> '</li>',
	'last_tag_close' 	=> '</li>',
	'next_tag_close' 	=> '</li>',
	'prev_tag_close' 	=> '</li>',
	'num_tag_close' 	=> '</li>'
);

/*
| -------------------------------------------------------------------------
| Comic
| -------------------------------------------------------------------------
| Comic pagination config
*/
$config['comic_pagination'] = array(
	'use_page_numbers'	=> TRUE,
	'per_page' 			=> 8,
	'num_links' 		=> 10,
	'full_tag_open' 	=> '<nav class="navbar navbar-default"><div class="container-fluid"><ul class="nav navbar-nav">',
	'full_tag_close' 	=> '</ul></div></nav>',
	'first_link' 		=> '&laquo; First',
	'last_link' 		=> 'Last &raquo;',
	'next_link' 		=> 'Next &rsaquo;',
	'prev_link'	 		=> '&lsaquo; Previous',
	'cur_tag_open' 		=> '<li class="active"><a href="">',
	'cur_tag_close' 	=> '</a></li>',
	'first_tag_open' 	=> '<li>',
	'last_tag_open' 	=> '<li>',
	'next_tag_open' 	=> '<li>',
	'prev_tag_open' 	=> '<li>',
	'num_tag_open' 		=> '<li>',
	'first_tag_close' 	=> '</li>',
	'last_tag_close' 	=> '</li>',
	'next_tag_close' 	=> '</li>',
	'prev_tag_close' 	=> '</li>',
	'num_tag_close' 	=> '</li>'
);

/* End of file pagination.php */
/* Location: ./application/config/pagination.php */
