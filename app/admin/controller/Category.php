<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/11
 * Time: 17:31
 */
namespace app\admin\controller;

use think\facade\View;
use app\common\business\Category as CategoryBus;
class Category extends AdminBase {
    public function index() {
        return View::fetch();
    }

    public function add() {
        return View::fetch();
    }

    public function save() {
        $pid = input("param.id",0, "intval");
        $name = input("param.name","","trim");

        //参数校验
        $data = [
            'pid' => $pid,
            'name' => $name,
        ];
        $validate = new \app\admin\validate\Category();
        if (!$validate->Check($data)) {
            return show(config("status.error"),$validate->getError());
        }

        try {
            $result = (new CategoryBus())->add($data);
        }catch (\Exception $e) {
            return show(config('status.error'), $e->getMessage());
        }
        return show(config("status.success"),"OK");
    }

}