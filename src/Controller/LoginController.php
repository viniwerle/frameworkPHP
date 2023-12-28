<?php

namespace App\Controller;

use App\Config\JwtSecurity;
use App\Config\Password;
use App\Config\Render;
use App\Models\Users;

class LoginController
{

    private $_users;

    public function __construct()
    {
        $this->_users = new Users();
    }
    public function Index($request)
    {
        if (JwtSecurity::isLogin()) {
            header("Location: /");
        } else {
            Render::page('Login/index', $request);
        }
    }

    public function LoginPassword($request)
    {
        $login = new JwtSecurity();
        if ($login->login($request['email'], $request['password'])) {
            header('HTTP/1.1 200 OK');
            exit();
        } else {
            header('HTTP/1.1 401 Unauthorized');
            exit("Credenciais inválidas. Acesso não autorizado.");
        }
    }

    public function Register()
    {
        Render::page('Login/register');
    }

    public function NewUser($request)
    {
        //Verifica se o email já é cadastrado
        if (!$this->_users->getByEmail($request['email'])) {

            $salt = Password::generateSalt();
            $senhaHash = Password::hashPassword($request['password'], $salt);
            $data = [
                "Name" => $request['name'],
                "Email" => $request['email'],
                'Hash' => $senhaHash,
                "Salt" => $salt
            ];
            $return = $this->_users->create($data);
            if ($return) {
                header('HTTP/1.1 200 OK');
                exit();
            } else {
                header('HTTP/1.1 401 Unauthorized');
                exit("Um erro ocorreu");
            }
        } else {
            header('HTTP/1.1 401 Unauthorized');
            exit("Email já registrado");
        }
    }
}
