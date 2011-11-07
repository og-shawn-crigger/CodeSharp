<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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

$route['default_controller'] = "content";
$route['404_override'] = '';







// Makes sure that when edit article form is sumitted then the right method is called
$route['admin-edit-content/edit-node/:num/submit'] = "admin_edit_content/submit";

//rewrites uri for the article pages
$route['article/(:any)'] = "content/article/$1";

//rewrites uri for the category pages
$route['category/(:any)'] = "content/category/$1";

//rewrites uri for the pagination
$route['index/(:any)'] = "content/index/$1";

//rewrites uri for admin_content
$route['admin-content'] = "admin_content";

//rewrites uri for admin_content
$route['admin-content/(:any)'] = "admin_content/$1";

//rewrites uri for Admin_Category
$route['admin-category'] = "admin_category";

//rewrites uri for Admin_Category
$route['admin-category/(:any)'] = "admin_category/$1";

//rewrites uri for Admin_Config
$route['admin-config'] = "admin_config";

//rewrites uri for Admin_Config
$route['admin-config/(:any)'] = "admin_config/$1";

//Admin_Edit_Content
$route['admin-edit-content'] = "admin_edit_content";

//Admin_Edit_Content
$route['admin-edit-content/(:any)'] = "admin_edit_content/$1";

//Admin_Edit_Content
$route['admin-edit-content/index/(:any)'] = "admin_edit_content/index/$1";


//Admin_Menu
$route['admin-menu'] = "admin_menu";

//Admin_Menu
$route['admin-menu/(:any)'] = "admin_menu/$1";

//Admin_User
$route['admin-user'] = "admin_user";

//Admin_User
$route['admin-user/(:any)'] = "admin_user/$1";







/* End of file routes.php */
/* Location: ./application/config/routes.php */
