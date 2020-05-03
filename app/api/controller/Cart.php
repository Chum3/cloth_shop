<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/5/2
 * Time: 16:13
 */

namespace app\api\controller;

use app\common\business\Cart as CartBis;
use app\common\lib\Show;

class Cart extends AuthBase {

    public function add() {
        if (!$this->request->isPost()) {
            return Show::error();
        }
        $id = input("param.id", 0, "intval");
        $num = input("param.num", 0, "intval");
        if (!$id || !$num) {
            return Show::error("参数不合法");
        }
        $res = (new CartBis())->insertRedis($this->userId, $id, $num);
        if ($res === FALSE) {
            return Show::error();
        }
        return Show::success();
    }

    public function lists() {
        $ids = input("param.id", "", "trim");
        $res = (new CartBis())->lists($this->userId, $ids);
        if ($res === FALSE) {
            return Show::error();
        }
        return Show::success($res);
    }

    public function delete() {
        if (!$this->request->isPost()) {
            return Show::error();
        }

        $id = input("param.id", 0, "intval");
        if (!$id) {
            return Show::error("参数不合法");
        }
        $res = (new CartBis())->deleteRedis($this->userId, $id);
        if ($res === FALSE) {
            return Show::error();
        }
        return Show::success($res);
    }

    public function update() {
        if (!$this->request->isPost()) {
            return Show::error();
        }

        $id = input("param.id", 0, "intval");
        $num = input("param.num", 0, "intval");
        if (!$id || !$num) {
            return Show::error("参数不合法");
        }

        try {
            $res = (new CartBis())->updateRedis($this->userId, $id, $num);
        } catch (\think\Exception $e) {
            return Show::error($e->getMessage());
        }
        if ($res === FALSE) {
            return Show::error();
        }
        return Show::success($res);
    }

}