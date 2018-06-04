<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Webcomical
*
* Version: 0.0.1
*
* Author: Sean Patrick Payne
*		  http://www.payneful.co.uk
*         @russiangestapo
*
* Location: ?
*
* Created: 30/04/2016
*
* Description:  A webcomic platform designed from the ground up for showing webcomics
*
* Requirements: PHP5 or above, jQuery
*
*/

/*
| -------------------------------------------------------------------------
| General
| -------------------------------------------------------------------------
| Odds and sods.
*/
$config['app_name'] 		= "WebComical";
$config['disable_admin'] 	= FALSE; //If you don't intend to ever update the comic again and want it in "read only" mode, set this to TRUE to disable the admin panel

/*
| -------------------------------------------------------------------------
| Assets
| -------------------------------------------------------------------------
| Where various third-party web assets are stored
| If you don't wish to host the asset locally then you can replace the filepath with a web URI e.g. to Google hosted jQuery, etc.
*/
$config['assets']['jquery'] 			= "/assets/web/jquery-2.2.3.min.js"; 										//Local
//$config['assets']['jquery'] 			= "http://code.jquery.com/jquery-latest.min.js"; 							//Hosted
$config['assets']['bootstrap_js'] 		= "/assets/web/bootstrap/js/bootstrap.min.js"; 								//Currently version 3.3.6
$config['assets']['bootstrap_css'] 		= "/assets/web/bootstrap/css/bootstrap.min.css"; 							//Theme provided by https://bootswatch.com/ ("Spacelab")
$config['assets']['datepicker_js'] 		= "/assets/web/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js"; 	//http://www.malot.fr/bootstrap-datetimepicker
$config['assets']['datepicker_css'] 	= "/assets/web/bootstrap-datepicker/css/bootstrap-datetimepicker.min.css";
$config['assets']['form_validation'] 	= "/assets/web/validator.js"; 												//Github repo: https://github.com/1000hz/bootstrap-validator
$config['assets']['ckeditor'] 			= "/assets/web/ckeditor/ckeditor.js"; 										//Currently "standard" version 4.5.8 - note that config.js has been modified!
$config['assets']['mobile'] 			= "/assets/web/jquery.touchSwipe.min.js";									//Adds mobile swipe features, current version is 1.6, website: https://github.com/mattbryson/TouchSwipe-Jquery-Plugin
$config['assets']['webcomical'] 		= "/assets/web/webcomical.js";												//Sean's code! Bits and pieces for the comic view

/*
| -------------------------------------------------------------------------
| Misc Assets
| -------------------------------------------------------------------------
| Same as above but output to every page - add to below to add to every page!
*/
$config['assets']['js'] = array(
	"/assets/web/jasny-bootstrap/js/jasny-bootstrap.min.js", 	//Adds Bootstrap features, current version is 3.1.3, website: http://www.jasny.net/bootstrap/
	"/assets/web/bootstrap-toggle/js/bootstrap-toggle.min.js"	//http://www.bootstraptoggle.com/
);
$config['assets']['css'] = array(
	"/assets/web/jasny-bootstrap/css/jasny-bootstrap.min.css",
	"/assets/web/bootstrap-toggle/css/bootstrap-toggle.min.css"
);

