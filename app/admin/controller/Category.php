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
use app\common\lib\Status as StatusLib;
class Category extends AdminBase {
    public function index() {
        $pid = input("param.pid", 0, "intval");
        $data = [
            "pid" => $pid,
        ];
        try {
            $categorys = (new CategoryBus())->getLists($data,5);
        }catch (\Exception $e) {
            $categorys = [];
        }
        return View::fetch("", [
            "categorys" => $categorys,
            "pid" => $pid,
        ]);
    }

    public function add() {
        try {
            $categorys = (new CategoryBus())->getNormalCategorys();
        }catch (\Exception $e) {
            $categorys = [];
        }
        return View::fetch("",[
            "categorys" => json_encode($categorys),
        ]);
    }

    // todo 编辑功能

    // todo 分类层级路径

    public function save() {
        $pid = input("param.pid",0, "intval");
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
        if ($result) {
            return show(config("status.success"),"OK");
        }
        return show(config("status.error"),"新增分类失败");
    }

    /**
     * 排序
     * @return \think\response\Json
     */
    public function listorder() {
        $id = input("param.id", 0, "intval");
        // todo 用validate验证机制处理相关验证
        $listorder = input("param.listorder",0,"intval");
        if (!$id) {
            return show(config('status.error'), "参数错误");
        }

        try {
            $res = (new CategoryBus())->listorder($id, $listorder);
        } catch (\Exception $e) {
            return show(config('status.error'), $e->getMessage());
        }
        if ($res) {
            return show(config('status.success'), "排序成功");
        } else {
            return show(config('status.error'), "排序失败");
        }
    }

    /**
     * 更新状态
     * @return \think\response\Json
     */
    public function status() {
        $status = input("param.status", 0, "intval");
        $id = input("param.id",0, "intval");
        // todo 使用validate验证机制处理相关认证
        if (!$id || !in_array($status, StatusLib::getTableStatus())) {
            return show(config('status.error'), "参数错误");
        }

        try {
            $res = (new CategoryBus())->status($id, $status);
        } catch (\Exception $e) {
            return show(config('status.errpr'), $e->getMessage());
        }
        if($res) {
            return show(config('status.success'), "状态更新成功");
        } else {
            return show(config('status.error'), "状态更新失败");
        }
    }

    public function dialog() {
        $categorys = (new CategoryBus())->getNormalByPid();
        return view("", [
            "categorys" => json_encode($categorys),
        ]);
    }

    /**
     * @return \think\response\Json
     */
    public function getByPid() {
        $pid = input("param.pid", 0, "intval");
        $categorys = (new CategoryBus())->getNormalByPid($pid);
        return show(config("status.success"), "OK", $categorys);
    }

}