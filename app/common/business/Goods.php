<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/20
 * Time: 22:39
 */
namespace app\common\business;
use app\common\model\mysql\Goods as GoodsModel;
use app\common\business\GoodsSku as GoodsSkuBis;

class Goods extends BusBase
{
    public $model = NULL;

    public function __construct() {
        $this->model = new GoodsModel();
    }

    public function insertData($data) {
        $goodsId = $this->add($data);
        if (!$goodsId) {
            return $goodsId;
        }
        // 执行数据插入到 sku表中
        // 如果是 统一规格
        if ($data['goods_specs_type'] == 1) {
            $goodsSkuData = [
                "goods_id" => $goodsId,
            ];
            // todo
            return true;
        } else if ($data['goods_specs_type'] == 2) {
            $goodsSkuBisobj = new GoodsSkuBis();
            $data['goods_id'] = $goodsId;
            $res = $goodsSkuBisobj->saveAll($data);
            // 如果不为空
            if (!empty($res)) {
                // 总库存
                $stock = array_sum(array_column($res, "stock"));
                $goodsUpdateData = [
                    "price" => $res[0]['price'],
                    "cost_price" => $res[0]['cost_price'],
                    "stock" => $stock,
                    "sku_id" => $res[0]['id'],
                ];
                // 执行完毕后 更新主表中的数据
                $goodsRes = $this->model->updateById($goodsId, $goodsUpdateData);
                if (!$goodsRes) {
                    throw new \think\Exception("insertData:goods主表更新失败");
                }
            } else {
                throw new \think\Exception("sku表新增失败");
            }
        }
        return true;

    }
}