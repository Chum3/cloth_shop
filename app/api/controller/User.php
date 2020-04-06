<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/5
 * Time: 20:21
 */
namespace app\api\controller;
use app\common\business\User as UserBis;

class User extends AuthBase {
    public function index() {
        $user = (new UserBis())->getNormalUserById($this->userId);

        $resultUser = [
            "id" => $this->userId,
            "username" => $user['username'],
            "sex" => $user['sex'],
        ];
        return show(config("status.success"),"OK",$resultUser);
    }
}