/*
| -------------------------------------------------------------------------
| User
| -------------------------------------------------------------------------
| User settings, used in generating user forms
*/
$config['user'] = array(
	'first-name'	=> array(
		'label'			=> 'First name',
		'ion_field' 	=> 'first_name',
		'type'			=> 'text',
		'guide'			=> 'Letters, numbers, limited punctuation and spaces only',
		'pattern'		=> "^[A-z0-9 '-\.]{1,}$",
		'maxlength'		=> 20,
		'minlength'		=> 2,
		'required'		=> TRUE,
		'placeholder'	=> 'Your first name'
	),
	'surname'		=> array(
		'label'			=> 'Surname',
		'ion_field' 	=> 'last_name',
		'type'			=> 'text',
		'guide'			=> 'Letters, numbers, limited punctuation and spaces only',
		'pattern'		=> "^[A-z0-9 '-\.]{1,}$",
		'maxlength'		=> 20,
		'minlength'		=> 2,
		'required'		=> TRUE,
		'placeholder'	=> 'Your last name'
	),
	'username' 		=> array(
		'label'			=> 'Username',
		'ion_field' 	=> 'username',
		'type'			=> 'text',
		'guide'			=> 'Letters, numbers and underscores only',
		'pattern'		=> "^[A-z0-9_]{1,}$",
		'maxlength'		=> 20,
		'minlength'		=> 3,
		'required'		=> TRUE,
		'placeholder'	=> 'e.g. JoeBloggs99'
	),
	'email-address' => array(
		'label'			=> 'Email address',
		'ion_field' 	=> 'email',
		'type'			=> 'email',
		'guide'			=> 'e.g. user@domain.com',
		'maxlength'		=> 100,
		'minlength'		=> 3,
		'required'		=> TRUE,
		'placeholder'	=> 'e.g. user@email.com'
	),
	'password'		=> array(
		'label'			=> 'Password',
		'ion_field' 	=> FALSE,
		'type'			=> 'password',
		'guide'			=> 'Minimum 8 characters, lower and uppercase letters and at least one number required',
		'pattern'		=> "^[A-z0-9_]{1,}$",
		'maxlength'		=> 20,
		'minlength'		=> 8,
		'required'		=> FALSE,
		'placeholder'	=> 'A memorable password'
	)
);

