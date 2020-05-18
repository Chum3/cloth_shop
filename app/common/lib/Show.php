<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/28
 * Time: 22:32
 */

namespace app\common\lib;

class show {
    /**
     * @param array $data
     * @param string $message
     * @return \think\response\Json
     */
    public static function success($data = [], $message = "OK") {
        $result = [
            "status" => config("status.success"),
            "message" => $message,
            "result" => $data,
        ];

        return json($result);
    }

    /**
     * @param array $data
     * @param string $message
     * @param int $status
     * @return \think\response\Json
     */
    public static function error($message = "error", $status = 0, $data = []) {
        $result = [
            "status" => $status,
            "message" => $message,
            "result" => $data,
        ];
        return json($result);
    }
}