<?php
namespace App\Controllers;

use Slim\Views\Twig as View;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Place as Place;

class PlaceController extends MainController
{
    public function index(Request $request, Response $response, View $view, Place $place)
    {
        $result = $place->getPlaceList();
        
        echo $this->setNewToken();
        print_r($this->getDecodeToken());

        return $view->render($response, 'place.twig', array('places' => $result,'test'=>'test'));
    }

    public function getPlace(Request $request, Response $response, View $view, Place $place)
    {
        $id = $request->getAttribute('route')->getArgument('id');

        $result = $place->getPlace($id);

        return $view->render($response, 'place.twig', array('place' => $result));
    }
}