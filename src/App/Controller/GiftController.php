<?php

namespace App\Controller;

use App\Model\Gift;
use App\Model\Commentgift;
use Slim\Http\Request;
use Slim\Http\Response;


class GiftController extends Controller
{
    public function newgift(Request $request, Response $response)
    {
        $data['test'] = 'bleu';



        return $this->view->render($response, 'Gift/newgift.twig', $data);
    }

    public function newComment($gift, $author, $content){
        $comment = new Commentgift();
        $comment->gift_id = $gift;
        $comment->author = $author;
        $comment->content = $content;
        $comment->save();
    }

    public function book(Request $request, Response $response, $token, $id){
        $author = $request->getParam('author');
        $content = $request->getParam('content');
        $gift = Gift::find($id);
        $this->newComment($id, $author, $content);
        $gift->booked = 1;
        $gift->save();
        return $this->redirect($response,'list', ['token'=>$token]);
    }
}
