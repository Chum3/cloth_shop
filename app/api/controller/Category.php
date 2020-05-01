<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/18
 * Time: 17:08
 */

namespace app\api\controller;
use app\common\business\Category as CategoryBis;

class Category extends ApiBase {
    public function index() {
        // 获取所有分类的内容
        try {
            $categoryBusObj = new CategoryBis();
            $categorys = $categoryBusObj->getNormalAllCategorys();
        } catch (\Exception $e) {
            // todo 加日志
            return show(config("status.success"), "内部异常");
        }
        if (!$categorys) {
            return show(config("status.success"), "数据为空");
        }
        $result = \app\common\lib\Arr::getTree($categorys);
        $result = \app\common\lib\Arr::sliceTreeArr($result);
        return show(config("status.success"), "OK", $result);
    }

    /**
     * api/category/search/123
     * 商品列表页面，按栏目检索的内容
     * @return \think\response\Json
     */
    public function search() {
        // todo 现在先写死，以后再做
        $result = [
            "name" => "一级分类",
            "focus_ids" => [1, 13],
            "list" => [
                [
                    ['id' => 1, 'name' => '二级分类1'],
                    ['id' => 2, 'name' => '二级分类2'],
                    ['id' => 3, 'name' => '二级分类3'],
                    ['id' => 4, 'name' => '二级分类3'],
                    ['id' => 5, 'name' => '二级分类5'],
                ],
                [
                    ['id' => 11, 'name' => '三级分类1'],
                    ['id' => 12, 'name' => '三级分类2'],
                    ['id' => 13, 'name' => '三级分类3'],
                    ['id' => 14, 'name' => '三级分类3'],
                    ['id' => 15, 'name' => '三级分类5'],
                ],
            ],
        ];
        return show(config("status.success"), "ok", $result);
    }

    public function sub() {
        // todo
        $result = [
            ["id" => 21, "name" => "点儿到三分类1"],
            ["id" => 22, "name" => "点儿到三分类2"],
            ["id" => 33, "name" => "点儿到三分类3"],
            ["id" => 134, "name" => "点儿到三分类4"],
            ["id" => 154, "name" => "点儿到三分类5"],
        ];
        return show(config("status.success"), "ok", $result);
    }
}