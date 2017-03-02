<?php

namespace application\controller;

use application\core\Controller;
use application\repository\PostRepository;

/**
 * Class ControllerPosts
 * @package application\controller
 */
class ControllerPosts extends Controller
{
    function getAction($id = 0)
    {
        $postsRepository = new PostRepository();
        $result = $id > 0 ? $postsRepository->getOne($id) : $postsRepository->getAll();
        die(json_encode($result));
    }

    function createAction()
    {
        try {
            if (empty($_POST)) throw new \Exception('Empty data');
            $requiredFields = ['post', 'user_id'];
            foreach ($requiredFields as $requiredField) {
                if (empty($_POST[$requiredField])) throw new \Exception('Missed field "' . $requiredField . '"');
            }
        } catch (\Exception $e) {
            die(json_encode(array(
                'error' => true,
                'message' => $e->getMessage(),
                'code' => 400
            )));
        }

        $postRepository = new PostRepository();
        $postRepository->create($_POST);
    }
}