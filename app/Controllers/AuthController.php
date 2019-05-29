<?php

namespace App\Controllers;

use App\Models\User;
use Respect\Validation\Validator as v;

class AuthController extends BaseController
{
    public function getSignOut($req, $resp)
    {
        $this->auth->logout();
        $this->flash->addMessage('info', 'Вы вышли из аккаунта.');
        return $resp->withRedirect($this->router->pathFor('home'));
    }

    public function getSignIn($req, $resp)
    {
        return $this->view->render($resp, 'signin.html');
    }

    public function postSignIn($req, $resp)
    {
        $auth =  $this->auth->attempt(
            $req->getParam('name'),
            $req->getParam('password')
        );

        if (!$auth) {
            $this->flash->addMessage('error', 'Неверные данные для входа!.');
            return $resp->withRedirect($this->router->pathFor('auth.signin'));
        }

        $this->flash->addMessage('success', 'Успешный вход в аккаунт!');
        return $resp->withRedirect($this->router->pathFor('home'));
    }

    public function getSignUp($req, $resp)
    {
        return $this->view->render($resp, 'signup.html');
    }

    public function postSignUp($req, $resp)
    {
        $validation = $this->validator->validate($req, [
            'email' =>    v::noWhitespace()->notEmpty()->email(),
            'name' =>     v::noWhitespace()->length(5, 20),
            'password' => v::noWhitespace()->length(5, 15),
        ]);

        if ($validation->failed()) {
            return $resp->withRedirect($this->router->pathFor('auth.signup'));
        }
        //потом мб разберусь как кастомное правило делать
        if (strcmp($req->getParam('password'), $req->getParam('confirmation')) !== 0) {
            $_SESSION['errors']['confirmation'] =  'Введенные пароли не совпадают!';
            return $resp->withRedirect($this->router->pathFor('auth.signup'));
        }

        $user = [
            'email' => $req->getParam('email'),
            'name' => $req->getParam('name'),
            'password' => password_hash($req->getParam('password'), PASSWORD_DEFAULT),
        ];

        if (User::isExist($user)) {
            $_SESSION['errors']['global'] = 'Пользователь с такими данными уже существует!';
            return $resp->withRedirect($this->router->pathFor('auth.signup'));
        }

        User::create($user);

        $this->flash->addMessage('success', 'Аккаунт успешно создан!');

        $this->auth->attempt($user['name'], $req->getParam('password'));

        return $resp->withRedirect($this->router->pathFor('home'));
    }
}
