<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/21
 * Time: 22:31
 */

namespace app\common\model\mysql;

class GoodsSku extends BaseModel {
    public function goods() {
        return $this->hasOne(Goods::class, "id", "goods_id");
    }

    public function getNormalByGoodsId($goodsId = 0) {
        $where = [
            "goods_id" => $goodsId,
            "status" => config("status.mysql.table_normal"),
        ];

        return $this->where($where)->select();
    }

    //
    // public function  incStock($id, $num) {
    //     return $this->where("id", "=", $id)
    //         ->inc("stock", $num)
    //         ->update();
    // }
}