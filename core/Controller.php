<?php

namespace Core;

abstract class Controller
{
    protected $layout = 'app';
    protected static $sections = [];
    protected static $currentSection;
    protected $middlewares = [];

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function middleware($middleware)
    {
        $this->middlewares[] = [
            'middleware' => $middleware,
            'options' => []
        ];
        return $this;
    }

    public function only(array $methods)
    {
        if (!empty($this->middlewares)) {
            $this->middlewares[count($this->middlewares) - 1]['options']['only'] = $methods;
        }
        return $this;
    }

    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    protected function view($view, $data = [], $layout = null)
    {
        ob_start();

        extract($data);

        $finalLayout = $layout ?? $this->layout;

        // Turn relative paths into absolute paths
        $viewPath = realpath(__DIR__ . "/../app/views/{$view}.view.php");
        $layoutPath = realpath(__DIR__ . "/../app/views/layouts/{$finalLayout}.php");

        if (!file_exists($viewPath)) {
            echo "View not found: {$viewPath}";
            return ob_get_clean();
        }

        // Require the view. Its contents will be captured by the start/end section methods.
        require $viewPath;

        // If a layout is specified and exists, render it.
        if ($finalLayout && file_exists($layoutPath)) {
            require $layoutPath;
        } else if ($finalLayout) {
            echo "Layout not found: {$layoutPath}";
        } else {
            // If no layout, just echo the content section.
            echo self::$sections['content'] ?? '';
        }

        return ob_get_clean();
    }

    public static function start($section)
    {
        self::$currentSection = $section;
        ob_start();
    }

    public static function end()
    {
        self::$sections[self::$currentSection] = ob_get_clean();
        self::$currentSection = null;
    }

    public static function yield($section)
    {
        echo self::$sections[$section] ?? '';
    }
}
