<?php

namespace App\Config;

use Exception;

class Render
{

    protected $sections    = [];
    protected $lastSection = null;
    protected $layout      = null;
    protected $data        = [];
    protected $filename    = null;

    public function __construct($filename, array $data = [])
    {
        $this->filename = $filename;
        $this->data = $data;
    }

    public function getSection($name)
    {
        echo $this->sections[$name] ?? null;
    }
    public function extends($name)
    {
        extract($this->data);
        ob_start();
        $templatePath = (__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $name . '.view.php');
        require $templatePath;
        echo ob_get_clean();
    }

    public function section($name)
    {
        ob_start();
        $this->lastSection = $name;
    }

    public function end()
    {

        $this->sections[$this->lastSection] = trim(ob_get_clean());

        $this->lastSection = null;
    }

    public function render()
    {
        extract($this->data);

        ob_start();

        require $this->filename;

        if ($this->layout) {
            $templatePath = (__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $this->layout . '.view.php');
            require $templatePath;
        }

        return ob_get_clean();
    }

    public function layout($layout)
    {
        $this->layout = $layout;
    }

    public static function page($namePage, $data = [])
    {
        $namePage = (__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $namePage . '.view.php');
        $page = new Render($namePage, $data);
        echo $page->render();
    }

    public static function publicDisk($url)
    {
        echo "http://localhost:8000/" . $url;
    }
}
