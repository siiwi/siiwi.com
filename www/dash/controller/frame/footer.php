<?php

class ControllerFrameFooter extends \Siiwi\Dashboard\BaseController
{
    public function index()
    {
        return $this->load->view('frame/footer.html');
    }
}