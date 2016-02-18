<?php

class ControllerTestTest extends \Siiwi\Api\Controller
{
    public function index()
    {
        $this->load->model('global/token');
        $this->load->model('user/main');


        $this->verifyToken();

        var_dump($this->isPost(true));

        var_dump($this->verifySuperUser());
    }
}