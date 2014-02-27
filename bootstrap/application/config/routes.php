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

$route['mobile'] = 'mobile/pages/view/home';
$route['mobile/page/(:any)'] = 'mobile/pages/view/$1';
$route['mobile/login'] = 'mobile/login';
$route['mobile/tasks'] = 'mobile/tasks';
$route['mobile/tasks/(:any)'] = 'mobile/tasks/view/$1';
$route['mobile/tasks/done'] = 'mobile/tasks/done';
$route['mobile/mob_check'] = 'mobile/login/mob_check';

$route['mobile/riskmap'] = 'mobile/larval';
$route['mobile/case_report'] = 'mobile/case_report';
$route['mobile/page/master_list'] = 'mobile/master_list';
$route['mobile/page/master_list/(:any)'] = 'mobile/master_list/$1';

// Mob Households
$route['mobile/page/addhh'] = 'mobile/master_list/add';
$route['mobile/household/(:num)/new_mem'] = 'mobile/household/add_mem_index';

$route['mobile/page/new_poi'] = 'mobile/poi/add';
$route['mobile/page/addls'] = 'mobile/larval_survey/add';

$route['mobile/logout'] = 'mobile/login/logout';

$route['default_controller'] = "website/pages/view";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */