<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/26
 * Time: 22:50
 */
namespace app\api\controller;

use app\common\business\Goods as GoodsBis;
use app\common\lib\Show;
class Index extends ApiBase {

    public function getRotationChart() {
        $result = (new GoodsBis())->getRotationChart();
        return Show::success($result);
    }

    public function cagegoryGoodsRecommend() {
        $categoryIds = [
            106,
            97,
        ];
        $result = (new GoodsBis())->categoryGoodsRecommend($categoryIds);
        return Show::success($result);
    }
}