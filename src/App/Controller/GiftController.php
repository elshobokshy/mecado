<?php

namespace App\Controller;

use App\Model\Commentgift;
use App\Model\Giftlist;
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
                    'rules' => V::notEmpty()->length(1, 25),
                    'messages' => [
                        'notEmpty' => 'Please write the name of the gift.'
                    ]
                ],
                'description' => [
                    'rules' => V::length(0, 255),
                    'messages' => [
                        'length' => 'The description need less than 255 characters'
                    ]
                ],
                'price' => [
                    'rules' => V::notEmpty()->numeric()->positive(),
                    'messages' => [
                        'notEmpty' => 'Please give an approximate price for the gift.',
                        'numeric' => 'You need to put a number',
                        'positive' => 'A price must be positive '
                    ]
                ],
            ]);

            if ($this->validator->isValid()) {
                $gift = new Gift($request->getParams());

                if ($_FILES['picture']['error'] === UPLOAD_ERR_OK) {
                    if ($_FILES['picture']['error'] > 0) {
                        $this->flash('danger', 'Erreur lors du transfert');
                    }
                    $extension = strtolower(substr(strrchr($_FILES['picture']['name'], '.'), 1));
                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                        $nname = bin2hex(random_bytes(8)) . '.' . $extension;
                        $name = "../assets/img/gift_picture/$nname"; //TODO URL in public
                        move_uploaded_file($_FILES['picture']['tmp_name'], $name);
                        $gift->picture = $nname;
                        $_FILES['picture'] = null;
                    } else {
                        $this->flash('danger', 'File is not valid. Please try again');
                    }
                }
                $gift->save();
                $this->flash('success', 'The gift has been added.');
                return $this->redirect($response, 'list', ['token' => $token]);
            }
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

    public function delete(Request $request, Response $response, $token, $id)
    {
        $gift = Gift::find($id);
        $comments = $gift->commentgift;
        foreach ($comments as $comment) {
            Commentgift::destroy($comment->id);
        }
        Gift::destroy($id);

        $this->flash('success', 'The gift has been deleted.');
        return $this->redirect($response, 'list', ['token' => $token]);
    }
}
