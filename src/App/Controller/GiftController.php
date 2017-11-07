<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class GiftController extends Controller
{
    public function newgift(Request $request, Response $response)
    {
        $data['test'] = 'bleu';



        return $this->view->render($response, 'Gift/newgift.twig', $data);
    }
}
