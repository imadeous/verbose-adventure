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
    /**
     * Redirect to a given URL and exit.
     * @param string $url
     * @param int $statusCode
     */
    protected function redirect($url, $statusCode = 302)
    {
        if (!headers_sent()) {
            header('Location: ' . $url, true, $statusCode);
        } else {
            echo "<script>
        window.location.href = '" . addslashes($url) . "';
    </script>";
        }
        exit;
    }
    /**
     * Share a variable with the view.
     * @param string $key
     * @param mixed $value
     */
    protected function share($key, $value)
    {
        $this->view->share($key, $value);
    }
}
