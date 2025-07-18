<?php

namespace Core;

class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new \Core\View();
    }

    protected function view($name, $data = [])
    {
        echo $this->view->render($name, $data);
    }
}
