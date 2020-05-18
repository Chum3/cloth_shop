<?php
/** 该文件主要是存放业务状态码相关的配置 **/

return [
    "success" => 1,
    "error" => 0,
    "not_login" => -1,
    "user_is_register" => -2,
    "action_not_found" => -3,
    "controller_not_found" => -4,

    "mysql" => [
        "table_normal" => 1,    //正常
        "table_pedding" => 0,   //待审
        "table_delete" => 99,   //删除
    ],
    'orderStatus' => [
        'to_be_paid' => 1,         //待支付
        'to_be_delivered' => 2,    //待发货
        'to_be_received' => 3,      //待收货
        'success' => 4,             //已完成
        'cancel' => 5,              //已取消
    ],
    'orderStatusName' => [
        1 => '待支付',
        2 => "待发货",
        3 => "待收货",
        4 => "已完成",
        5 => "已取消",
    ],
    'payType' => [
        'alipay' => 1,
        'weixin' => 2,
    ],
    // 推荐状态
    "recommend" => [
        "isRecommend" => 1,
        "notRecommend" => 0,
    ]
];