<?php

namespace Core;

class Controller
{
    protected $view;
    protected $breadcrumb = [];

    public function __construct()
    {
        $this->view = new \Core\View();
    }

    /**
     * Set the breadcrumb array for the view.
     * @param array $breadcrumb
     */
    protected function breadcrumb(array $breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * Render a view, automatically passing breadcrumb if set.
     */
    protected function view($name, $data = [])
    {
        if (!isset($data['breadcrumb']) && !empty($this->breadcrumb)) {
            $data['breadcrumb'] = $this->breadcrumb;
        }
        echo $this->view->render($name, $data);
    }
}
