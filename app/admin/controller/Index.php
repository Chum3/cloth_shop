<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/3/1
 * Time: 18:50
 */

namespace app\admin\controller;

use think\facade\View;

class Index extends AdminBase {
    public function index() {
        return View::fetch();
    }

    public function welcome() {
        return View::fetch();
    }
}