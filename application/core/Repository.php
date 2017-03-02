<?php

namespace application\core;

/**
 * Class Repository
 * @package application\core
 */
class Repository
{
    /** @var string $hostname */
    private $hostname = 'localhost';

    /** @var string $database */
    private $database = 'a87ab35a-bdbe-427b-a1a9-6584ff16d1fa';

    /** @var string $username */
    private $username = 'root';

    /** @var string $password */
    private $password = 'root';

    /**
     * @return \mysqli
     */
    public function connect()
    {
        return new \mysqli(
            $this->hostname,
            $this->username,
            $this->password,
            $this->database
        );
    }
}