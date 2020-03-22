<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/3/1
 * Time: 15:18
 */

namespace app\admin\controller;
use think\facade\View;
use app\common\model\mysql\AdminUser;

class Login extends AdminBase {

    /**
     * 重写adminbase的initialize()，防止无限重定向
     */
    public function initialize() {
        if ($this->isLogin()) {
            return $this->redirect(url("index/index"));
        }
    }

    public function index() {
        //echo 123;
        return View::fetch();
    }

    public function md5() {
        halt(session(config("admin.session_admin")));
        echo md5("admin_salt_value");
    }

    public function check() {
        if(!$this->request->isPost()) {
            return show(config("status.error"), "请求方式错误");
        }

        //参数检验
        $username = $this->request->param("username","", "trim");
        $password = $this->request->param("password","","trim");
        $captcha = $this->request->param("captcha","","trim");
        $data = [
            'username' => $username,
            'password' => $password,
            'captcha' => $captcha,
        ];
        $validate = new \app\admin\validate\AdminUser();
        if (!$validate->check($data)) {
            return show(config("status.error"), $validate->getError());
        }

        //这一块放在validate模块验证
        //if(empty($username) || empty($password) || empty($captcha)) {
        //    return show(config("status.error"), "参数不能为空");
        //}
        //需要校验验证码
        //if(!captcha_check($captcha)) {
        //    return show(config("status.error"), "验证码不正确");
        //}

        try {
            $adminUserObj = new \app\admin\business\AdminUser();
            $result = $adminUserObj->login($data);
        } catch (\Exception $e) {
            return show(config("status.error"), $e->getMessage());
        }
        if($result) {
            return show(config("status.success"), "登录成功");
        }
        return show(config("status.error"), $validate->getError());
    }
}