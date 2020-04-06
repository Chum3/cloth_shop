<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/4/5
 * Time: 16:59
 */
namespace app\common\lib;

class Str {
    public static function getLoginToken($string) {
        // 生成token
        $str = md5(uniqid(md5(microtime(true)),true));  // 生成一个不会重复的字符串
        $token = sha1($str.$string);  // 加密
        return $token;
    }
}