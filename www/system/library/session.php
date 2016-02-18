<?php

class Session
{
    public function __construct()
    {
        if(!$this->getId()){
            session_start();
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key='')
    {
        return $key ? $_SESSION[$key] : $_SESSION;
    }

    public function destroy()
    {
        session_destroy();
    }

    public function getId()
    {
        return session_id();
    }
}