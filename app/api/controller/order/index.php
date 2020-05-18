<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/5/3
 * Time: 17:39
 */

namespace app\api\controller\order;

use app\api\controller\AuthBase;
use app\common\business\Order;
use app\common\lib\Show;

class Index extends AuthBase {

    /**
     *
     * 创建订单  order  post
     * address_id
     * cart_ids
     * @return \think\response\Json
     */
    public function save() {
        $addressId = input("param.address_id", 0, "intval");
        $ids = input("param.ids", "", "trim");
        if (!$ids) {
            // 参数适配
            $ids = input("param.cart_ids", "", "trim");
        }
        if (!$addressId || !$ids) {
            return Show::error("参数错误");
        }

        $data = [
            "ids" => $ids,
            "address_id" => $addressId,
            "user_id" => $this->userId,
        ];
        try {
            $result = (new Order())->save($data);
        } catch (\Exception $e) {
            return Show::error($e->getMessage());
        }
        if (!$result) {
            return Show::error("提交订单失败，请稍候重试");
        }
        return Show::success($result);

    }

    /**
     * 获取订单详情
     * @return \think\response\Json
     */
    public function read() {
        $id = input("param.id", "0", "trim");
        if (empty($id)) {
            return Show::error("参数错误");
        }
        $data = [
            "user_id" => $this->userId,
            "order_id" => $id,
        ];

        $result = (new Order())->detail($data);

        if (!$result) {
            return Show::error("获取订单失败");
        }
        return Show::success($result);

    }

    public function index() {
        $userId = $this->userId;
        $pageSize = input("param.page_size", "10", "intval");

        $data = [
            "user_id" => $userId,
        ];
        $res = (new Order())->getList($data, $pageSize);
        if ($res === false) {
            return Show::error("获取订单列表失败");
        }
        return Show::success($res);
    }
}