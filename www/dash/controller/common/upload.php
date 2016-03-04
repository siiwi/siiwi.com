<?php

class ControllerCommonUpload extends \Siiwi\Dashboard\BaseController
{
    public function index()
    {
        $this->load->library('upload');

        $handle = new Upload($_FILES['upload']);
        $filename = time() . rand(0, 999);
        $handle->file_new_name_body = md5($filename);
        if ($handle->uploaded) {
            $dir = date('/Y/m/d/');
            $path = DIR_UPLOAD . 'images' . $dir;
            $handle->process($path);
            if ($handle->processed) {
                $handle->clean();
                $response['status']  = true;
                $response['data']    = array('path'=>'/upload/images' . $dir . $handle->file_dst_name, 'name'=>$handle->file_src_name);
                $response['message'] = 'success';
            } else {
                $response['status']  = false;
                $response['data']    = '';
                $response['message'] = $handle->error;
            }
        }

        $this->response->outputJson($response);
    }
}
