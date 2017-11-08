<?php

namespace App\Controller;

use App\Model\Gift;
use Slim\Http\Request;
use Slim\Http\Response;

class GiftController extends Controller
{
    public function newgift(Request $request, Response $response)
    {
        $data['test'] = 'bleu';



        return $this->view->render($response, 'Gift/newgift.twig', $data);
    }

    public function book(Request $request, Response $response, $token, $id){
        $gift = Gift::find($id);
        $gift->booked = 1;
        $gift->save();
        return $this->redirect($response,'list', ['token'=>$token]);
    }
}
