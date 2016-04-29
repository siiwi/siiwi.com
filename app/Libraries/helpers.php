<?php

if (! function_exists('create_product_sn')) {
    /**
     * 生成产品编号
     *
     * @param int $pid
     * @return string
     */
    function create_product_sn($pid)
    {
        return Auth::id() . date('Ymd') . $pid;
    }
}

if (! function_exists('create_product_sku')) {
    /**
     * 生成SKU编号
     *
     * @param int $pid
     * @param int $id
     * @return string
     */
    function create_product_sku($pid, $id)
    {
        return "SKU-{$pid}-{$id}";
    }
}