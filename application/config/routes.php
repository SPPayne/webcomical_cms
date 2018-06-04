<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/* Refs:
 * https://stackoverflow.com/questions/6180074/remove-controller-name-from-url-in-codeigniter-with-routes?rq=1
 * https://stackoverflow.com/questions/13298460/how-to-delete-the-name-of-the-controller-in-the-url-with-codeigniter
 * https://www.codeigniter.com/userguide3/general/routing.html
 */

//Define our alternate controllers so the catch-all doesn't attempt to route everything through /comic/
//Ref: http://abetobing.com/blog/hooking-routes-php-codeigniter-create-user-based-personal-short-url-alias-70.html

//Get contents of controller folder...
$controllers_path 	= "./application/controllers/";
$controllers 		= array_diff(scandir($controllers_path),array('..','.','Comic.php','index.html'));

//If controllers...
if(!empty($controllers)){
	
	//Loop and clean up
	foreach($controllers as $key => $value){
		$controllers[$key] = strtolower(basename($value,".php"));
	}
	
	//Set the routes!
	foreach($controllers as $controller){
		$route[$controller] 										= $controller;
		$route[$controller.'/(:any)'] 								= $controller.'/$1';
		$route[$controller.'/(:any)/(:any)'] 						= $controller.'/$1/$2';
		$route[$controller.'/(:any)/(:any)/(:any)'] 				= $controller.'/$1/$2/$3';
		$route[$controller.'/(:any)/(:any)/(:any)/(:any)'] 			= $controller.'/$1/$2/$3/$4';
		$route[$controller.'/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= $controller.'/$1/$2/$3/$4/$5';
	}
	
}

//Route everything else through /comic/
$route['(:any)'] 								= "comic/$1";
$route['(:any)/(:any)'] 						= "comic/$1/$2";
$route['(:any)/(:any)/(:any)'] 					= "comic/$1/$2/$3";
$route['(:any)/(:any)/(:any)/(:any)'] 			= "comic/$1/$2/$3/$4";
$route['(:any)/(:any)/(:any)/(:any)/(:any)'] 	= "comic/$1/$2/$3/$4/$5";

//Defaults
$route['default_controller'] 	= 'comic';
$route['404_override'] 			= 'comic/page_not_found';
$route['translate_uri_dashes'] 	= FALSE;