/*
| -------------------------------------------------------------------------
| Webcomic
| -------------------------------------------------------------------------
| Webcomic settings, used in generating webcomic management forms
*/
$config['comic_settings'] = array(
	'title'			=> array(
		'label'			=> 'Webcomic Title',
		'db_field' 		=> 'site_name',
		'type'			=> 'text',
		'guide'			=> 'The name of your webcomic! Letters, numbers, limited punctuation and spaces only',
		'pattern'		=> "[A-z0-9 !?'-\.]{1,}",
		'maxlength'		=> 50,
		'minlength'		=> 2,
		'required'		=> TRUE,
		'readonly'		=> FALSE,
		'default_val'	=> 'My Webcomic'
		
	),
	'slogan'		=> array(
		'label'			=> 'Webcomic Slogan',
		'db_field' 		=> 'site_slogan',
		'type'			=> 'text',
		'guide'			=> 'Add a slogan to your webcomic! Letters, numbers, limited punctuation and spaces only',
		'pattern'		=> "[A-z0-9 !?'-\.]{1,}",
		'maxlength'		=> 100,
		'minlength'		=> 2,
		'required'		=> TRUE,
		'readonly'		=> FALSE,
		'default_val'	=> 'The funniest webcomic ever!'
	),
	'updates_on'	=> array(
		'label'			=> 'Updates',
		'db_field' 		=> 'site_updates_on',
		'type'			=> 'text',
		'guide'			=> 'When does your comic update? Letters, numbers, limited punctuation and spaces only',
		'pattern'		=> "[A-z0-9 !?'-\.]{1,}",
		'maxlength'		=> 50,
		'minlength'		=> 2,
		'required'		=> TRUE,
		'readonly'		=> FALSE,
		'default_val'	=> 'regularly'
	),
	'comments'		=> array(
		'label'			=> 'Comments (Disqus)',
		'db_field'		=> 'site_comments',
		'type'			=> 'text',
		'guide'			=> 'Your <a href="https://help.disqus.com/customer/portal/articles/466208">Disqus forum shortname</a> for comments generation',
		'pattern'		=> "[A-z0-9 -]{1,}",
		'maxlength'		=> 255,
		'minlength'		=> 2,
		'required'		=> FALSE,
		'readonly'		=> FALSE,
		'default_val'	=> ''
	),
	'theme'			=> array(
		'label'			=> 'Theme',
		'db_field'		=> 'site_theme',
		'type'			=> 'text',
		'guide'			=> 'The theme currently active for this webcomic - select this on the <a href="/admin/webcomic_appearance/">themes page</a>',
		'pattern'		=> "[A-z0-9 -_]{1,}",
		'maxlength'		=> 255,
		'minlength'		=> 2,
		'required'		=> FALSE,
		'readonly'		=> TRUE,
		'default_val'	=> 'default'
	),
	'page_term'	=> array(
		'label'			=> 'Page Terminology',
		'db_field'		=> 'site_page_term',
		'type'			=> 'text',
		'guide'			=> 'Your preferred term for "page" (e.g. "Page", "Strip", "Episode"). Please note that plural references will default to having an "s" on the end!',
		'pattern'		=> "[A-z0-9 -_]{1,}",
		'maxlength'		=> 20,
		'minlength'		=> 2,
		'required'		=> TRUE,
		'readonly'		=> FALSE,
		'default_val'	=> 'Page'
	),
	'chapter_term'	=> array(
		'label'			=> 'Chapter Terminology',
		'db_field'		=> 'site_chapter_term',
		'type'			=> 'text',
		'guide'			=> 'Your preferred term for "chapter" (e.g. "Act", "Arc", "Book", "Chapter"). Please note that plural references will default to having an "s" on the end!',
		'pattern'		=> "[A-z0-9 -_]{1,}",
		'maxlength'		=> 20,
		'minlength'		=> 2,
		'required'		=> TRUE,
		'readonly'		=> FALSE,
		'default_val'	=> 'Chapter'
	),
	'about_page_term'	=> array(
		'label'			=> 'About Page Terminology',
		'db_field'		=> 'site_about_term',
		'type'			=> 'text',
		'guide'			=> 'Your preferred term for "about" (e.g. "About the Comic", "Synopsis", "What is this all about?")',
		'pattern'		=> "[A-z0-9 -_]{1,}",
		'maxlength'		=> 20,
		'minlength'		=> 2,
		'required'		=> TRUE,
		'readonly'		=> FALSE,
		'default_val'	=> 'About'
	),
	'cast_page_term'	=> array(
		'label'			=> 'Cast Terminology',
		'db_field'		=> 'site_cast_term',
		'type'			=> 'text',
		'guide'			=> 'Your preferred term for "cast" (e.g. "Characters", "Cast", "Profiles")',
		'pattern'		=> "[A-z0-9 -_]{1,}",
		'maxlength'		=> 20,
		'minlength'		=> 2,
		'required'		=> TRUE,
		'readonly'		=> FALSE,
		'default_val'	=> 'Cast'
	),
	'archive_page_term'	=> array(
		'label'			=> 'Archive Terminology',
		'db_field'		=> 'site_archive_term',
		'type'			=> 'text',
		'guide'			=> 'Your preferred term for "archive" (e.g. "Archive", "All Pages", "All Strips", "Episode List")',
		'pattern'		=> "[A-z0-9 -_]{1,}",
		'maxlength'		=> 20,
		'minlength'		=> 2,
		'required'		=> TRUE,
		'readonly'		=> FALSE,
		'default_val'	=> 'Archive'
	),
	'archive_list_style'=> array(
		'label'			=> 'Archive List Style',
		'db_field'		=> 'site_archive_list',
		'type'			=> 'dropdown',
		'guide'			=> 'What sort of list you want to display comics with (e.g. numbered, bullet-pointed)',
		'required'		=> TRUE,
		'readonly'		=> FALSE,
		'options'		=> array('Numbered','Bullet-pointed'),
		'default_val'	=> 'Bullet-pointed'
	),
	'rss_link_text'	=> array(
		'label'			=> 'RSS Link Text',
		'db_field'		=> 'site_rss_link_text',
		'type'			=> 'text',
		'guide'			=> 'The text that appears on the RSS feed link (e.g. "RSS Feed", "Grab the Feed")',
		'pattern'		=> "[A-z0-9 !?'-\.]{1,}",
		'maxlength'		=> 50,
		'minlength'		=> 2,
		'required'		=> TRUE,
		'readonly'		=> FALSE,
		'default_val'	=> 'RSS subscription feed'
	),
	'rss_number_items'	=> array(
		'label'			=> 'No. of Items in RSS Feed',
		'db_field'		=> 'site_rss_itemno',
		'type'			=> 'dropdown',
		'guide'			=> 'How many pages do you want to show in the RSS feed?',
		'required'		=> TRUE,
		'readonly'		=> FALSE,
		'options'		=> array('5','10','15','20'),
		'default_val'	=> '10'
	),
	'rss_format'	=> array(
		'label'			=> 'RSS Format',
		'db_field'		=> 'site_rss_format',
		'type'			=> 'dropdown',
		'guide'			=> 'Your preference of what you want to display in the RSS feed',
		'required'		=> TRUE,
		'readonly'		=> FALSE,
		'options'		=> array('Image and Excerpt','Image Only','Excerpt Only'),
		'default_val'	=> 'Image Only'
	),
	'date_format'	=> array(
		'label'			=> 'Date Format',
		'db_field'		=> 'site_date_format',
		'type'			=> 'dropdown',
		'guide'			=> 'Your preferred format for displaying the date (e.g. UK style, US style, full date)',
		'required'		=> TRUE,
		'readonly'		=> FALSE,
		'options'		=> array('d/m/Y','m/d/Y','l jS \of F, Y'),
		'default_val'	=> 'l jS \of F, Y'
	),
	'copyright_holder'	=> array(
		'label'			=> 'Copyright Holder',
		'db_field'		=> 'site_copyright',
		'type'			=> 'text',
		'guide'			=> 'Who the comic copyright belongs to - usually shown in the site footer!',
		'pattern'		=> "[A-z0-9 !?'-\.]{1,}",
		'maxlength'		=> 50,
		'minlength'		=> 2,
		'required'		=> TRUE,
		'readonly'		=> FALSE,
		'default_val'	=> 'Me'
	),
	'copyright_year'	=> array(
		'label'			=> 'Copyright Year Start',
		'db_field'		=> 'site_copyright_year',
		'type'			=> 'text',
		'guide'			=> 'What year does the copyright start from?',
		'pattern'		=> "[0-9]{1,4}",
		'maxlength'		=> 4,
		'minlength'		=> 4,
		'required'		=> TRUE,
		'readonly'		=> FALSE,
		'default_val'	=> date('Y')
	),
	'character_excerpt'	=> array(
		'label'			=> 'Use character excerpts on characters page',
		'db_field'		=> 'site_character_excerpt',
		'type'			=> 'checkbox',
		'guide'			=> 'By default the cast page will show excerpts - to just show a list of character names toggle this option',
		'required'		=> FALSE,
		'readonly'		=> FALSE,
		'default_val'	=> 'Yes'
	),
	'webby'			=> array(
		'label'			=> 'Show Webby the Comic Spider',
		'db_field'		=> 'site_webby',
		'type'			=> 'checkbox',
		'guide'			=> 'To make the simultaneously cute and terrifying Webby the Comic Spider disappear, toggle this option',
		'required'		=> FALSE,
		'readonly'		=> FALSE,
		'default_val'	=> 'Yes'
	)
);
$config['comic_nav'] = array(
	'options' 		=> array(
		'page_select' 	=> array(
			'label'		=> 'Page select drop-down menu',
			'default' 	=> 'bottom',
		),
		'chapter_jump'	=> array(
			'label'		=> 'Jump to chapter beginning/end links',
			'default' 	=> 'neither'
		),
		'chapter_select'=> array(
			'label'		=> 'Chapter select drop-down menu',
			'default' 	=> 'bottom'
		),
		'random'		=> array(
			'label'		=> 'Random page button',
			'default' 	=> 'neither'
		),
		'bookmark'		=> array(
			'label'		=> 'Bookmark - save the reader\'s place or load a previous bookmark',
			'default'	=> 'bottom'
		)
	),
	'placements' 	=> array('top','bottom','both','neither')
);

