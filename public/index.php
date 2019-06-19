<?php
require __DIR__ . '/../vendor/autoload.php';
$app = new \App\App;
define("READYCRM_SECRET_KEY","pgk");
define("READYCRM_COOKIE_NAME","readycrm");
define("READYCRM_TOKEN_ALGORITHM","HS256");

$container = $app->getContainer();

$container->jwt = function ($container) use ($app) {
    return new StdClass;
};

$app->add(new \Slim\Middleware\JwtAuthentication([
    "secure" => true,
    "relaxed" => ["localhost", "crm.readyplanet.com", "crm-dev.readyplanet.com"],
    "path" => "/",
    "passthrough" => ["/login","/ckeck_login","/other/profile","/other/login","/other/main_page","/insert_menu","/get_data/mvc_menu","/other/edit_menu","/other/edit_menu/1" ],
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
