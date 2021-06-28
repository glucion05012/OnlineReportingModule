<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Reportscontroller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// OPMS
$route['pto'] = 'Reportscontroller/pto';
$route['dp'] = 'Reportscontroller/dp';
$route['sqi'] = 'Reportscontroller/sqi';
$route['coc'] = 'Reportscontroller/coc';
$route['pcl'] = 'Reportscontroller/pcl';
$route['pmpin'] = 'Reportscontroller/pmpin';
$route['ccor'] = 'Reportscontroller/ccor';
$route['ccoi'] = 'Reportscontroller/ccoi';

