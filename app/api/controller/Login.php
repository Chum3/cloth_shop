<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/4/5
 * Time: 11:26
 */
declare(strict_types = 1);
namespace app\api\controller;
use app\BaseController;

class Login extends BaseController {
    public function index() :object {
        if (!$this->request->isPost()) {
            return show(config("status.error"),"非法请求");
        }
        $phoneNumber = $this->request->param("phone_number","","trim");
        $code = input("param.code",0,"intval");
        $type = input("param.type",0,"intval");
        //参数校验
        $data = [
            'phone_number' => $phoneNumber,
            'code' => $code,
            'type' => $type,
        ];
        $validate = new \app\api\validate\User();
        if(!$validate->scene('login')->check($data)) {
            return show(config('status.error'),$validate->getError());
        }
        try {
            $result = (new \app\common\business\User())->login($data);
        } catch (\Exception $e) {
            return show($e->getCode(), $e->getMessage());
        }
        if ($result) {
            return show(config('status.success'),"登录成功", $result);
        }
        return show(config('status.error'),"登录失败");
    }
}