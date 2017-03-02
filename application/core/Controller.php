<?php

namespace application\core;

use ReflectionMethod;

/**
 * Class Controller
 * @package application\core
 */
class Controller extends Response
{
    /**
     * @param string $needle
     * @param string $class
     * @param string $method
     * @return bool
     */
    public function isParameterExist($needle, $class, $method)
    {
        $result = false;
        $reflectionMethod = new ReflectionMethod($class, $method);
        foreach ($reflectionMethod->getParameters() as $parameter) {
            if (strcmp($parameter->name, $needle) === 0) $result = true;
        }

        return $result;
    }
}
