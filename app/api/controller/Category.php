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
}