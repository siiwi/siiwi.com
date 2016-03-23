<?php

class ModelProductMain extends \Siiwi\Api\Model
{
    protected $db_table_name = DB_PREFIX . "product";

    public function getProductList($where_array, $limit_array)
    {
        $sql = "SELECT a.*, b.sku, b.user_sku, b.purchase_price, b.stock FROM {$this->db_table_name} AS a LEFT JOIN si_product_sku AS b ON a.product_id = b.product_id WHERE b.status = 1";
        if(is_array($where_array) && !empty($where_array)) {
            foreach($where_array as $key=>$value) {
                $sql .= " AND a.{$key} = {$value}";
            }
        }
        $sql .= " ORDER BY b.sku DESC LIMIT {$limit_array['offset']}, {$limit_array['rows']}";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getProductListCount($where_array)
    {
        $sql = "SELECT count(b.sku) as num FROM {$this->db_table_name} AS a LEFT JOIN si_product_sku AS b ON a.product_id = b.product_id WHERE b.status = 1";
        if(is_array($where_array) && !empty($where_array)) {
            foreach($where_array as $key=>$value) {
                $sql .= " AND a.{$key} = {$value}";
            }
        }
        $query = $this->db->query($sql);
        return $query->row['num'];
    }
}
