<?php
namespace App\Controllers;

require_once __DIR__ . '/MainController.php';
session_start();

use Slim\Views\Twig as View;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Main_function as Main_function;

class HomeController extends MainController {
    public function index(Request $request, Response $response, View $view) {
        return $view->render($response, 'login.twig');
    }

    public function check_login(Request $request, Response $response, View $view, Main_function $Main_function) {
        $params =  $request->getParams();
        $home_data = $Main_function->check_login($params['username'],$params['password']);
        echo json_encode($home_data);
        $_SESSION['member'] = $home_data ;
    }

    public function insert_data(Request $request, Response $response, View $view, Main_function $Main_function) {
        $params =  $request->getParams();
        $home_data = $Main_function->insert_member($params['menu_name'],$params['part_menu']);
    }

    public function other_page(Request $request, Response $response, View $view , Main_function $Main_function){
        $main_page = $request->getAttribute('route')->getArgument('main_page');
        $data_session = $_SESSION;
        $data_session['data_menu'] = $Main_function->get_data_in_db('mvc_menu');
        return $view->render($response, $main_page.'/'.$main_page.'.twig' ,[
            'data' => $data_session 
        ]);
    } 
    public function edit_menu(Request $request, Response $response, View $view , Main_function $Main_function){
        $id = $request->getAttribute('route')->getArgument('id');
        $data_edit = $Main_function->edit_function($id);
        // echo '<pre>';print_r($data_edit);exit;
        return $view->render($response, 'edit_menu/edit_menu.twig' ,[
            'data' => $data_edit 
        ]);
    } 

    public function get_data_in_db(Request $request, Response $response, View $view , Main_function $Main_function){
        $table = $request->getAttribute('route')->getArgument('table');
        $home_data = $Main_function->get_data_in_db($table);
        echo json_encode($home_data);
    } 
}