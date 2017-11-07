<?php

namespace App\Controller;

use App\Model\Giftlist;
use Slim\Http\Request;
use Slim\Http\Response;

class TestController extends Controller
{
    public function test(Request $request, Response $response)
    {
        $gl =  Giftlist::find(1);
        $data['test'] = [$gl->gift];
        return $this->view->render($response, 'Test/test.twig', $data);
    }
}
