<?php

namespace App\Controller;

use App\Model\Commentgift;
use App\Model\Giftlist;
use App\Model\Commentgift;
use Respect\Validation\Validator as V;
use App\Model\Gift;
use Slim\Http\Request;
use Slim\Http\Response;

class GiftController extends Controller
{
    public function newgift(Request $request, Response $response, $token)
    {

        if ($request->isPost()) {
            $this->validator->request($request, [
                'name' => [
                    'rules' => V::length(1, 25)->alpha(),
                    'messages' => [
                        'alpha' => 'Name needs to contains alpha characters only.',
                        'length' => 'Name should be 1 to 25 characters long.'
                    ]
                ],
                'description' => [
                    'rules' => V::length(1, 25)->alpha(),
                    'messages' => [
                        'alpha' => 'Last name needs to contains alpha characters only.',
                        'length' => 'Last name should be 1 to 25 characters long.'
                    ]
                ],
                'description' => [
                    'rules' => V::length(1, 25)->alpha(),
                    'messages' => [
                        'alpha' => 'Last name needs to contains alpha characters only.',
                        'length' => 'Last name should be 1 to 25 characters long.'
                    ]
                ],
            ]);

            $uploads_dir = '/img/gift_picture';
            foreach ($_FILES["picture"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["picture"]["tmp_name"][$key];
                    $name = $_FILES["picture"]["name"][$key];
                    move_uploaded_file($tmp_name, "$uploads_dir/$name");
                }
            }
            if ($_FILES['picture']['error'] > 0) {
                $this->flash('danger', 'Erreur lors du transfert');
            } /*else {
                if ($this->validator->isValid()) {
                    $resultat = move_uploaded_file($_FILES['picture']['tmp_name'],$nom);
                    (new Gift($request->getParams()))->save();
                    $this->flash('success', 'The gift has been added.');
                    return $this->redirect($response, 'list', ['token' => $token]);
                }
            }*/
        }
        $data['token'] = $token;
        $data['giftlist_id'] = Giftlist::where('token', $token)->first()->id;
        return $this->view->render($response, 'Gift/newgift.twig', $data);
    }

    public function newComment($gift, $author, $content)
    {
        $comment = new Commentgift();
        $comment->gift_id = $gift;
        $comment->author = $author;
        $comment->content = $content;
        $comment->save();
    }

    public function book(Request $request, Response $response, $token, $id)
    {
        $author = $request->getParam('author');
        $content = $request->getParam('content');
        $gift = Gift::find($id);
        $this->newComment($id, $author, $content);
        $gift->booked = 1;
        $gift->save();
        return $this->redirect($response, 'list', ['token' => $token]);
    }

    public function delete(Request $request, Response $response, $token, $id){
        $gift = Gift::find($id);
        $comments = $gift->commentgift;
        foreach ($comments as $comment){
            Commentgift::destroy($comment->id);
        }
        Gift::destroy($id);

        $this->flash('success', 'The gift has been deleted.');
        return $this->redirect($response,'list', ['token'=>$token]);
    }
}
