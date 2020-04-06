<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/4/4
 * Time: 12:22
 */
namespace app\common\lib;

class ClassArr {

    public static function smsClassStat() {
        return [
            'ali' => "app\common\lib\sms\AliSms",
            'baidu' => 'app\common\lib\sms\BaiduSms',
            'jd' => 'app\common\lib\sms\JdSms',
        ];
    }
    public static function initClass($type, $classs, $params = [], $needInstance = false) {
        // 如果工厂模式调用的方法是静态的，那么这个地方返回类库 AliSms
        // 如果不是静态的，就需要返回对象
        if(!array_key_exists($type, $classs)) {
            return false;
        }
        $className = $classs[$type];

        return $needInstance == true ? (new \ReflectionClass($className))->newInstanceArgs($params) : $className;
    }
}