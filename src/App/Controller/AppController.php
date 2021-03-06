<?php

namespace App\Controller;

use Cartalyst\Sentinel\Sentinel;
use Respect\Validation\Validator as V;
use App\Model\Commentgift;
use App\Model\Commentlist;
use App\Model\Gift;
use App\Model\Giftlist;

use Slim\Http\Request;
use Slim\Http\Response;

use Security\Model\User;

class AppController extends Controller
{
    public function home(Request $request, Response $response)
    {
        return $this->auth->check() ? $this->redirect($response, 'mylists') : $this->view->render($response, 'App/home.twig');
    }

    public function myaccount(Request $request, Response $response)
    {
        $URI = $this->getUriForActive($request);
        $data = [
            'uri' => $URI
        ];
        return $this->view->render($response, 'App/myaccount.twig', $data);
    }

    public function editProfile(Request $request, Response $response)
    {
        if (isset($_POST['change_details'])) {
            if ($request->isPost()) {
                $first_name = $request->getParam('first_name');
                $last_name = $request->getParam('last_name');

                $this->validator->request($request, [
                    'first_name' => [
                        'rules' => V::length(1, 25)->alpha()->noWhitespace(),
                        'messages' => [
                            'noWhitespace' => 'First name shouldn\'t contain any white spaces.',
                            'alpha' => 'First name needs to contains alpha characters only.',
                            'length' => 'First name should be 1 to 25 characters long.'
                        ]
                    ],
                    'last_name' => [
                        'rules' => V::length(1, 25)->alpha(),
                        'messages' => [
                            'alpha' => 'Last name needs to contains alpha characters only.',
                            'length' => 'Last name should be 1 to 25 characters long.'
                        ]
                    ],
                ]);

                if ($this->validator->isValid()) {
                    $credentials = [
                        'first_name' => $first_name,
                        'last_name' => $last_name
                    ];

                    $this->auth->update($this->auth->getUser()->id, $credentials);

                    $this->flash('success', 'Your account has been updated.');

                    return $this->redirect($response, 'myaccount');
                }
                return $this->view->render($response, 'App/myaccount.twig');
            }
        } else if (isset($_POST["change_pw"])) {
            if ($request->isPost()) {
                $password = $request->getParam('password');
                $passwordOld = $request->getParam('password_old');

                $verify = [
                    'password' => $passwordOld,
                ];

                if (!$this->auth->validateCredentials($this->auth->getUser(), $verify)) {
                    $this->validator->addError('password', 'The old password isn\'t correct. Please try again.');
                }

                $this->validator->request($request, [
                    'password' => [
                        'rules' => V::noWhitespace()->length(6, 25),
                        'messages' => [
                            'length' => 'The password length must be between {{minValue}} and {{maxValue}} characters'
                        ]
                    ],
                    'password_confirm' => [
                        'rules' => V::equals($password),
                        'messages' => [
                            'equals' => 'Passwords don\'t match'
                        ]
                    ],
                ]);

                if ($this->validator->isValid()) {
                    $role = $this->auth->findRoleByName('User');

                    $credentials = [
                        'password' => $password,
                    ];

                    $this->auth->update($this->auth->getUser()->id, $credentials);

                    $this->flash('success', 'Your password has been updated.');

                    return $this->redirect($response, 'myaccount');
                }
                return $this->view->render($response, 'App/myaccount.twig');
            }

        } else if (isset($_POST["delete_account"])) {
            if ($request->isPost()) {
                $user = User::find($this->auth->getUser()->id);
                $lists = $user->giftlist;
                foreach ($lists as $list){
                    $gifts = $list->gift;
                    foreach ($gifts as $gift){
                        $comments = $gift->commentgift;
                        foreach ($comments as $comment){
                            Commentgift::destroy($comment->id);
                        }
                        Gift::destroy($gift->id);
                    }
                    $comments = $list->commentlist;
                    foreach ($comments as $comment){
                        Commentlist::destroy($comment->id);
                    }
                    Giftlist::destroy($list->id);
                }
                User::destroy($user->id);
                return $this->redirect($response, 'home');
            }
        }
    }

    public function about(Request $request, Response $response)
    {
        $URI = $this->getUriForActive($request);
        $data = [
            'uri' => $URI
        ];
        return $this->view->render($response, 'App/about.twig', $data);
    }

}
