<?php

namespace Core;

class View
{
    protected $basePath;
    protected $layout = null;
    protected $sections = [];
    protected $currentSection = null;


    /**
     * View constructor.
     *
     * @param string|null $basePath
     */
    public function __construct($basePath = null)
    {
        $this->basePath = $basePath ?: dirname(__DIR__) . DIRECTORY_SEPARATOR;
    }


    /**
     * Set the layout to be used for rendering.
     *
     * @param string $layout
     * @return void
     */
    public function layout($layout)
    {
        $this->layout = $layout;
    }


    /**
     * Start capturing output for a named section.
     *
     * @param string $section
     * @return void
     */
    public function start($section)
    {
        $this->currentSection = $section;
        ob_start();
    }


    /**
     * End the current section and save its output.
     *
     * @param string|null $section
     * @return void
     * @throws \Exception
     */
    public function end($section = null)
    {
        if ($this->currentSection === null) {
            throw new \Exception('Cannot end a section without starting one.');
        }
        $this->sections[$this->currentSection] = ob_get_clean();
        $this->currentSection = null;
    }


    /**
     * Render a view file with optional data.
     *
     * @param string $name
     * @param array $data
     * @return string
     */
    public function render($name, $data = [])
    {
        return $this->make($name, $data);
    }


    /**
     * Make (render) a view file, optionally with a layout and sections.
     *
     * @param string $name
     * @param array $data
     * @return string
     * @throws \Exception
     */
    public function make($name, $data = [])
    {
        extract($data);

        $viewPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $name);
        $fullPath = $this->basePath . "app" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . $viewPath . ".view.php";

        // First, process the view file. This will set the layout and populate the sections.
        ob_start();
        require $fullPath;
        $content = ob_get_clean(); // This captures any content not in a section.

        // If a layout is defined, render it.
        if ($this->layout) {
            // If there's content outside of sections, but no main 'content' section, use it.
            if (!isset($this->sections['content']) && !empty($content)) {
                $this->sections['content'] = $content;
            }
            return $this->renderLayout();
        }

        // If no layout, just return the content.
        return $content;
    }


    /**
     * Render the current layout with all defined sections.
     *
     * @return string
     * @throws \Exception
     */
    protected function renderLayout()
    {
        ob_start();
        $layoutPath = $this->basePath . "app" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "layouts" . DIRECTORY_SEPARATOR . $this->layout . ".php";
        require $layoutPath;
        return ob_get_clean();
    }


    /**
     * Get the contents of a named section.
     *
     * @param string $section
     * @return string
     */
    public function yield($section)
    {
        return $this->sections[$section] ?? '';
    }
}
