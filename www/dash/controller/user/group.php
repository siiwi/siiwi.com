<?php
/**
 * 用户组管理
 */
class ControllerUserGroup extends \Siiwi\Dashboard\Controller
{
    public function index()
    {
        // 加载页面框架
        $this->data['frame']['header']      = $this->load->controller('frame/header', $this->language->get('user_group_index')->title);
        $this->data['frame']['navigation']  = $this->load->controller('frame/navigation');
        $this->data['frame']['sidebar']     = $this->load->controller('frame/sidebar');
        $this->data['frame']['footer']      = $this->load->controller('frame/footer');
        $this->data['frame']['content']     = $this->content();

        $this->response->setOutput($this->load->view('frame/main.html', $this->data));
    }

    private function content()
    {
        $this->api->get('group/get');

        if($this->api->getResponseStatus()) {
            $group_list = $this->api->getResponseData();
            $this->data['user_group_content']['group_list'] = $group_list['group_list'];
        }

        return $this->load->view('user/group/content.html', $this->data);
    }

    /**
     * 添加用户组
     * @method AJAX
     */
    public function add()
    {
        if($this->request->isAjax()) {
            if($this->request->isGet()) {
                $this->response->setOutput($this->load->view('user/group/add.html', $this->data));
            }

            if($this->request->isPost()) {
                $name = $this->request->getHttpPost('name');
                $desc = $this->request->getHttpPost('desc', '');
                $this->api->post('group/add', array('name'=>$name, 'desc'=>$desc));
                $response['status']  = $this->api->getResponseStatus();
                $response['message'] = $this->language->get('user_group_add')->response[$this->api->getResponseMessage()];
                $this->response->outputJson($response);
            }
        }
    }

    /**
     * 删除用户组
     * @method POST|AJAX
     */
    public function delete()
    {
        if($this->request->isPost() && $this->request->isAjax()) {
            $group_id = $this->request->getHttpPost('group_id');
            $this->api->delete('group/delete', array('group_id'=>$group_id));
            $response['status']  = $this->api->getResponseStatus();
            $response['message'] = $this->language->get('user_group_delete')->response[$this->api->getResponseMessage()];
            $this->response->outputJson($response);
        }
    }
}
