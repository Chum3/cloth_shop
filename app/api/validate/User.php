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
        'code'  =>  'require|number|min:4',
        'type' => ["require","in"=>"1,2"],
    ];

    protected $message = [
        'username' => '用户名必须',
        'phone_number' => '电话号码必须',
        'code.require' =>  '短信验证码必须',
        'code.number' =>    '短信验证码必须为数字',
        'code.min' =>  '短信验证码长度不得低于4',
        'type.require' => '类型必须',
        'type.in' =>    '类型数值错误',
    ];

    protected $scene = [
        'send_code' => ['phone_number'],
        'login' =>  ['phone_number','code','type'],
    ];
}