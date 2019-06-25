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
        $session = new Session();
        return $view->render($response, 'login.twig');
    }

    public function check_login(Request $request, Response $response, View $view, Main_function $Main_function) {
        
        $params =  $request->getParams();
        $home_data = $Main_function->check_login($params['username'],$params['password']);
        echo json_encode($home_data);

        $_SESSION['member'] = $home_data ;
    }
    public function check_admin_login(Request $request, Response $response, View $view, Main_function $Main_function) {
        
        $params =  $request->getParams();
        $home_data = $Main_function->check_admin_login($params['username'],$params['password']);
        // echo $request->getHeader("Authorization")[0];
        $secret = "pgk";
        $token = JWT::encode($home_data, $secret, "HS256");
        $home_data['token'] =$token;

        echo json_encode($home_data);
        $_SESSION['member'] = $home_data ;
    }
    public function check_login_client (Request $request, Response $response, View $view, Main_function $Main_function) {
        $params =  $request->getParams();
        $data = array();
        $response = $Main_function->check_recaptcha($params['g_recaptcha_response']);
        $data['response'] = $response;
        $home_data = $Main_function->check_login($params['username'],$params['password']);
        $_SESSION['member'] = $home_data ;

        $secret = "your_secret_key";
        $token = JWT::encode($home_data, $secret, "HS256");
        $data['token'] =$token;
        if(isset($response) && $response['success'] == true && $response['score'] >= '0.1'){
            $data['status_login'] = $home_data;
            //เช็คว่าเป็นคน หรือ โรบอท โดยใช้ google recaptcha เช็ค ถ้า score น้อยกว่า 0.5 จะไม่ให้ผ่าน จะแสดงว่าเป็น โรบอท 
        }else{
            $data['status_login'] = false;
        }
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

    public function frontend_page(Request $request, Response $response, View $view , Main_function $Main_function){
        // แสดงผลข้อมูลผ่านการดึงข้อมูลหน้า frontend
        $main_page = $request->getAttribute('route')->getArgument('main_page');
        $data_session = $_SESSION;
        $data_session['data_menu'] = $Main_function->get_data_in_db('mvc_menu');
        return $view->render($response, 'frontend/'.$main_page.'/'.$main_page.'.twig' ,[
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

    public function member_profile(Request $request, Response $response, View $view , Main_function $Main_function){
        $data_session = $_SESSION;
        $data_session['data_profile'] = $Main_function->get_data_in_db('mvc_member');
        return $view->render($response, 'managent_profile/managent_profile.twig' ,[
            'data' => $data_session 
        ]);
    } 

    public function edit_menu(Request $request, Response $response, View $view , Main_function $Main_function){
        $id = $request->getAttribute('route')->getArgument('id_page');
        $data_edit = $Main_function->edit_function($id);
        return $view->render($response, 'edit_menu/edit_menu.twig' ,[
            'data' => $data_edit 
        ]);
    } 

    public function edit_content(Request $request, Response $response, View $view , Main_function $Main_function){
        $id = $request->getAttribute('route')->getArgument('id');
        $data_edit = $Main_function->edit_content_function($id);
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
    public function request_content_api(Request $request, Response $response, View $view , Main_function $Main_function){
        $main_page = $request->getAttribute('route')->getArgument('main_page');
        $data_return = $Main_function->request_content_api('mvc_content');
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
       
        return $response->withRedirect('managent_profile'); 
    }
    public function profile_page(Request $request, Response $response, View $view , Main_function $Main_function){
        $data_session = $_SESSION;
        $data_session['member'] = $Main_function->show_profile($data_session['member']);
        return $view->render($response, 'profile/profile.twig' ,[
            'data' => $data_session 
        ]);
    } 

    public function api_function_call(Request $request, Response $response, View $view , Main_function $Main_function){
        $headers = $response->getHeaders();
            foreach ($headers as $name => $values) {
                echo $name . ": " . implode(", ", $values);
            }
        
    }
    public function select_profile_id(Request $request, Response $response, View $view , Main_function $Main_function){
        $id = $request->getAttribute('route')->getArgument('id_page');
        $data_return = $Main_function->call_member_by_id($id);
        $data_session['member'] = $Main_function->show_profile($data_return);
        return $view->render($response, 'profile/profile.twig' ,[
            'data' => $data_session 
        ]);
    }
}