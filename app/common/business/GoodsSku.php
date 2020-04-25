<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/20
 * Time: 22:52
 */
namespace app\common\business;
use app\common\model\mysql\GoodsSku as GoodsSkuModel;
class GoodsSku extends BusBase
{
    public $model = NULL;

    public function __construct() {
        $this->model = new GoodsSkuModel();
    }

    public function saveAll($data) {
        if(!$data['skus']) {
            return false;
        }

        foreach ($data['skus'] as $value) {
            $insertData[] = [
                "goods_id" => $data['goods_id'],
                "specs_value_ids" => $value['propvalnames']['propvalids'],
                "price" => $value['propvalnames']['skuSellPrice'],
                "cost_price" => $value['propvalnames']['skuMarketPrice'],
                "stock" => $value['propvalnames']['skuStock'],
            ];
        }

        try {
            $result = $this->model->saveAll($insertData);
            return $result->toArray();
        } catch (\Exception $e) {
            // todo  记录日志
            return false;
        }
    }
}