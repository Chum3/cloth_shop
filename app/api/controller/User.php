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

    /**
     * PUT
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function update() {
        $username = input("param.username","","trim");
        $sex = input("param.sex",0,"intval");

        $data = [
            'username' => $username,
            'sex' => $sex
        ];
        $validate = (new \app\api\validate\User())->scene('update_user');
        if (!$validate->check($data)) {
            return show(config('status.error'),$validate->getError());
        }
        $userBisObj = new UserBis();
        $user = $userBisObj->update($this->userId,$data);
        if (!$user) {
            return show(config('status.error'),"更新失败");
        }
        return show(1,"ok");
    }
}