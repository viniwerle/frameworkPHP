<?php

namespace App\Controller;

use App\Config\jwtSecurity;
use App\Models\Users;
use App\Models\Users1;

class Teste
{
    protected $u;
    function __construct()
    {
        $this->u = new Users();
    }

    function index()
    {
        $this->u->seed();
        //$login = new jwtSecurity();
        //echo $login->login('teste@teste.com', 'teste');

        //$a = new Users();
        //$b = $a->getByEmail('viniciuswerle@gmail.com');
        //print_r($b);
        
    }
}
