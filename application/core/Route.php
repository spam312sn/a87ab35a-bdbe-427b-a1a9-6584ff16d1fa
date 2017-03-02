<?php

namespace application\core;

/**
 * Class Route
 * @package application\core
 */
class Route
{
    static function start()
    {
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        $controllerName = !empty($routes[1]) ? $routes[1] : 'Posts';
        $id = !empty($routes[3]) ? $routes[3] : 0;
        if (!empty($routes[2])) {
            if (intval($routes[2]) > 0) {
                $actionType = 'get';
                $id = $routes[2];
            } else {
                $actionType = $routes[2];
            }
        } else {
            $actionType = 'get';
        }

        $controllerName = 'Controller' . ucfirst($controllerName);

        switch ($actionType) {
            case "get":
                if ($_SERVER['REQUEST_METHOD'] !== 'GET') self::error(403);
                break;
            case "create":
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') self::error(403);
                break;
            case "delete":
                if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') self::error(403);
                break;
        }

        $actionType = $actionType . 'Action';

        $controllerClass = 'application\\controller\\' . $controllerName;

        try {
            if (!class_exists($controllerClass)) throw new \Exception('Not found', 404);
            $controller = new $controllerClass;

            if (!method_exists($controller, $actionType)) throw new \Exception('Not found', 404);

            $controllerCore = new Controller();
            if ($id === 0) {
                if ($controllerCore->isParameterExist('code', $controllerClass, $actionType)) throw new \Exception('Not found', 404);
                $controller->$actionType();
            } else {
                $controller->$actionType($id);
            }
        } catch (\Exception $e) {
            self::error($e->getCode());
        }
    }

    public function error($code)
    {
        header('location: /error/get/' . $code);
    }
}
