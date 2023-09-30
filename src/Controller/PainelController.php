<?php

namespace App\Controller;

use App\Config\Render;
use App\Models\Users;

//use app\Models\Users;

class PainelController
{

    public function Index()
    {
        Render::page('Usuarios\index');
        $a = new Users();
        $a->addWhere(['id' => 1]);
        var_dump($a->all());
    }

    public function Usuarios($request)
    {
        echo "Users   ";
        echo $request['id'];
    }
}
