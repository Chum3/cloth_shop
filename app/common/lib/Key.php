<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/5/2
 * Time: 16:57
 */

namespace app\common\lib;
class Key {

    /**
     * userCart 记录用户购物车的redis key
     * @param $userId
     * @return string
     */
    public static function userCart($userId) {
        return config("redis.cart_pre") . $userId;
    }
}