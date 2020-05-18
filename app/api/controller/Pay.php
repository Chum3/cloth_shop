<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/5/5
 * Time: 16:07
 */

namespace app\api\controller;

use app\BaseController;
use app\common\business\Order as OrderBus;
use app\common\lib\show;

class Pay extends BaseController {
    public function index() {
        if (!$this->request->isPost()) {
            return show(config("status.error"), "非法请求");
        }
        $id = input("param.id");

        $payTypes = config("status.payType");
        $payType = $payTypes[input("param.pay_type")] ?? 0;
        $status = config("status.orderStatus.success");
        $condition = [
            'order_id' => $id,
        ];
        $data = [
            'pay_type' => $payType,
            'status' => $status,
        ];
        try {
            $res = (new OrderBus())->payOrder($condition, $data)->toArray();
        } catch (\Exception $e) {
            return Show::error($e->getMessage());
        }
        return Show::success($res);
    }
}