<?php

class ControllerFrameNavigation extends \Siiwi\Dashboard\BaseController
{
    public function index()
    {
        // logo
        $this->data['frame_navigation_index']['logo'] = $this->config->get('config_app_logo');

        // language
        $this->data['frame_navigation_index']['language_list']      = $this->config->get('language_list');
        $this->data['frame_navigation_index']['active_language']    =  $this->data['frame_navigation_index']['language_list'][$this->request->cookie['language']];

        // user
        $this->data['frame_navigation_index']['user_info'] = $this->session->get('user_info');

        // 返回视图
        return $this->load->view('frame/navigation.html', $this->data);
    }
}