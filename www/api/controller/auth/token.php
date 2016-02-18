<?php

/**
 * Class ControllerAuthToken
 * 用户获取access_token即授权API接口
 *
 * @method GET
 *
 * @param $user_key
 */
class ControllerAuthToken extends \Siiwi\Api\Controller
{
    private $token_info = array();

    public function index()
    {
        $this->isGet();

        $this->load->model('global/token');
        $this->load->model('user/credentials');

        $this->validate();

        $this->prepareTokenData();

        if(!$this->model_global_token->add($this->token_info)) {
            $this->response->jsonOutputExit('system_error');
        }

        $this->response->jsonOutput('success', $this->setResponseData());
    }

    private function validate()
    {
        // user key
        $user_key = (!$this->request->getHttpGet('user_key')) ? $this->response->jsonOutputExit('empty_user_key') : $this->request->getHttpGet('user_key');

        // 用户证书信息
        $user_credentials_info = $this->model_user_credentials->fetchOne(array('user_key'=>$user_key, 'client_id'=>$this->config->get('client_id'), 'status'=>1));
        if(!is_array($user_credentials_info) || empty($user_credentials_info)) {
            $this->response->jsonOutputExit('invalid_user_key');
        }

        $this->token_info['user_id'] = $user_credentials_info['user_id'];
    }

    private function prepareTokenData()
    {
        $this->token_info['client_id'] = $this->config->get('client_id');
        $this->token_info['expires'] = time() + $this->config->get('config_token_deadline');
        $this->token_info['access_token'] = $this->model_global_token->createToken($this->token_info);
    }

    private function setResponseData()
    {
        return array(
            'token_info' => array(
                'access_token' => $this->token_info['access_token'],
                'expires' => $this->token_info['expires'] - 300
            )
        );
    }
}