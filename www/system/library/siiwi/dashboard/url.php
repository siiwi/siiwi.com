<?php

namespace Siiwi\Dashboard;

class Url extends \Url
{
    public function redirect($route, $status = 302)
    {
        $url = $this->link($route);
        header("Location: $url" , true, $status);
        exit();
    }
}