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
use Dflydev\FigCookies\SetCookie;
use App\Model\Giftlist;
use Slim\Http\Request;
use Slim\Http\Response;

class ListController extends Controller
{
    public function myLists(Request $request, Response $response){
        $lists = Giftlist::where('user_id', $this->auth->getUser()->id)->get();

        $currentDate = strtotime(date_format(new \DateTime(), 'Y-m-d'));
        $data = [
                'lists' => $lists,
                'current' => $currentDate
            ];

        return $this->view->render($response, 'App/mylists.twig', $data);

    }

    public function addList(Request $request, Response $response){

        if ($request->isPost()) {
            $name = $request->getParam('name');
            $description = $request->getParam('description');
            $recipient = $request->getParam('recipient');   
            $date = $request->getParam('date');

            $user_id = $this->auth->getUser()->id;
            $token = bin2hex(random_bytes(32));

            $expiry_date = new \DateTime($date);
            $expiry = $expiry_date->modify('+2 day');

            if($recipient == 'myself') {
                $recipient = $this->auth->getUser()->first_name;
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

        $data = [
            'user' => $this->auth->getUser(),
        ];

        return $this->view->render($response, 'App/addlist.twig', $data);
    }

    public function fetch(Request $request, Response $response, $token){
        $list = Giftlist::where('token',$token)->first();
        $gifts = $list->gift;
        $data = [
            'list' => $list,
            'gifts' => $gifts
        ];
        return $this->view->render($response,'App/list.twig', $data);
    }
}