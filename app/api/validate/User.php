<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/3/23
 * Time: 22:23
 */
namespace app\api\validate;

use think\Validate;

class User extends Validate {
    protected $rule = [
        'username' => 'require',
        'phone_number' => 'require',        // todo 验证是否为手机号格式
    ];

    protected $message = [
        'username' => '用户名必须',
        'phone_number' => '电话号码必须',
    ];

    protected $scene = [
        'send_code' => ['phone_number'],
    ];
}