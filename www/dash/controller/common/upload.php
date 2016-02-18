<?php

class ControllerCommonUpload extends \Siiwi\Dashboard\BaseController
{
    public function index()
    {

        $this->load->library('upload');

        $handle = new Upload($_FILES['test_file_upload']);
        if ($handle->uploaded) {
            $dir = date('/Y/m/d/');
            $path = DIR_UPLOAD . 'images' . $dir;
            $handle->process($path);
            if ($handle->processed) {
                $handle->clean();
                $response['status']  = true;
                $response['data']    = array('uri'=>'/upload/images' . $dir . $handle->file_dst_name);
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
