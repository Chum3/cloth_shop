<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/4/5
 * Time: 11:42
 */
namespace app\common\business;
use app\common\model\mysql\User as UserModel;
use app\common\lib\Str;
use app\common\lib\Time;

class User {
    public $userObj  = null;
    public function __construct() {
        $this->userObj = new UserModel();
    }

    public function login($data) {
        $redisCode = cache(config("redis.code_pre") . $data['phone_number']);
        if (empty($redisCode) || $redisCode != $data['code']) {
           throw new \think\Exception("不存在该验证码",-1009);
        }
        // 需要去判断表是否有 用户记录  phone_number
        // 生成token
        $user = $this->userObj->getUserByPhoneNumber($data['phone_number']);
        if (!$user) {
            $username = "mall粉-".$data['phone_number'];
            $userData = [
                'username' => $username,
                'phone_number' => $data['phone_number'],
                'type' =>  $data['type'],
                'status' => config('status.mysql.table_normal'),
                "last_login_time" => time(),
                "last_login_ip" => request()->ip(),
            ];
            try {
                $this->userObj->save($userData);
                $userId = $this->userObj->id;
            }catch (\Exception $e) {
                throw new \think\Exception("数据库内部异常");
            }
        } else {
            //更新表
            $userData = [
                'type' =>  $data['type'],
                'status' => config('status.mysql.table_normal'),
                "update_time" => time(),
                "last_login_time" => time(),
                "last_login_ip" => request()->ip(),
            ];

            try {
                $userId = $user->id;
                $this->userObj->updateById($userId,$userData);
                $username = $user->username;
            }catch (\Exception $e) {
                throw new \think\Exception("数据库内部异常");
            }

        }
        $token = Str::getLoginToken($data['phone_number']);
        $redisData = [
            "id" => $userId,
            "username" => $username,
        ];
        $res = cache(config("redis.token_pre").$token,$redisData, Time::userLoginExpiresTime($data['type']));

        return $res ? ["token" => $token, "username" => $username] : false;
    }

    /**
     * 返回正常用户数据
     * @param $id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNormalUserById($id) {
        $user = $this->userObj->getUserById($id);
        if (!$user ||  $user->status != config("status.mysql.table_normal")) {
            return [];
        }
        return $user->toArray();
    }

}