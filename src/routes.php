<?php

$app->get('/', ['\App\Controllers\HomeController', 'index']);

$app->get('/login', ['\App\Controllers\AuthController', 'index']);

$app->get('/place', ['\App\Controllers\PlaceController', 'index']);

$app->get('/place/{id}', ['\App\Controllers\PlaceController', 'getPlace']);

$app->post('/ckeck_login', ['\App\Controllers\HomeController', 'check_login']);

$app->post('/check_login_client', ['\App\Controllers\HomeController', 'check_login_client']);

$app->get('/other/main_content', ['\App\Controllers\HomeController', 'content_page']);

$app->get('/other/profile', ['\App\Controllers\HomeController', 'profile_page']);

$app->get('/other/{main_page}', ['\App\Controllers\HomeController', 'other_page']);

$app->get('/other/edit_menu/{id}', ['\App\Controllers\HomeController', 'edit_menu']);

$app->get('/other/edit_content/{id}', ['\App\Controllers\HomeController', 'edit_content']);

$app->post('/insert_menu', ['\App\Controllers\HomeController', 'insert_data']);

$app->post('/get_data/{table}', ['\App\Controllers\HomeController', 'get_data_in_db']);

//จัดการข้อมูล menu ใน db (เพิ่ม ลบ แก้ไข )
$app->post('/other/edit_menu/edit_menu_confirm', ['\App\Controllers\HomeController', 'edit_menu_confirm']);
$app->post('/other/edit_menu/add_menu_confirm', ['\App\Controllers\HomeController', 'add_menu_confirm']);
$app->post('/other/del_menu', ['\App\Controllers\HomeController', 'del_menu']);


//จัดการข้อมูล content ใน db (เพิ่ม ลบ แก้ไข )
$app->post('/other/edit_content/edit_content_confirm', ['\App\Controllers\HomeController', 'edit_content_confirm']);
$app->post('/other/managent_content/add_content_confirm', ['\App\Controllers\HomeController', 'add_content_confirm']);
$app->post('/other/del_content', ['\App\Controllers\HomeController', 'del_content']);

$app->post('/other/edit_profile_detail', ['\App\Controllers\HomeController', 'edit_profile_detail']);

// $app->post('/get_data/mvc_menu', ['\App\Controllers\HomeController', 'get_data_in_db']);

// call api  and use data 
$app->get('/calldata/mvc_menu', ['\App\Controllers\HomeController', 'mvc_menu_data_in_db']);

$app->get('/calldata/mvc_content', ['\App\Controllers\HomeController', 'request_content_api']);

$app->get('/calldata/{main_page}', ['\App\Controllers\HomeController', 'call_data_db']);

// test other request

$app->get('/api_function_call', ['\App\Controllers\HomeController', 'api_function_call']);