/*
| -------------------------------------------------------------------------
| Comic Page
| -------------------------------------------------------------------------
| Page settings, used in generating comic page management forms
*/
$config['webcomic'] = array(
	'title'			=> array(
		'label'			=> 'Page Title',
		'db_field' 		=> 'name',
		'type'			=> 'text',
		'guide'			=> 'The title of this comic page. Letters, numbers, limited punctuation and spaces only',
		'pattern'		=> "[A-z0-9 !?'-\.:&quot;&amp;]{1,}",
		'maxlength'		=> 255,
		'minlength'		=> 2,
		'required'		=> TRUE
	),
	'excerpt'	=> array(
		'label'			=> 'Excerpt / Synopsis',
		'db_field' 		=> 'excerpt',
		'type'			=> 'text',
		'guide'			=> 'A brief description of this page, used for things like the RSS feed and meta tags. Letters, numbers, limited punctuation and spaces only',
		'pattern'		=> "[A-z0-9 !?'-\.:&quot;&amp;]{1,}",
		'maxlength'		=> 255,
		'required'		=> FALSE
	),
	'hover-over'	=> array(
		'label'			=> 'Hover-over Text',
		'db_field' 		=> 'title_text',
		'type'			=> 'text',
		'guide'			=> 'The text that shows when you hover over the comic page with your cursor. If not set, defaults to the page title. Letters, numbers, limited punctuation and spaces only',
		'pattern'		=> "[A-z0-9 !?'-\.:&quot;&amp;]{1,}",
		'maxlength'		=> 255,
		'required'		=> FALSE
	),
	'schedule'		=> array(
		'label'			=> 'Publish Date',
		'db_field' 		=> 'published',
		'type'			=> 'date',
		'guide'			=> 'What date and time you wish the comic to be published. If not set, defaults to the current time',
		'datefield'		=> TRUE,
		'required'		=> TRUE
	),
	'transcript' 	=> array(
		'label'			=> 'Transcript',
		'db_field' 		=> 'transcript',
		'type'			=> 'ckeditor',
		'guide'			=> 'We recommend providing a text-only version of your comic page, for accessibility reasons and so search engines can find your pages more easily',
		'maxlength'		=> 100000
	),
	'blog' 			=> array(
		'label'			=> 'Blog Post',
		'db_field' 		=> 'notes',
		'type'			=> 'ckeditor',
		'guide'			=> 'Enter a blog post to accompany this comic e.g. page notes, what\'s going on with you, etc.',
		'maxlength'		=> 100000
	)
);

