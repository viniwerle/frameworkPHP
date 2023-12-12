<?php

namespace App\Config;

use Exception;

class Render
{

    public static function page($namePage, $data = [])
    {
        $templatePath = (__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $namePage . '.view.php');
        ob_start();
        extract($data);
        include $templatePath;
        $content = ob_get_clean();

        echo $content;
    }
}
