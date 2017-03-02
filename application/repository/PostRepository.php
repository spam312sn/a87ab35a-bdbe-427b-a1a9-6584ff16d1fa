<?php

namespace application\repository;

use application\core\Repository;
use application\core\Route;

class PostRepository extends Repository
{
    /**
     * @param int $page
     * @return array
     */
    public function getAll($page = 1)
    {
        $limit = 25;
        $start = $page === 1 ? 0 : $page * $limit;
        $result = array();
        $timeRepository = new TimeRepository();

        $allPosts = $this->connect()->query('SELECT * FROM `posts` WHERE `deleted` = FALSE ORDER BY `created_at` DESC LIMIT ' . $start . ',' . $limit . ';');

        if (!$allPosts) {
            $route = new Route();
            $route->error(404);
        }

        while ($post = mysqli_fetch_assoc($allPosts)) {
            $result[] = array(
                'id' => $post['id'],
                'user' => $post['user_id'],
                'post' => $post['post'],
                'created' => $timeRepository->timing(strtotime($post['created_at'])) . ' ago'
            );
        }

        return $result;
    }

    /**
     * @param array $data
     */
    public function create($data = array())
    {
        if (!empty($_SESSION['token'])) {
            $userRepository = new UserRepository();
            $user = $userRepository->getOneByToken($_SESSION['token']);
            $post = htmlspecialchars($data['post']);
            $this->connect()->query('INSERT INTO `posts` (user_id, post, created_at) VALUES (\'' . $user . '\',\'' . $post . '\', NOW());');
        }
    }

    /**
     * @param int $id
     */
    public function delete($id = 0)
    {
        if (!empty($_SESSION['token'])) {
            $userRepository = new UserRepository();
            $user = $userRepository->getOneByToken($_SESSION['token']);
            if ($id > 0 && $this->isExist($id)) {
                $post = $this->getOne($id);
                if ($post['0']['user'] === $user) {
                    $this->connect()->query('UPDATE `posts` SET `deleted` = TRUE, `deleted_at` = NOW() WHERE `id` = \'' . $id . '\';');
                }
            }
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isExist($id = 0)
    {
        $result = false;
        if ($id > 0) {
            $check = $this->connect()->query('SELECT COUNT(`id`) AS total FROM `posts` WHERE `id` = ' . $id . ';')->fetch_assoc();
            $result = (intval($check['total']) === 1);
        }

        return $result;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getOne($id = 0)
    {
        $timeRepository = new TimeRepository();
        $result = array();

        $post = $this->connect()->query('SELECT * FROM `posts` WHERE `id` = \'' . $id . '\';')->fetch_assoc();
        if (!$this->isExist($id)) {
            $route = new Route();
            $route->error(404);
        }
        $result[] = array(
            'id' => $post['id'],
            'user' => $post['user_id'],
            'post' => $post['post'],
            'created' => $timeRepository->timing(strtotime($post['created_at'])) . ' ago'
        );

        return $result;
    }
}
