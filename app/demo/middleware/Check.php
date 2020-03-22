<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/2/29
 * Time: 22:43
 */
namespace app\demo\middleware;

class Check {
    public function handle($request, \Closure $next) {
        dump(1);
        return $next($request);
    }
}