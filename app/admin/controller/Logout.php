<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/3/14
 * Time: 15:24
 */

namespace app\admin\controller;

class Logout extends AdminBase {
    public function index() {
        //清除session
        session(config("admin.session_admin"), null);
        //执行跳转
        return redirect(url("login/index"));
    }
}