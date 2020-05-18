<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/5/3
 * Time: 19:10
 */

namespace app\common\model\mysql;

class OrderGoods extends BaseModel {
    public function getOrderGoodsListByOrderIds($orderIds = []) {
        if (!is_array($orderIds)) {
            return false;
        }
        $res = $this->whereIn('order_id', $orderIds)
            ->order('create_time', 'desc')
            ->select();
        return $res;
    }
}