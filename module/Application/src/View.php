<?php
namespace Application;


class View 
{
    /** @var array */
    protected $vars = array();

    /** @var  string */
    protected $template;

    /** @var  string */
    protected $viewPath;

    public function __construct($vars = array())
    {
        $this->setVars($vars);
    }

    public function __get($name)
    {
        return array_key_exists($name, $this->vars) ? $this->vars[$name] : null;
    }

    public function __set($name, $value)
    {
        $this->vars[$name] = $value;
        return $this;
    }

    /**
     * @param array $vars
     */
    public function setVars($vars)
    {
        $this->vars = $vars;
        return $this;
    }

    /**
     * @return array
     */
    public function getVars()
    {
        return $this->vars;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    public function render()
    {
        $template = $this->getTemplate() . '.phtml';
        include rtrim($this->getViewPath(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $template;
    }

    /**
     * @param string $viewPath
     */
    public function setViewPath($viewPath)
    {
        $this->viewPath = $viewPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getViewPath()
    {
        return $this->viewPath;
    }
}