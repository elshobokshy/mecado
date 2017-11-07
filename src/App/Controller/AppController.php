<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class AppController extends Controller
{
    public function home(Request $request, Response $response)
    {
        if($this->auth->guest())
            return $this->view->render($response, 'App/home.twig');
        else
            return $this->redirect($response, 'myaccount');
    }

    public function myaccount(Request $request, Response $response)
    {
        if($this->auth->guest())
            return $this->redirect($response, 'home');
        else
            return $this->view->render($response, 'App/myaccount.twig');
    }
}
