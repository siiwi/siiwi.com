<?php

namespace Siiwi\Dashboard;

class Response extends \Response
{
    public function outputJson($message)
    {
        exit(json_encode($message));
    }
}
