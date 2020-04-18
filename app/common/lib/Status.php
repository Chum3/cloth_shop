<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/16
 * Time: 21:43
 */

namespace app\common\lib;
class Status {
    public static function getTableStatus() {
        $mysqlStatus = config("status.mysql");
       return array_values($mysqlStatus);
    }
}