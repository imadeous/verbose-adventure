<?php

namespace Core;

class View
{
    protected $basePath;
    protected $layout = null;
    protected $sections = [];
    protected $currentSection = null;
    protected $shared = [];



    public function __construct($basePath = null)
    {
        $this->basePath = $basePath ?: dirname(__DIR__) . DIRECTORY_SEPARATOR;
    }

    public function layout($layout)
    {
        $this->layout = $layout;
    }

    public function start($section)
    {
        $this->currentSection = $section;
        ob_start();
    }

    public function end()
    {
        if ($this->currentSection === null) {
            throw new \Exception('No section started.');
        }
        $this->sections[$this->currentSection] = ob_get_clean();
        $this->currentSection = null;
    }

    public function yield($section)
    {
        return $this->sections[$section] ?? '';
    }

    public function render($name, $data = [])
    {
        $data = array_merge($this->shared, $data);
        extract($data);
        $viewPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $name);
        $fullPath = $this->basePath . "App" . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR . $viewPath . ".view.php";
        if (!file_exists($fullPath)) {
            // Redirect to ErrorController::viewNotFound
            $errorControllerClass = class_exists('App\\Controllers\\App\\ErrorController') ? 'App\\Controllers\\App\\ErrorController' : (class_exists('App\\Controller\\ErrorController') ? 'App\\Controller\\ErrorController' : null);
            if ($errorControllerClass) {
                $errorController = new $errorControllerClass();
                $errorController->viewNotFound($name);
                exit;
            } else {
                header('HTTP/1.1 500 Internal Server Error');
                echo "<b>View file not found:</b> $fullPath";
                exit;
            }
        }
        ob_start();
        require $fullPath;
        $content = ob_get_clean();

        if ($this->layout) {
            $layoutPath = $this->basePath . "App" . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR . "layouts" . DIRECTORY_SEPARATOR . $this->layout . ".php";
            if (!file_exists($layoutPath)) {
                echo "<b>Layout file not found:</b> $layoutPath";
                return $content;
            }
            // Make all data variables available in the layout
            extract($data);
            $contentSection = $this->sections['content'] ?? $content;
            $this->sections['content'] = $contentSection;
            ob_start();
            require $layoutPath;
            return ob_get_clean();
        }
        return $content;
    }

    public function partial($partial, $data = [])
    {
        $data = array_merge($this->shared, $data);
        extract($data);
        $partialPath = $this->basePath . "App" . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR . "partials" . DIRECTORY_SEPARATOR . $partial . ".php";
        if (!file_exists($partialPath)) {
            // Redirect to ErrorController::viewNotFound
            $errorControllerClass = class_exists('App\\Controllers\\App\\ErrorController') ? 'App\\Controllers\\App\\ErrorController' : (class_exists('App\\Controller\\ErrorController') ? 'App\\Controller\\ErrorController' : null);
            if ($errorControllerClass) {
                $errorController = new $errorControllerClass();
                $errorController->viewNotFound('partials/' . $partial);
                exit;
            } else {
                header('HTTP/1.1 500 Internal Server Error');
                echo "<b>Partial file not found:</b> $partialPath";
                exit;
            }
        }
        ob_start();
        require $partialPath;
        return ob_get_clean();
    }

    /**
     * Share a variable with all views and partials.
     * @param string $key
     * @param mixed $value
     */
    public function share($key, $value)
    {
        $this->shared[$key] = $value;
    }
}
