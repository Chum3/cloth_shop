<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/2/29
 * Time: 22:43
 */
declare(strict_types = 1);
namespace app\admin\middleware;

class Auth {
    public function handle( $request, \Closure $next) {

        // 前置中间件
        if (empty(session(config("admin.session_admin"))) && !preg_match("/login/", $request->pathinfo())) {
            return redirect((string)url('login/index'));
        }

        $response = $next($request);

        // 后置中间件
        /*if (empty(session(config("admin.session_admin"))) && $request->controller() != "Login") {
            return redirect((string)url('login/index'));
        }*/
        return $response;

    }

    /**
     * 中间件结束调度
     * @param \think\Response $response
     */
    public function end(\think\Response $response) {

    }
}