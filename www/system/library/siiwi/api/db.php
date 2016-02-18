<?php

namespace Siiwi\Api;

class DB extends \DB
{
    public function delete($table, $whereArr)
    {
        if(!is_array($whereArr) || empty($whereArr)) {
            return false;
        }

        $whereSql = $this->getWhereSql($whereArr);

        $sql = "DELETE FROM $table WHERE " . $whereSql;

        return $this->db->query($sql) ? true : false;
    }

    public function fetchRow($table, $whereArr)
    {
        $whereSql = $this->getWhereSql($whereArr);

        $sql = "SELECT * FROM $table WHERE " . $whereSql;

        $query = $this->db->query($sql);

        if (!$query->num_rows) {
            return false;
        }

        return $query->row;
    }

    public function fetchAll($table, $whereArr=array(), $limitArr=array())
    {
        $whereSql = $this->getWhereSql($whereArr);
        $limitSql = $this->getLimitSql($limitArr);

        $sql = "SELECT * FROM $table WHERE " . $whereSql;

        if($limitSql) {
            $sql .= ' LIMIT ' . $limitSql;
        }

        $query = $this->db->query($sql);

        if (!$query->num_rows) {
            return false;
        }

        return $query->rows;
    }

    public function count($table, $whereArr=array())
    {
        $whereSql = $this->getWhereSql($whereArr);

        $sql = "SELECT count(*) as num FROM $table WHERE " . $whereSql;

        $query = $this->db->query($sql);

        return $query->row['num'];
    }

    public function insert($table, $setArr, $replace = false)
    {
        $batch = false;
        $a = $b = $c = array();
        $d = $e = $f = '';

        foreach($setArr as $key=>$value) {
            if(is_array($value) && !empty($value)) {
                $batch = true;
                $b = array();

                foreach($value as $k=>$v) {
                    $a[] = '`' . $k . '`';
                    $b[] = "'" . $v . "'";
                }

                if(!$d) {
                    $d = '(' . join(',', $a) . ')';
                }

                $e[] = '(' . join(',', $b) . ')';
            } else {
                $c[] = '`' . $key . '`';
                $e[] = "'" . $value . "'";
            }
        }

        if(is_array($c) && !empty($c)) {
            $d = '(' . join(',', $c) . ')';
        }

        if($batch) {
            $f = join(',', $e);
        } else {
            $f = "(" . join(',', $e) . ")";
        }

        $sql = 'INSERT INTO `' . $table . '` ' . $d .' VALUES ' . $f;

        return $this->db->query($sql);
    }

    public function update($table, $setArr, $whereArr, $limit = -1)
    {
        if(!is_array($setArr) || empty($setArr)) {
            return false;
        }

        foreach($setArr as $key=>$value) {
            $temp[] = "`$key`='{$value}'";
        }

        $setSql = join($temp, ',');

        $whereSql = $this->getWhereSql($whereArr);

        $sql = 'UPDATE `'.$table.'`' . ' SET ' . $setSql . ' WHERE ' . $whereSql . ($limit > 0 ? (' LIMIT ' . $limit) : '');

        return $this->db->query($sql);
    }

    public function getWhereSql($whereArr)
    {
        $where = $comma = '';

        if (empty($whereArr)) {

            $where = '1';

        } elseif (is_array($whereArr)) {

            foreach ($whereArr as $field => $value) {

                $operator = '=';
                if (is_array($value)) {
                    $operator = $value[0];
                    $value    = $value[1];
                }

                $value = !is_array($value) ? $this->escape($value) : $value;

                // 原生SQL条件
                if ($operator == 'SQL') {

                    $where .= $comma . '`' . $field . '` ' . $value;

                } else {

                    $where .= $comma . '`' . $field . '` ' . $operator;

                    switch ($operator) {
                        case 'IN':
                        case 'NOT IN':
                            $where .= ' (' . (is_array($value) ? $this->ximplode($value) : $value) . ')';
                            break;
                        default:
                            $where .= ' \'' . $value . '\'';
                    }
                }

                $comma = ' AND ';
            }

        } else {

            $where = $whereArr;
        }

        return $where;
    }

    public function getLimitSql($limitArr)
    {
        $limit = '';

        if(is_array($limitArr) && !empty($limitArr)) {
            if(isset($limitArr['rows']) && isset($limitArr['offset'])) {
                $limit = $limitArr['offset'] . ', ' . $limitArr['rows'];
            }

            if(isset($limitArr['rows']) && !isset($limitArr['offset'])) {
                $limit = $limitArr['offset'];
            }
        }

        return $limit;
    }

    public function ximplode($array)
    {
        return empty($array) ? 0 : "'" . implode("','", is_array($array) ? $array : array($array)) . "'";
    }
}
