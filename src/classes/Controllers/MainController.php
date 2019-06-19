<?php
namespace App\Controllers;

use Slim\Views\Twig as View;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Firebase\JWT\JWT;

class MainController
{
    public $app;
    private $token_key = READYCRM_SECRET_KEY;
    private $token_algorithm = array(READYCRM_TOKEN_ALGORITHM);
    private $jwt;
    public function __construct()
    {
        global $app;
        $this->app = $app;
    }
    public function getRequestToken(){
        return $this->app->getContainer()->jwt;
    }
    public function setNewToken(){
        $data = array(
            "email"=>"anupong@readyplanet.com",
            "role"=>"user"
        );
        $token = array(
            "iss" => "http://crm.readyplant.com",  // (Issuer) Claim
            "aud" => "http://example.com",  // (Audience) Claim
            "iat" => 1497498329,            // (Issued At) Claim
            "nbf" => 1497498329,            // (Not Before Time) Claim
            "exp" => 1498813200, //1467277200,            // (Expiration Time) Claim
            "data" => $data
        );
        $this->jwt = JWT::encode($token, $this->token_key);
    }
    public function getNewToken(){
        return $this->jwt;
    }
    public function getDecodeToken(){
        try{
            $decoded = JWT::decode($this->jwt, $this->token_key, $this->token_algorithm);
            $decoded_array = (array) $decoded;
            return $decoded_array;
        }catch(Exception $e){
           return $this->screenMessage($e->getMessage());
        }
    }
    
    private function screenMessage($msg){
        if(strpos($msg,"Cannot handle token prior to") !== false){
            return "error_nbf";
        }else if(strpos($msg,"Expired token") !== false){
            return 'error_exp';
        }else{
            return '';
        }
    }
    public function index(Request $request, Response $response, View $view)
    {
//setcookie("readycrm", "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9jcm0ucmVhZHlwbGFudC5jb20iLCJhdWQiOiJodHRwOlwvXC9leGFtcGxlLmNvbSIsImlhdCI6MTQ5NzQ5ODMyOSwibmJmIjoxNDk3NDk4MzI5LCJleHAiOjE0OTg4MTMyMDAsImRhdGEiOnsiZW1haWwiOiJhbnVwb25nQHJlYWR5cGxhbmV0LmNvbSIsInJvbGUiOiJ1c2VyIn19.hOPUuT4d1iABs3f_b2O21KJc0nNSTp0pcGN20mCIvvc");

    }
}