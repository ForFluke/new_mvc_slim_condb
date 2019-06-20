<?php

$app->get('/', ['\App\Controllers\HomeController', 'index']);

$app->get('/login', ['\App\Controllers\AuthController', 'index']);

$app->get('/place', ['\App\Controllers\PlaceController', 'index']);

$app->get('/place/{id}', ['\App\Controllers\PlaceController', 'getPlace']);

$app->post('/ckeck_login', ['\App\Controllers\HomeController', 'check_login']);

$app->get('/other/{main_page}', ['\App\Controllers\HomeController', 'other_page']);

$app->get('/other/edit_menu/{id}', ['\App\Controllers\HomeController', 'edit_menu']);

$app->post('/insert_menu', ['\App\Controllers\HomeController', 'insert_data']);

$app->post('/get_data/{table}', ['\App\Controllers\HomeController', 'get_data_in_db']);

$app->post('/other/edit_menu/edit_menu_confirm', ['\App\Controllers\HomeController', 'edit_menu_confirm']);
$app->post('/other/edit_menu/add_menu_confirm', ['\App\Controllers\HomeController', 'add_menu_confirm']);
$app->post('/other/del_menu', ['\App\Controllers\HomeController', 'del_menu']);

// $app->post('/get_data/mvc_menu', ['\App\Controllers\HomeController', 'get_data_in_db']);
