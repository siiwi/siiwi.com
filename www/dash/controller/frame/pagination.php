<?php

class ControllerFramePagination extends \Siiwi\Dashboard\BaseController
{
    public function index($params)
    {
        $page       = $this->request->getHttpGet('page', 1);
        $page_size  = $this->request->getHttpGet('page_size', $this->config->get('config_page_size'));

        $page_total = ceil( $params['total'] / $page_size );                                     // 总页数

        if($page_total > 1) {
            $this->data['link']            = $params['link'];
            $this->data['page']['last']    = $page_total;                                         // 最后一页
            $this->data['page']['first']   = 1;                                                   // 第一页
            $this->data['page']['current'] = $page;                                               // 当前页
            $this->data['page']['min']     = (($page-3)>1) ? ($page-3) : 1;                       // 前三页
            $this->data['page']['max']     = (($page+3)<$page_total) ? ($page+3) : $page_total;   // 后三页

            return $this->load->view('frame/pagination.html', $this->data);
        }
    }
}
