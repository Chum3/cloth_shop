<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/4/5
 * Time: 17:54
 */

namespace app\common\lib;

class Time {
    public static function userLoginExpiresTime($type = 2) {
        $type = !in_array($type,[1,2]) ? 2 : $type;
        if ($type == 1) {
            $day = $type * 7;
        } else if ($type == 2) {
            $day = $type * 30;
        }
        return $type * 24 * 3600;
    }
}