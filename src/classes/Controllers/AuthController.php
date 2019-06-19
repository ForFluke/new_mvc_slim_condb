<?php
namespace App\Controllers;

use Slim\Views\Twig as View;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Auth as Auth;

class AuthController extends MainController
{
    public function index(Request $request, Response $response, View $view, Auth $auth)
    {
        setcookie("readycrm", "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9jcm0ucmVhZHlwbGFudC5jb20iLCJhdWQiOiJodHRwOlwvXC9leGFtcGxlLmNvbSIsImlhdCI6MTQ5NzQ5ODMyOSwibmJmIjoxNDk3NDk4MzI5LCJleHAiOjE0OTg4MTMyMDAsImRhdGEiOnsiZW1haWwiOiJhbnVwb25nQHJlYWR5cGxhbmV0LmNvbSIsInJvbGUiOiJ1c2VyIn19.hOPUuT4d1iABs3f_b2O21KJc0nNSTp0pcGN20mCIvvc");
        return $view->render($response, 'login.twig');
    }
}