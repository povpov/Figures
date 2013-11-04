<?php
namespace Application;

abstract class AbstractController
{
    /** @var  View */
    protected $view;

    /** @var string */
    protected $action;

    protected function params()
    {
        $params = array_merge($_GET, $_POST);

        return $params;
    }

    protected function getCookies()
    {
        return $_COOKIE;
    }

    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    protected function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    protected function getCookie($name, $default = null)
    {
        $cookie = isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
        if ($cookie === null && $default !== null) {
            $this->addCookie($name, $default);
            $cookie = $default;
        }
        return $cookie;
    }

    protected function addCookie($name, $value)
    {
        setcookie($name, $value);
    }

    public function run()
    {
        $params = $this->params();
        $this->action = isset($params['action']) ? $params['action'] :'index';

        $method = $this->action. 'Action';
        $this->view = $this->$method();
        $this->renderView();
    }

    protected function renderView()
    {
        if (!$this->view) {
            $this->view = new View();
        }
        if (!$this->view->getTemplate()) {
            $this->view->setTemplate($this->action);
        }
        $this->view->setViewPath(realpath(__DIR__ . '/../view'));
        $this->view->render();
    }
}