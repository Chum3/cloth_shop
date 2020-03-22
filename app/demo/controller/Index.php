<?php


namespace app\demo\controller;

use app\BaseController;
class Index extends BaseController
{
    public function abc() {
        dump(2);
    }

    public function hello() {
        throw new \think\exception\HttpException(400, "找不到相应的数据");
    }
}