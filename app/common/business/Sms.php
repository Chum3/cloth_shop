<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/3/22
 * Time: 23:31
 */
declare(strict_types=1);
namespace app\common\business;
use app\common\lib\sms\AliSms;
use app\common\lib\Num;
use app\common\lib\ClassArr;
class Sms {
    public static function sendCode(string $phoneNumber, int $len, $type = 'ali') :bool {

        $code = Num::getCode($len);
        // $sms = AliSms::sendCode($phoneNumber,$code);
        //$sms = 1;
        //工厂模式
        // $type = ucfirst($type);
        // // todo 放在配置文件上
        // $class = "app\common\lib\sms\\".$type."Sms";
        // $sms = $class::sendCode($phoneNumber, $code);

        $classStats = ClassArr::smsClassStat();
        $classObj =  ClassArr::initClass($type, $classStats);
        $sms = $classObj::sendCode($phoneNumber, $code);
        if($sms) {
            // todo 把短信验证码记录到redis，并且给出一个失效时间 1min有效
            cache(config("redis.code_pre").$phoneNumber,$code,config("redis.code_expire"));
        }

        return true;
    }
}