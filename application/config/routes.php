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

//Admin : user management
$route['users/employees'] = 'users/employees';
$route['users/export'] = 'users/export';
$route['users/import'] = 'users/import';
$route['users/reset/(:num)'] = 'users/reset/$1';
$route['users/create'] = 'users/create';
$route['users/edit/(:num)'] = 'users/edit/$1';
$route['users/delete/(:num)'] = 'users/delete/$1';
$route['users/(:num)'] = 'users/view/$1';
$route['users/check/login'] = 'users/check_login';
$route['users'] = 'users';

//Edit locations
$route['locations/delete/(:num)'] = 'locations/delete/$1';
$route['locations/edit/(:num)'] = 'locations/edit/$1';
$route['locations/index'] = 'locations/index';
$route['locations/select'] = 'locations/select';
$route['locations/create'] = 'locations/create';
$route['locations/export'] = 'locations/export';
$route['locations'] = 'locations';

//Rooms
$route['locations/(:num)/rooms'] = 'rooms/index/$1';
$route['locations/(:num)/rooms/create'] = 'rooms/create/$1';
$route['locations/(:num)/rooms/(:num)/delete'] = 'rooms/delete/$1/$2';
$route['locations/(:num)/rooms/(:num)/edit'] = 'rooms/edit/$1/$2';
$route['locations/(:num)/rooms/export'] = 'rooms/export/$1';

$route['rooms/book/(:num)'] = 'rooms/book/$1';
$route['rooms/qrcode/(:num)'] = 'rooms/qrcode/$1';
$route['rooms/status/(:num)'] = 'rooms/status/$1';
$route['rooms/calendar/(:num)'] = 'rooms/calendar/$1';
$route['rooms/calfeed/(:num)'] = 'rooms/calfeed/$1';

//Timeslots
$route['timeslots/accept/(:num)'] = 'timeslots/accept/$1';
$route['timeslots/reject/(:num)'] = 'timeslots/reject/$1';
$route['rooms/(:num)/timeslots'] = 'timeslots/room/$1';
$route['timeslots/me'] = 'timeslots/user';
$route['timeslots/validation'] = 'timeslots/validation';
$route['timeslots/manager/delete/(:num)'] = 'timeslots/delete_validation/$1';
$route['timeslots/me/delete/(:num)'] = 'timeslots/delete_booking/$1';
$route['rooms/(:num)/timeslots/(:num)/edit'] = 'timeslots/edit/$1/$2';
$route['rooms/(:num)/timeslots/(:num)/delete'] = 'timeslots/delete/$1/$2';
$route['timeslots'] = 'timeslots';

//Session management
$route['session/login'] = 'session/login';
$route['session/logout'] = 'session/logout';
$route['session/language'] = 'session/language';
$route['session/forgetpassword'] = 'session/forgetpassword';

//REST API
$route['api/rooms'] = 'api/getRooms';
$route['api/rooms/(:num)/timeslots'] = 'api/getTimeslotsByRoomId/$1';
$route['api/rooms/(:num)/status'] = 'api/getRoomStatus/$1';

$route['default_controller'] = 'locations';

/* End of file routes.php */
/* Location: ./application/config/routes.php */

// available user

$route['users/availability'] = 'users/availability';
$route['users/(:num)/availability/busy'] = 'users/setBusy/$1';
$route['users/(:num)/availability/free'] = 'users/setFree/$1';
