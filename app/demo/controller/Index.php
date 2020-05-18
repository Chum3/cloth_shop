<?php


namespace app\demo\controller;

use app\BaseController;

class Index extends BaseController {
    public function abc() {
        dump(2);
    }

    public function hello() {
        throw new \think\exception\HttpException(400, "找不到相应的数据");
    }

    public function getSnowFlakeId() {
        $redisConfig = ['host' => config('redis.host'), 'port' => config('redis.port')];
        $IdWorker = \wantp\Snowflake\IdWorker::getIns()->setRedisCountServer($redisConfig);
        $id = $IdWorker->id();
        dump($id);
        exit;
    }
}