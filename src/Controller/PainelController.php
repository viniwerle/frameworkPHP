<?php

namespace App\Controller;

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
        $title = 'TESTE';
        $u = $this->users->all();
        Render::page('Usuarios\index', compact('title', 'u'));
    }

    public function Usuarios($request)
    {
        echo "Users   ";
        echo $request['id'];
    }
}
