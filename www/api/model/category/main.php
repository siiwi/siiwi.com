<?php

class ModelCategoryMain extends \Siiwi\Api\Model
{
    protected $db_table_name = DB_PREFIX . "category";

    public function fetchAll($where, $limit)
    {
        $whereSql = 1;
        $limitSql = $this->db->getLimitSql($limit);

        if(is_array($where) && !empty($where)) {
            foreach($where as $key=>$value) {
                if($key != 'language_id') {
                    $whereSql .= " AND `{$key}` = '{$value}'";
                }
            }

            if(!isset($where['type']) && !isset($where['category_id'])) {
                $whereSql .= ' OR `type` = 1';
            }
        }

        $sql = "SELECT * FROM $this->db_table_name WHERE " . $whereSql;

        $sql .= ' ORDER BY `category_id` DESC ';

        if($limitSql) {
            $sql .= ' LIMIT ' . $limitSql;
        }

        $query = $this->db->query($sql);

        return (!$query->num_rows) ? false : $query->rows;
    }

    public function count($where)
    {
        $whereSql = 1;

        if(is_array($where) && !empty($where)) {
            foreach($where as $key=>$value) {
                if($key != 'language_id') {
                    $whereSql .= " AND `{$key}` = '{$value}'";
                }
            }

            if(!isset($where['type']) && !isset($where['category_id'])) {
                $whereSql .= ' OR `type` = 1';
            }
        }

        $sql = "SELECT count(*) as num FROM $this->db_table_name WHERE " . $whereSql;

        $query = $this->db->query($sql);

        return $query->row['num'];
    }
}