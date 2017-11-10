<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 11/7/17
 * Time: 8:44 AM
 */

namespace App\Controller;

use Respect\Validation\Validator as V;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\SetCookie;
use App\Model\Giftlist;
use App\Model\Gift;
use App\Model\Commentlist;
use Security\Middleware\AuthMiddleware;
use Slim\Http\Request;
use Slim\Http\Response;

class ListController extends Controller
{
    public function myLists(Request $request, Response $response)
    {
        $lists = Giftlist::where('user_id', $this->auth->getUser()->id)->get();
        $URI = $this->getUriForActive($request);
        $currentDate = strtotime(date_format(new \DateTime(), 'Y-m-d'));
        $data = [
            'lists' => $lists,
            'current' => $currentDate,
            'uri' => $URI
        ];

        return $this->view->render($response, 'App/mylists.twig', $data);
    }

    public function addList(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $name = $request->getParam('name');
            $description = $request->getParam('description');
            $recipient = $request->getParam('recipient');
            $date = $request->getParam('date');

            $user_id = $this->auth->getUser()->id;
            $token = bin2hex(random_bytes(32));

            $expiry_date = new \DateTime($date);
            $expiry = $expiry_date->modify('+2 day');

            if ($recipient == $this->auth->getUser()->first_name) {
                $response = FigResponseCookies::set($response, SetCookie::create($token)->withValue($recipient)->withExpires($expiry)->withPath('/'));
            }

            $this->validator->request($request, [
                'name' => [
                    'rules' => V::notEmpty()->alnum('\' : !')->length(3, 25),
                    'messages' => [
                        'notEmpty' => 'Name shouldn\'t be empty.',
                        'alnum' => 'Name must not contain any special characters..',
                        'length' => 'Name should be 3 to 25 characters long.'
                    ]
                ],
                'description' => [
                    'rules' => V::notEmpty()->alnum('\' : !')->length(5, 1000),
                    'messages' => [
                        'notEmpty' => 'Description shouldn\'t be empty.',
                        'alnum' => 'Description must not contain any special characters.',
                        'length' => 'Description should be 5 to 1000 characters long.'
                    ]
                ],
                'recipient' => [
                    'rules' => V::length(1, 25)->alpha()->notEmpty(),
                    'messages' => [
                        'notEmpty' => 'Recipient shouldn\'t be empty.',
                        'alpha' => 'Recipient needs to contains alpha characters only.',
                        'length' => 'Recipient should be 1 to 25 characters long.'
                    ]
                ],
                'date' => [
                    'rules' => V::Date('Y-m-d'),
                    'messages' => [
                        'Date' => 'Date : Please use the Y-m-d format. Ex: 2000-01-31'
                    ]
                ],
            ]);

            if ($this->validator->isValid()) {
                $giftlist = new Giftlist();

                $giftlist->name = $name;
                $giftlist->description = $description;
                $giftlist->recipient = $recipient;
                $giftlist->date = $date;
                $giftlist->token = $token;
                $giftlist->user_id = $user_id;
                $giftlist->save();

                $this->flash('success', 'Your list has been created successfully.');

                return $this->redirect($response, 'addlist');
            }
        }
        $URI = $this->getUriForActive($request);
        $data = [
            'user' => $this->auth->getUser(),
            'uri' => $URI
        ];

        return $this->view->render($response, 'App/addlist.twig', $data);
    }

    public function editList(Request $request, Response $response, $token)
    {
        $list = Giftlist::where('token', $token)->first();

        if ($request->isPost()) {
            $name = $request->getParam('name');
            $description = $request->getParam('description');

            $this->validator->request($request, [
                'name' => [
                    'rules' => V::notEmpty()->alnum('\' : !')->length(3, 25),
                    'messages' => [
                        'notEmpty' => 'Name shouldn\'t be empty.',
                        'alnum' => 'Name must not contain any special characters..',
                        'length' => 'Name should be 3 to 25 characters long.'
                    ]
                ],
                'description' => [
                    'rules' => V::notEmpty()->alnum('\' : !')->length(5, 1000),
                    'messages' => [
                        'notEmpty' => 'Description shouldn\'t be empty.',
                        'alnum' => 'Description must not contain any special characters.',
                        'length' => 'Description should be 5 to 1000 characters long.'
                    ]
                ],
            ]);

            if ($this->validator->isValid()) {
                $list->name = $name;
                $list->description = $description;
                $list->save();

                $this->flash('success', 'Your list has been updated successfully.');

                return $this->redirect($response, 'mylists');
            }
        }
        $URI = $this->getUriForActive($request);
        $data = [
            'list' => $list,
            'uri' => $URI
        ];

        return $this->view->render($response, 'App/editmylist.twig', $data);
    }


    public function fetch(Request $request, Response $response, $token)
    {
        $list = Giftlist::where('token', $token)->with('commentlist', 'gift', 'commentgift')->first();
        $currentDate = strtotime(date_format(new \DateTime(), 'Y-m-d'));
        $cookie = FigRequestCookies::get($request, $token);
        $data = [
            'list' => $list,
            'current' => $currentDate,
            'cookie_name' => $cookie->getValue() === null ? 'notexists' : 'exists'
        ];
        return $this->view->render($response, 'App/list.twig', $data);
    }

    public function commentList(Request $request, Response $response, $token)
    {
        $list = Giftlist::where('token', $token)->first();
        $listId = $list->id;
        $author = $request->getParam('author');
        $content = $request->getParam('content');
        $this->validator->request($request, [
            'author' => [
                'rules' => V::notEmpty()->alpha()->length(3, 25),
                'messages' => [
                    'notEmpty' => 'Name shouldn\'t be empty.',
                    'alpha' => 'Author should only contain alphabetic characters.',
                    'length' => 'Name should be 3 to 25 characters long.'
                ]
            ],
            'content' => [
                'rules' => V::notEmpty()->alnum('\' : !')->length(5, 1000),
                'messages' => [
                    'notEmpty' => 'Description shouldn\'t be empty.',
                    'alnum' => 'Description must not contain any special characters.',
                    'length' => 'Description should be 5 to 1000 characters long.'
                ]
            ],
        ]);

        $data = [
            'token' => $token
        ];

        if ($this->validator->isValid()) {

            $this->newComment($listId, $author, $content);

            $this->flash('success', 'Your comment has been created.');
            return $this->redirect($response,'list',$data);
        }


        return $this->view->render($response, 'App/list.twig', $data);
    }

    public function newComment($list, $author, $content)
    {
        $comment = new Commentlist();
        $comment->giftlist_id = $list;
        $comment->author = $author;
        $comment->content = $content;
        $comment->save();
    }

    public function delete(Request $request, Response $response, $id)
    {
        $list = Giftlist::find($id);
        $gifts = $list->gift;
        foreach ($gifts as $gift) {
            $comments = $gift->commentgift;
            foreach ($comments as $comment) {
                Commentgift::destroy($comment->id);
            }
            Gift::destroy($gift->id);
        }
        $comments = $list->commentlist;
        foreach ($comments as $comment) {
            Commentlist::destroy($comment->id);
        }
        Giftlist::destroy($id);

        $this->flash('success', 'The list has been deleted.');
        return $this->redirect($response, 'mylists');
    }
}