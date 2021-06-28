<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

// $db['default'] = array(
// 	'dsn'	=> '',
// 	'hostname' => 'localhost',
// 	'username' => '',
// 	'password' => '',
// 	'database' => '',
// 	'dbdriver' => 'mysqli',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

// $db['iis'] = array(
//     'dsn'    => '',
//     'hostname' => '122.3.242.42:6969',
//     'username' => 'iis',
//     'password' => 'agentx3mbvii158459',
//     'database' => 'embis',
//     'dbdriver' => 'mysqli',
//     'dbprefix' => '',
//     'pconnect' => FALSE,
//     'db_debug'=> FALSE,
//     'db_debug' => (ENVIRONMENT !== 'production'),
//     'cache_on' => FALSE,
//     'cachedir' => '',
//     'char_set' => 'utf8',
//     'dbcollat' => 'utf8_general_ci',
//     'swap_pre' => '',
//     'encrypt' => FALSE,
//     'compress' => FALSE,
//     'stricton' => FALSE,
//     'failover' => array(),
//     'save_queries' => TRUE
// );

$db['opms'] = array(
    'dsn'    => '',
    'hostname' => '192.168.91.203:3306',
    'username' => 'opms_viewer',
    'password' => '5S+,njk)d&@`Q!]P',
    'database' => 'opms_utf8mb4',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug'=> FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
 
 



