<?php

namespace App\Database;

interface DatabaseConnectionInterface
{    
    public function connect();
    public function disconnect();
    public function query($sql);
    public function quote($string);
}
