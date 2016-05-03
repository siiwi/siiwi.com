<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => ':attribute 不能为空！',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute 已经存在',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'email' => [
            'required' => '请输入电子邮箱',
            'email' => '电子邮箱格式错误',
            'unique' => '电子邮箱已注册',
        ],
        'password' => [
            'required' => '请输入密码',
            'confirmed' => '两次密码输入不一致',
            'min' => '密码长度最低6位'
        ],
        'name' => [
            'required' => '请输入用户名',
            'unique' => '用户名已经存在',
        ],
        'agree' => [
            'required' => '未同意服务条款，无法注册'
        ],
        'contact' => [
            'required' => '请输入联系人'
        ],
        'phone' => [
            'required' => '请输入电话号码'
        ],
        'category_name' => [
            'required' => '请输入分类名称',
            'unique' => '分类名称已经存在',
        ],
        'supplier_name' => [
            'required' => '请输入供应商名称',
            'unique' => '供应商名称已经存在',
        ],
        'attribute_name' => [
            'required' => '请输入规格名称',
            'unique' => '该分类下规格名称已经存在',
        ],
        'product_name' => [
            'required' => '添加产品失败！请输入产品名称'
        ],
        'cid' => [
            'required' => '请选择产品分类',
            'exists' => '添加产品失败！当前登录用户无操作已选择产品分类权限'
        ],
        'sid' => [
            'required' => '请选择供应商',
            'exists' => '添加产品失败！当前登录用户无操作已选择供应商权限'
        ],
        'sku' => [
            'required' => '添加产品失败！请设置产品规格'
        ],
        'resource' => [
            'required' => '添加产品失败！请设置产品图片'
        ],
        'sn' => [
            'unique' => '添加产品失败！产品编号已经存在'
        ],
        'order_sn' => [
            'required' => '添加订单失败！请输入订单号',
            'unique' => '添加订单失败！订单号已存在'
        ],
        'order_express_price' => [
            'required' => '添加订单失败！请输入快递总价',
        ],
        'order_date' => [
            'required' => '添加订单失败！请输入快递总价',
            'date' => '添加订单失败！请选择正确的交易日期'
        ],
        'order_platform' => [
            'required' => '添加订单失败！请选择交易平台',
            'exists' => '添加产品失败！交易平台错误'
        ],
        'order_status' => [
            'required' => '添加订单失败！请选择交易状态',
            'exists' => '添加产品失败！交易状态错误'
        ],
        'order_buyer_name' => [
            'required' => '添加订单失败！请输入买家名称'
        ],
        'order_buyer_phone' => [
            'required' => '添加订单失败！请输入买家联系方式'
        ],
        'order_buyer_address' => [
            'required' => '添加订单失败！请输入买家地址'
        ],
        'sku' => [
            'required' => '添加订单失败！请设置订单产品'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
