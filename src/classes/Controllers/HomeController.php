<?php
namespace App\Controllers;

require_once __DIR__ . '/MainController.php';
session_start();

use Slim\Views\Twig as View;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Main_function as Main_function;
use Slim\Http\UploadedFile;

// ของ jwt
use \Firebase\JWT\JWT;
use \Tuupola\Base62;
// ของ jwt

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
    public function check_login_client (Request $request, Response $response, View $view, Main_function $Main_function) {
        $params =  $request->getParams();
        $home_data = $Main_function->check_login($params['username'],$params['password']);
        $_SESSION['member'] = $home_data ;
        $secret = "your_secret_key";
        $token = JWT::encode($home_data, $secret, "HS256");
        $data = array();
        $data['token'] =$token;
        $data['status_login'] = $home_data;
        echo json_encode($data);

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
    
    public function content_page(Request $request, Response $response, View $view , Main_function $Main_function){
        $data_session = $_SESSION;
        $data_session['data_menu'] = $Main_function->get_data_in_db('mvc_content');
        return $view->render($response, 'main_content/main_content.twig' ,[
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

    public function edit_content(Request $request, Response $response, View $view , Main_function $Main_function){
        $id = $request->getAttribute('route')->getArgument('id');
        $data_edit = $Main_function->edit_content_function($id);
        // echo '<pre>';print_r($data_edit);exit;
        return $view->render($response, 'management_content/management_content.twig' ,[
            'data' => $data_edit 
        ]);
    } 
    
    public function del_menu(Request $request, Response $response, View $view , Main_function $Main_function){
        $params =  $request->getParams();
        $data_edit = $Main_function->del_menu($params['del_id']);
        echo json_encode($data_edit);
    } 
    public function del_content(Request $request, Response $response, View $view , Main_function $Main_function){
        $params =  $request->getParams();
        $data_edit = $Main_function->del_content($params['del_id']);
        echo json_encode($data_edit);
    } 
    
    public function get_data_in_db(Request $request, Response $response, View $view , Main_function $Main_function){
        $table = $request->getAttribute('route')->getArgument('table');
        $home_data = $Main_function->get_data_in_db($table);
        echo json_encode($home_data);
    } 
    public function  edit_menu_confirm(Request $request, Response $response, View $view, Main_function $Main_function) {
        $params =  $request->getParams();
        $data_update = $params['data_from'];
        $home_data = $Main_function->edit_menu_confirm($data_update['menu_name'],$data_update['part_menu'],$data_update['status'],$data_update['id']);

       echo json_encode($home_data);
    }
    public function  add_menu_confirm(Request $request, Response $response, View $view, Main_function $Main_function) {
        $params =  $request->getParams();
        $data_update = $params['data_from'];
        $home_data = $Main_function->add_menu_confirm($data_update['menu_name'],$data_update['part_menu'],$data_update['status']);

       echo json_encode($home_data);
    }

    public function call_data_db(Request $request, Response $response, View $view , Main_function $Main_function){
        $main_page = $request->getAttribute('route')->getArgument('main_page');
        $data_return = $Main_function->get_data_in_db($main_page);
        echo json_encode($data_return);
    } 

    public function mvc_menu_data_in_db(Request $request, Response $response, View $view , Main_function $Main_function){
        $main_page = $request->getAttribute('route')->getArgument('main_page');
        $data_return = $Main_function->mvc_menu_data_in_db('mvc_menu');
        echo json_encode($data_return);
    } 
    public function  edit_content_confirm(Request $request, Response $response, View $view, Main_function $Main_function) {
        $params =  $request->getParams();
        $data_update = $params['data_from'];
        $home_data = $Main_function->edit_content_confirm($data_update['title'],$data_update['detail'],$data_update['id']);
       echo json_encode($home_data);
    }
    public function  add_content_confirm(Request $request, Response $response, View $view, Main_function $Main_function) {
        $params =  $request->getParams();
        $data_update = $params['data_from'];
        $home_data = $Main_function->add_content_confirm($data_update['title'],$data_update['detail']);
       echo json_encode($home_data);
    }

    public function edit_profile_detail(Request $request, Response $response, View $view, Main_function $Main_function) {
        $params =  $request->getParams();
       
            $uploadedFiles = $request->getUploadedFiles();
            $uploadedFile = $uploadedFiles['img'];
      
            $destination = "../../../templates/img/"; //part file upload
            $newfile = $uploadedFiles['img'];
      
            if ($newfile->getError() === UPLOAD_ERR_OK) {
                $uploadFileName = $newfile->getClientFilename();
                $newfile->moveTo(__DIR__ .$destination.''.$uploadFileName);
            }
            $params['img'] =  $uploadFileName;
        if(empty($params['img'])){
            $params['img'] =  $params['img_name'];
        }
        $home_data = $Main_function->edit_profile_detail($params);
       
        return $response->withRedirect('profile'); 
    }
    public function profile_page(Request $request, Response $response, View $view , Main_function $Main_function){
        $data_session = $_SESSION;
        $data_session['member'] = $Main_function->show_profile($data_session['member']);
        //echo '<pre>';print_r($data_session['detail']);
        return $view->render($response, 'profile/profile.twig' ,[
            'data' => $data_session 
        ]);
    } 

    public function api_function_call(Request $request, Response $response, View $view , Main_function $Main_function){
        $route = $request->getAttribute('route');
        $courseId = $route->getArgument('id');

        echo '<pre>';print_r($route);echo '</pre>';
        echo '<pre>';print_r($courseId);echo '</pre>';
    }
}