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
    /**
     * @param int $id
     */
    function getAction($id = 0)
    {
        $postsRepository = new PostRepository();
        $result = $id > 0 ? $postsRepository->getOne($id) : $postsRepository->getAll();
        $this->jsonResponse($result);
    }

    function createAction()
    {
        try {
            if (empty($_POST)) throw new \Exception('Empty data');
            $requiredFields = ['post'];
            foreach ($requiredFields as $requiredField) {
                if (empty($_POST[$requiredField])) throw new \Exception('Missed field "' . $requiredField . '"');
            }
        } catch (\Exception $e) {
            $this->jsonResponse(array(
                'error' => true,
                'message' => $e->getMessage(),
                'code' => 400
            ));
        }

        $postRepository = new PostRepository();
        $postRepository->create($_POST);
    }

    /**
     * @param int $id
     */
    function deleteAction($id = 0)
    {
        if ($id > 0) {
            $postRepository = new PostRepository();
            $postRepository->delete($id);
        }
    }
}
