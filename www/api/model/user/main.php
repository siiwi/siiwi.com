<?php

class ModelUserMain extends \Siiwi\Api\Model
{
    protected $db_table_name = DB_PREFIX . 'user';

    /**
     * @return string
     * 生成用户密码混淆码
     */
    public function getUserSalt()
    {
        return $this->db->escape(substr(md5(uniqid(rand(), true)), 0, 6));
    }

    /**
     * @param $password
     * @param $salt
     * @return string
     * 生成用户密码密文
     */
    public function getUserPassword($password, $salt)
    {
        return md5($password.$salt);
    }

    /**
     * @return string
     * 生成用户key
     */
    public function getUserKey()
    {
        return time().substr(microtime(), 2, 3);
    }

    /**
     * @return string
     * 生成用户私钥
     */
    public function getUserSecret()
    {
        return substr(md5(md5(time().rand())),0,20).rand(1000000,10000000);
    }
}