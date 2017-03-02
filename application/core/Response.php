<?php

namespace application\core;

class Response
{
    /**
     * @param mixed $data
     */
    public function jsonResponse($data)
    {
        die(json_encode($data));
    }
}
