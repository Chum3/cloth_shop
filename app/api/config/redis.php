<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/3/29
 * Time: 10:49
 */

return [
    "code_pre" => "mall_code_pre_",
    "code_expire" => 3600 * 24 * 30,        //todo 修改一下验证码时间
    "token_pre" => "mall_token_pre_",
    "cart_pre" => "mall_cart_",
    // 延迟队列 - 订单是否需要取消状态检查
    "order_status_key" => "order_status",
    "order_expire" => 20 * 60,
];