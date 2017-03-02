<?php

namespace application\controller;

use application\core\Controller;

/**
 * Class ControllerError
 * @package application\controller
 */
class ControllerError extends Controller
{
    /**
     * @param int $code
     */
    function getAction($code)
    {
        $answer = json_encode(array('error' => true, 'code' => $code));
        die($answer);
    }
}
