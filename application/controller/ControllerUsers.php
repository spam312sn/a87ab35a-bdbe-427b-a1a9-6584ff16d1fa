<?php

namespace application\controller;

use application\core\Controller;
use application\core\Route;
use application\repository\UserRepository;

/**
 * Class ControllerUsers
 * @package application\controller
 */
class ControllerUsers extends Controller
{
    function getAction($id = 0)
    {
        $userRepository = new UserRepository();
        $result = $id > 0 ? $userRepository->getOne($id) : $userRepository->getAll();
        die(json_encode($result));
    }
}
