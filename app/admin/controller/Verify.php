<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/3/1
 * Time: 18:15
 */

namespace app\admin\controller;

use think\captcha\facade\Captcha;

class Verify {

    public function index() {
        return Captcha::create("abc");
    }
}