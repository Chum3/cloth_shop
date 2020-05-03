<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/5/3
 * Time: 13:50
 */

namespace app\api\controller;

// todo 先写死，有时间再补（vue也要改）
class Address extends AuthBase {
    public function index() {
        // 获取该用户下所有设置的收获地址
        $result = [
            [
                "id" => 1,
                // 收货人 信息
                "consignee_info" => "北京 海淀 科技园 上地10街 singwa收 180xxxx",
                "is_default" => 1,
            ],
            [
                "id" => 2,
                // 收货人 信息
                "consignee_info" => "北京 昌平 沙河镇 沙河高教园  麦迪收 180xxxx",
                "is_default" => 0,
            ],
            [
                "id" => 3,
                // 收货人 信息
                "consignee_info" => "江西省 抚州市 东乡区 小竹街190号 小竹收 180xxxx",
                "is_default" => 0,
            ],
        ];

        return show(1, "OK", $result);
    }
}