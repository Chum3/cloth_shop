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
            6,7,8,9,10,11,12,13
        ];
        $result = (new GoodsBis())->categoryGoodsRecommend($categoryIds);
        return Show::success($result);
    }
}