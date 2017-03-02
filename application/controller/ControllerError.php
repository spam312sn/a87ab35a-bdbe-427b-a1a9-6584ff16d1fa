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
        $this->jsonResponse(array('error' => true, 'code' => $code));
    }
}
