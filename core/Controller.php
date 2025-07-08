<?php

namespace Core;

abstract class Controller
{
    protected $layout = 'app';
    protected static $sections = [];
    protected static $currentSection;
    protected $middlewares = [];


    /**
     * Set the layout to be used for views rendered by this controller.
     *
     * @param string $layout
     * @return void
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }


    /**
     * Register a middleware for this controller.
     *
     * @param string $middleware
     * @return $this
     */
    public function middleware($middleware)
    {
        $this->middlewares[] = [
            'middleware' => $middleware,
            'options' => []
        ];
        return $this;
    }


    /**
     * Restrict the last registered middleware to specific controller methods.
     *
     * @param array $methods
     * @return $this
     */
    public function only(array $methods)
    {
        if (!empty($this->middlewares)) {
            $this->middlewares[count($this->middlewares) - 1]['options']['only'] = $methods;
        }
        return $this;
    }


    /**
     * Get all registered middlewares for this controller.
     *
     * @return array
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }


    /**
     * Render a view with optional data and layout.
     *
     * @param string $view
     * @param array $data
     * @param string|null $layout
     * @return string
     */
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


    /**
     * Start capturing output for a named section.
     *
     * @param string $section
     * @return void
     */
    public static function start($section)
    {
        self::$currentSection = $section;
        ob_start();
    }


    /**
     * End the current section and save its output.
     *
     * @return void
     */
    public static function end()
    {
        self::$sections[self::$currentSection] = ob_get_clean();
        self::$currentSection = null;
    }


    /**
     * Output the contents of a named section.
     *
     * @param string $section
     * @return void
     */
    public static function yield($section)
    {
        echo self::$sections[$section] ?? '';
    }
}
