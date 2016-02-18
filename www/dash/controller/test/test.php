<?php

class ControllerTestTest extends \Siiwi\Dashboard\Controller
{
    public function index()
    {
        $this->response->setOutput($this->load->view('test/test.html'));
    }
}
