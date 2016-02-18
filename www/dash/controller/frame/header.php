<?php

class ControllerFrameHeader extends \Siiwi\Dashboard\BaseController
{
    public function index($title)
    {
        $this->data['frame_header_index']['title'] = $title;
        $this->data['frame_header_index']['language'] = $this->request->cookie['language'];

        return $this->load->view('frame/header.html', $this->data);
    }
}