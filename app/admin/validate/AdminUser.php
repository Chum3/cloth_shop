<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/3/14
 * Time: 18:20
 */
namespace app\admin\validate;

use think\Validate;

class AdminUser extends Validate {
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
        'captcha' => 'require|checkCaptcha',
    ];

    protected $message = [
        'username' => '用户名必须',
        'password' => '密码必须',
        'captcha' => '验证码必须',
    ];

    protected function checkCaptcha($value, $rule, $data = []) {
        if(!captcha_check($value)) {
            return "您输入的验证码不正确！";
        }

        return true;
    }
}