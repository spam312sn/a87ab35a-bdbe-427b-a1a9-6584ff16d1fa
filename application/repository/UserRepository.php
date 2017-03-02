<?php

namespace application\repository;

use application\core\Repository;
use application\core\Route;

/**
 * Class UserRepository
 * @package application\repository
 */
class UserRepository extends Repository
{
    /**
     * @return array
     */
    public function getAll()
    {
        $result = array();

        $allUsers = $this->connect()->query('SELECT * FROM `users`;');

        $route = new Route();
        if (!$allUsers) $route->error(404);

        while ($user = mysqli_fetch_assoc($allUsers)) {
            $result[] = array(
                'id' => $user['id'],
                'username' => $user['username'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name']
            );
        }

        return $result;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getOne($id = 0)
    {
        $result = array();

        $user = $this->connect()->query('SELECT * FROM `users` WHERE `id` = \'' . $id . '\';')->fetch_assoc();

        $route = new Route();
        if (!$this->isExist($id)) $route->error(404);

        $result[] = array(
            'id' => $user['id'],
            'username' => $user['username'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name']
        );

        return $result;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isExist($id = 0)
    {
        $result = false;
        if ($id > 0) {
            $check = $this->connect()->query('SELECT COUNT(`id`) AS total FROM `users` WHERE `id` = ' . $id . ';')->fetch_assoc();
            $result = (intval($check['total']) === 1);
        }

        return $result;
    }

    /**
     * @param string $username
     * @return int
     */
    public function getOneByUsername($username = '')
    {
        $result = 0;
        $query = $this->connect()->query('SELECT `id` FROM users WHERE `username` = ' . $username . ';');
        if ($query) {
            $user = $query->fetch_assoc();
            $result = intval($user['id']);
        }

        return $result;
    }

    /**
     * @param string $token
     * @return int
     */
    public function getOneByToken($token = '')
    {
        $result = 0;
        $query = $this->connect()->query('SELECT `id` FROM users WHERE `token` = ' . $token . ';');
        if ($query) {
            $user = $query->fetch_assoc();
            $result = intval($user['id']);
        }

        return $result;
    }
}
