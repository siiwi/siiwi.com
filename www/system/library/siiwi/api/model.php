<?php

namespace Siiwi\Api;

class Model extends \Model
{
    public function add($info)
    {
        return $this->db->insert($this->db_table_name, $info);
    }

    public function fetchOne($where)
    {
        return $this->db->fetchRow($this->db_table_name, $where);
    }

    public function fetchAll($where, $limit=array())
    {
        return $this->db->fetchAll($this->db_table_name, $where, $limit);
    }

    public function getLastId()
    {
        return $this->db->getLastId();
    }

    public function delete($info)
    {
        return $this->db->delete($this->db_table_name, $info);
    }

    public function update($update, $where)
    {
        return $this->db->update($this->db_table_name, $update, $where);
    }

    public function count($where)
    {
        return $this->db->count($this->db_table_name, $where);
    }
}
