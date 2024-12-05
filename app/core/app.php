<?php

class App
{

    protected $controllerName = 'home';
    protected $methodName = "index";

    protected $argument = null;

    public function __construct()
    {
        $this->parseUrl();
    }

    protected function parseUrl()
    {
        // Parse URL
        $uri = $_SERVER['REQUEST_URI'];
        $request = parse_url($uri, PHP_URL_PATH);
        $request = str_replace("/~kupriars", "", $request);
        $params = array_filter(explode('/', trim($request, '/')));

        $controllerName = $params[0] ?? 'home';
        unset($params[0]);
        $methodName = $params[1] ?? 'index';
        unset($params[1]);
        $argument = $params[2] ?? null;


        // Call the controller method
        $controllerPath = './app/controllers/' . $controllerName . '.php';
        if (file_exists($controllerPath)) {
            require $controllerPath;
            $controller = new $controllerName();
                if (method_exists($controller, $methodName)) {
                    call_user_func_array([$controller, $methodName], $params);
                } else {
                    echo "Method $methodName not found!";
                }
            } else {
                echo "Controller $controllerName not found!";
        }
    }
}
