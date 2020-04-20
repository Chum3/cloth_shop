<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/19
 * Time: 11:41
 */
namespace app\admin\controller;
use app\common\business\SpecsValue as SpecsValueBis;
class SpecsValue extends AdminBase {

    public function save() {
        $specsId = input("param.specs_id", 0, "intval");
        $name = input("param.name", "", "trim");
        // todo validate

        $data = [
            "specs_id" => $specsId,
            "name" => $name,
        ];
        $id = (new SpecsValueBis())->add($data);
        if(!$id) {
            return show(config('status.error'), "新增失败");
        }
        return show(config("status.success"),"OK", ["id"=>$id]);
    }

    public function getBySpecsId() {
        $specsId = input("param.specs_id", 0, "intval");
        if(!$specsId) {
            return show(config('status.success'),"没有数据~");
        }
        $result = (new SpecsValueBis())->getBySpecsId($specsId);
        return show(config('status.success'), "OK", $result);
    }

    // todo 删除
}