<?php

namespace Security\Controller;

use App\Controller\Controller;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Respect\Validation\Validator as V;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthController extends Controller
{
    public function login(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $credentials = [
                'email' => $request->getParam('email'),
                'password' => $request->getParam('password')
            ];
            $remember = $request->getParam('remember') ? true : false;

            try {
                if ($this->auth->authenticate($credentials, $remember)) {
                    $this->flash('success', 'You are now logged in.');

                    return $this->redirect($response, 'myaccount');
                } else {
                    $this->validator->addError('auth', 'Bad username or password');
                }
            } catch (ThrottlingException $e) {
                $this->validator->addError('auth', 'Too many attempts!');
            }
        }

        return $this->view->render($response, 'App/home.twig');
    }

    public function register(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $first_name = $request->getParam('first_name');
            $last_name = $request->getParam('last_name');
            $email = $request->getParam('email');
            $password = $request->getParam('password');

            $this->validator->request($request, [
                'first_name' => [
                    'rules' => V::length(3, 25)->alpha()->noWhitespace(),
                    'messages' => [
                        'length' => 'First name should contain between 3 and 25 characters',
                        'alpha' => 'First name should contain only letters.',
                        'noWhitespace' => 'First name shouldn\'t contain any whitespaces'
                    ]
                ],
                'last_name' => [
                    'rules' => V::length(3, 25)->alpha(),
                    'messages' => [
                        'length' => 'First name should contain between 3 and 25 characters',
                        'alpha' => 'First name should contain only letters.',
                    ]
                ],
                'email' => [
                    'rules' => V::noWhitespace()->email(),
                    'messages' => [
                        'email' => 'The format you\'ve entered does not correspond to an email format'
                    ]
                ],
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
                ]
            ]);

            if ($this->auth->findByCredentials(['login' => $email])) {
                $this->validator->addError('email', 'This email is already in use! Please login instead.');
            }

            if ($this->validator->isValid()) {
                $role = $this->auth->findRoleByName('User');

                $user = $this->auth->registerAndActivate([
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'password' => $password,
                    'permissions' => [
                        'user.delete' => 0
                    ]
                ]);

                $role->users()->attach($user);

                $this->flash('success', 'Your account has been created.');

                return $this->redirect($response, 'home');
            }
        }

        return $this->view->render($response, 'Auth/register.twig');
    }

    public function logout(Request $request, Response $response)
    {
        $this->auth->logout();

        return $this->redirect($response, 'home');
    }


}