/*
| -------------------------------------------------------------------------
| Chapters and Subchapters
| -------------------------------------------------------------------------
| Chapter settings, used in generating chapter management forms
*/
$config['chapters'] = array(
	'title'			=> array(
		'label'			=> 'Chapter Title',
		'db_field' 		=> 'name',
		'type'			=> 'text',
		'guide'			=> 'The title of this comic chapter. Letters, numbers, limited punctuation and spaces only',
		'pattern'		=> "[A-z0-9 !?'-\.:&quot;&amp;]{1,}",
		'maxlength'		=> 255,
		'minlength'		=> 2,
		'required'		=> TRUE
	),
	'description' 	=> array(
		'label'			=> 'Chapter Description',
		'db_field' 		=> 'description',
		'type'			=> 'ckeditor',
		'guide'			=> 'Enter a textual description of the chapter e.g. what happens in it, etc.',
		'maxlength'		=> 10000
	)
);

/*
| -------------------------------------------------------------------------
| Characters
| -------------------------------------------------------------------------
| Chracter settings, used in generating profile page forms
*/
$config['characters'] = array(
    'name'       	=> array(
        'label'			=> 'Character Name',
        'db_field'		=> 'name',
        'type'			=> 'text',
        'guide'			=> 'The name of this character. Letters, numbers, limited punctuation and spaces only',
        'pattern'		=> "[A-z0-9 !?'-\.:&quot;&amp;]{1,}",
        'maxlength'		=> 255,
        'minlength'		=> 2,
        'required'		=> TRUE
    ),
	'excerpt' 			=> array(
		'label'			=> 'Character Excerpt',
		'db_field' 		=> 'excerpt',
		'type'			=> 'ckeditor',
		'guide'			=> 'A brief description of the character, used when showing character excerpts',
		'maxlength'		=> 500
	),
	'bio' 			=> array(
		'label'			=> 'Character Bio',
		'db_field' 		=> 'notes',
		'type'			=> 'ckeditor',
		'guide'			=> 'Enter some notes about the character (their personality, backstory, quirks, etc.)',
		'maxlength'		=> 10000
	),
	'active' 		=> array(
        'label'			=> 'Display on profile page?',
        'db_field'		=> 'profile_active',
        'type'			=> 'checkbox',
        'guide'			=> 'Do you want this character to appear on the profile page? If you want to hide it for the time being, untick this box',
    )
);

/*
| -------------------------------------------------------------------------
| Tags
| -------------------------------------------------------------------------
| Tag settings, used in generating tag forms
*/
$config['tags'] = array(
    'tag'       	=> array(
        'label'			=> 'Tag',
        'db_field'		=> 'label',
        'type'			=> 'text',
        'guide'			=> 'The tag you wish to add. Letters, numbers, limited punctuation and spaces only',
        'pattern'		=> "[A-z0-9 !?'-\.:&quot;&amp;]{1,}",
        'maxlength'		=> 255,
        'minlength'		=> 2,
        'required'		=> TRUE
    )
);

