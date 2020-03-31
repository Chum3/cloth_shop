<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/3/22
 * Time: 23:19
 */
declare(strict_types=1);
namespace app\api\controller;

use app\BaseController;
use app\common\business\Sms as SmsBus;

class Sms extends BaseController {

    public function code() :object {
        $phoneNumber = input('param.phone_number','','trim');

        $data = [
            'phone_number' => $phoneNumber,
        ];
        try {
            validate(\app\api\validate\User::class)->scene("send_code")->check($data);
        }catch (\think\exception\ValidateException $e) {
            return show(config("status.error"), $e->getError());
        }

        // 调用business层的数据
        if(SmsBus::sendCode($phoneNumber,6)) {
            return show(config("status.success"),"发送验证码成功");
        }
       return show(config("status.success"),"发送验证码失败");
    }
}