<?php
require __DIR__ . '/../vendor/autoload.php';
$app = new \App\App;
define("READYCRM_SECRET_KEY","pgk");
define("READYCRM_COOKIE_NAME","readycrm");
define("READYCRM_TOKEN_ALGORITHM","HS256");
// ต้อง  set cookie ชื่อ readycrm โดยส่ง token เป็น jwt มี SECRET_KEY = pgk และ เข้ารหัสเป็น HS256
$container = $app->getContainer();

$container->jwt = function ($container) use ($app) {
    return new StdClass;
};


// ดัก ถ้ามี cookie แต่ไม่มี part จะโหลดไปหน้าหลักให้ แต่ถ้าไม่มี cookie จะโหลดข้อมูลไปหน้า login 

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

if(empty(str_replace("http://localhost/mvc_slim/public/","",$actual_link)) && !empty($_COOKIE['readycrm'])){
    header('Location: /mvc_slim/public/other/menu_controller');
    exit;
}
// ดัก ถ้ามี cookie แต่ไม่มี part จะโหลดไปหน้าหลักให้ แต่ถ้าไม่มี cookie จะโหลดข้อมูลไปหน้า login 


$app->add(new \Slim\Middleware\JwtAuthentication([
    
    "secure" => true,
    "relaxed" => ["localhost", "crm.readyplanet.com", "crm-dev.readyplanet.com"],
    "path" => "/",
    "passthrough" => ["/login","/ckeck_login","/other/profile","/other/login","/other/main_page","/insert_menu","/get_data/mvc_menu","/other/edit_menu","/other/edit_menu/1","/edit_menu_confirm","/add_menu_confirm","/other/del_menu","/calldata/mvc_menu","/other/menu_controller","/other/main_content","/other/management_content","/other/managent_content/add_content_confirm","/other/managent_content/edit_content_confirm","/other/edit_content","/other/edit_content/1","/other/del_content","/calldata/mvc_content","/other/edit_profile_detail","/templates/img/","/api_function_call","/check_login_client","/calldata/mvc_content","/place","/frontend/login_frontend","/frontend/home","/frontend/profile","/other/managent_profile","/other/profile/1","/check_admin_login","/other/show_profile"],
    "secret" => READYCRM_SECRET_KEY,
    "cookie" => READYCRM_COOKIE_NAME,
    "callback" => function ($request, $response, $arguments) use ($container) {
        $container->jwt = $arguments["decoded"];
    },
    "error" => function ($request, $response, $arguments) {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];

        if(!empty(((@$request->getHeader("Authorization")[0])))){
            return $response
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }else{
            return $response->withRedirect($request->getUri().'login'); 
        }
        
    }
]));


require __DIR__ . '/../src/routes.php';

$app->run();