/*
| -------------------------------------------------------------------------
| Redirects
| -------------------------------------------------------------------------
| Redirect settings, used in generating redirect forms
*/
$config['redirects'] = array(
    'url'       	=> array(
        'label'			=> 'Old Web Address Slug',
        'db_field'		=> 'url',
        'type'			=> 'text',
        'guide'			=> 'The URL that needs to be redirected from',
        'pattern'		=> "[A-z0-9-_]{1,}",
        'maxlength'		=> 255,
        'minlength'		=> 2,
        'required'		=> TRUE
    ),
	'redirect'       	=> array(
        'label'			=> 'New Web Address Slug',
        'db_field'		=> 'redirect',
        'type'			=> 'text',
        'guide'			=> 'Where the old URL will redirect to (needs to match an existing slug)',
        'pattern'		=> "[A-z0-9-_]{1,}",
        'maxlength'		=> 255,
        'minlength'		=> 2,
        'required'		=> TRUE
    )
);

/*
| -------------------------------------------------------------------------
| 'About' Page
| -------------------------------------------------------------------------
| 'About' page settings, used in generating synopsis page forms
*/
$config['about'] = array(
    'title'       	=> array(
        'label'			=> 'About Page Title',
        'db_field'		=> 'about_title',
        'type'			=> 'text',
        'guide'			=> 'The title for your "about" page. Letters, numbers, limited punctuation and spaces only',
        'pattern'		=> "[A-z0-9 !?'-\.:&quot;&amp;]{1,}",
        'maxlength'		=> 255,
        'minlength'		=> 2,
        'required'		=> FALSE
    ),
	'about' 		=> array(
		'label'			=> 'About the Comic',
		'db_field' 		=> 'about_details',
		'type'			=> 'ckeditor',
		'guide'			=> 'Enter some notes about the comic e.g. a synopsis, brief description, etc. Go nuts!',
		'maxlength'		=> 10000
	)
);

/*
| -------------------------------------------------------------------------
| Templates
| -------------------------------------------------------------------------
| Template settings, used in handling templates
*/
$config['templates'] = array(
	'template_dir' 				=> './assets/templates/',
	'template_info' 			=> 'index.html',
	'template_file' 			=> 'template.html',
	'template_css'				=> 'template.css',
	'template_preview'			=> 'preview.png',
	'default_preview'			=> '/assets/icons/no-preview.png',
	'preview_img_dimensions'	=> array('width' => '200', 'height' => '200'),
	'template_mappings'			=> array(
		'pages'				=> 'template.html',
		'about'				=> 'about.html',
		'archive' 			=> 'archive.html',
		'cast'				=> 'cast_list.html',
		'profile' 			=> 'profile.html',
		'tags'				=> 'tags.html',
		'search'			=> 'search.html',
		'404'				=> '404.html'
	)
);

/*
| -------------------------------------------------------------------------
| File Upload Restrictions
| -------------------------------------------------------------------------
| Restrictions for different image types
*/
$config['uploads'] = array(
	'banners'		=> array(
		'max_size'		=> 5000,
		'max_width' 	=> 1000,
		'max_height'	=> 1000,
		'allowed_types'	=> 'gif|jpg|png'
	),
	'pages'			=> array(
		'max_size'		=> 10000,
		'max_width'		=> 1000,
		'max_height'	=> 20000,
		'allowed_types'	=> 'gif|jpg|png|swf'
	),
	'favicon'		=> array(
		'max_size'		=> 1000,
		'max_width'		=> 32,
		'max_height'	=> 32,
		'allowed_types'	=> 'ico|png'
	),
	'navigation_buttons'=> array(
		'max_size'		=> 5000,
		'max_width'		=> 200,
		'min_width'		=> 200,
		'max_height'	=> 700,
		'min_height'	=> 700,
		'allowed_types'	=> 'png'
	),
	'profile_img'	=> array(
		'max_size'		=> 10000,
		'max_width'		=> 1000,
		'max_height'	=> 1000,
		'allowed_types'	=> 'gif|jpg|png'
	)
);
$custom_filepath = './assets/custom/';
$config['custom_file_paths'] = array(
	'navigation_buttons' 	=> $custom_filepath . "navigation_buttons.png",
	'favicon'				=> array( //Favicon can be one of two types
		$custom_filepath . "favicon.ico",
		$custom_filepath . "favicon.png"
	)
);

/* End of file webcomic.php */
/* Location: ./application/config/webcomic.php */
