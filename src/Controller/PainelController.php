<?php

namespace App\Controller;

use App\Config\jwtSecurity;
use App\Config\Render;
use App\Models\Users;

class PainelController
{

    private $users;

    public function __construct()
    {

        $this->users = new Users();
    }
    public function Index()
    {
        $title = 'Titulo 01';
        $id = jwtSecurity::idLogin();   
        $u = $this->users->getById($id);
        $username = $u['Name'];
        Render::page('Usuarios/index', compact('title', 'u','username'));
    }

    public function Usuarios($request)
    {
        echo "Users";
        echo $request['id'];
    }
}
