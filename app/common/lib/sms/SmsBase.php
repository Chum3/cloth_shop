<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/4/1
 * Time: 21:47
 */
declare(strict_types=1);
namespace app\common\lib\sms;

interface SmsBase {
    public static function sendCode(string $phone, int $code);
}