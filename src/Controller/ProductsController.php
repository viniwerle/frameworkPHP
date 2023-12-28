<?php

namespace App\Controller;

use App\Config\jwtSecurity;
use App\Config\Render;
use App\Models\Users;

class ProductsController
{
    private $users;
    
    public function __construct()
    {

        $this->users = new Users();
    }
    public function List()
    {
        $title = 'Lista de produtos';
        $id = jwtSecurity::idLogin();
        $u = $this->users->getById($id);
        $username = $u['Name'];
        $products = [["id" => 1, "name" => "teste01"], ["id" => 1, "name" => "teste01"], ["id" => 1, "name" => "teste01"], ["id" => 1, "name" => "teste01"], ["id" => 1, "name" => "teste01"], ["id" => 1, "name" => "teste01"], ["id" => 1, "name" => "teste01"]];
        Render::page('Products/list', compact('title', 'u', 'username', 'products'));
    }

    public function AddProduct(){
        Render::page('Products/add');
    }


    public function Usuarios($request)
    {
        echo "Users";
        echo $request['id'];
    }
}
