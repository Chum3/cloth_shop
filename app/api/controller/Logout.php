<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/8
 * Time: 22:32
 */
namespace app\api\controller;
class Logout extends AuthBase {
    public function index() {
        // 删除redis token 缓存
        $res = cache(config("redis.token_pre").$this->accessToken,NULL);
        if ($res) {
            return show(config("status.success"),"退出登录成功");
        }
        return show(config("status.error"),"退出登录失败");
    }
}
