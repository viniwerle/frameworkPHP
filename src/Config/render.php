<?php

namespace App\Config;

class Render
{

    public static function page($namePage)
    {
        $template = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $namePage . '.html');
        echo $template;
    }
}
