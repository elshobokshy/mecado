<?php

namespace App\Controller;

use App\Model\Gift;
use Slim\Http\Request;
use Slim\Http\Response;

class TestController extends Controller
{
    public function test(Request $request, Response $response)
    {
        $data['test'] = 'bleu';

        return $this->view->render($response, 'Test/test.twig', $data);
    }
}
