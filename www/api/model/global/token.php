<?php

class ModelGlobalToken extends \Siiwi\Api\Model
{
    protected $db_table_name = DB_PREFIX . "global_token";

    public function createToken($token_info)
    {
        return sha1($token_info['client_id'] . $token_info['user_id'] . $token_info['expires']);
    }
}