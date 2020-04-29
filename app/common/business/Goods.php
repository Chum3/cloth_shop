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
        // 开启一个事务
        $this->model->startTrans();

        try {
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
            // 事务提交
            $this->model->commit();
            return true;
        } catch (\think\Exception $e) {
            // 事务回滚
            $this->model->rollback();
            return false;
        }

    }

    /**
     * @param $data
     * @param int $num
     * @return array
     */
    public function getLists($data, $num = 5) {
        $likeKeys = [];
        if (!empty($data)) {
            $likeKeys = array_keys($data);
        }
        try {
            $list = $this->model->getLists($likeKeys, $data, $num);
            $result = $list->toArray();
        } catch (\Exception $e) {
            $result = \app\common\lib\Arr::getPaginateDefaultData($num);
        }
        return $result;
    }

    public function getRotationChart() {
        $data = [
            "is_index_recommend" => 1,
        ];
        $field = "sku_id as id, title, big_image as image";

        try {
            $result = $this->model->getNormalGoodByCondition($data, $field, 5);
        }catch (\Exception $e) {
            return [];
        }
        return $result->toArray();
    }

    public function categoryGoodsRecommend($categoryIds) {
        if (!$categoryIds) {
            return [];
        }
        // todo 栏目的获取
        foreach ($categoryIds as $k => $categoryId) {
            $result[$k]["categorys"] = [];
        }
        foreach ($categoryIds as $keys => $categoryId) {
            $result[$keys]["goods"] = $this->getNormalGoodsFindInSetCategoryId($categoryId);
        }
        return $result;
    }

    public function getNormalGoodsFindInSetCategoryId($categoryId) {
        $field = "sku_id as id, title, price, recommend_image as image";
        try {
            $result = $this->model->getNormalGoodsFindInSetCategoryId($categoryId, $field);
        }catch (\Exception $e) {
            return [];
        }

        return $result->toArray();
    }
}