<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/5/1
 * Time: 15:12
 */

namespace app\api\controller\mall;

use app\api\controller\ApiBase;
use app\common\business\Goods as GoodsBis;
use app\common\lib\Show;

class Lists extends ApiBase {
    public function index() {

        $pageSize = input("param.page_size", 10, "intval");
        $categoryId = input("param.category_id", 0, "intval");
        $keyword = input("param.keyword", null, "trim");
        if (!$categoryId && !$keyword) {
            return Show::success();
        }
        $data = [
            "category_path_id" => $categoryId,
            "keyword" => $keyword,
        ];
        if (!$data["category_path_id"]) {
            unset($data['category_path_id']);
        }
        $field = input("param.field", "listorder", "trim");
        $order = input("param.order", 2, "intval");
        $order = $order == 2 ? "desc" : "asc";
        $order = [$field => $order];

        $goods = (new GoodsBis())->getNormalLists($data, $pageSize, $order);
        return Show::success($goods);
    }
}