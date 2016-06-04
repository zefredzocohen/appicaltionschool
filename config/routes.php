<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "main_default/index";
$route['404_override'] = '';

$route['admincp'] = 'login/load_login';
$route['validation_login'] = 'login/validation_login';
$route['admin'] = 'main/index';
$route['category/category_index/(:num)'] = 'category/category_index/$1';
$route['category/validation_category/(:num)'] = 'category/validation_category/$1';

$route['post/post_view/(:num)'] = 'post/post_view/$1';
$route['post/add_post/(:num)'] = 'post/add_post/$1';

$route['admin/manage_category'] = 'main/manage_category';
$route['post/manage_post/(:num)'] = 'post/manage_post/$1';
$route['(:num)-(:any)'] = 'main_default/archive/$1';
$route['(:num)/(:any)'] = 'main_default/page/$1/$2';
$route['(:any)/(:num)-(:any)'] = 'main_default/archive/$2';
$route['lien-he.html'] = 'main_default/contact';
$route['register-online'] = 'main_default/register';
$route['main_default/album/(:num)'] = 'main_default/album/$1';




/* End of file routes.php */
/* Location: ./application/config/routes.php */