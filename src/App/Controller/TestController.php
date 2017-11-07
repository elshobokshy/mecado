<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class TestController extends Controller
{
    public function test(Request $request, Response $response)
    {

        $data['test'] = 'test';

        return $this->view->render($response, 'Test/test.twig', $data);
    }
}
