<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/3/3
 * Time: 22:28
 */
namespace app\common\model\mysql;

use think\Model;

class User extends Model {

    /**
     * 自动生成写入时间
     * @var bool
     */
    protected $autoWriteTimestamp = true;
    public function getUserByPhoneNumber($phoneNumber) {
        if(empty($phoneNumber)) {
            return false;
        }

        $where = [
            "phone_number" => $phoneNumber,
        ];

        return $this->where($where)->find();
    }

    public function getUserByUsername($username) {
        if(empty($phoneNumber)) {
            return false;
        }

        $where = [
            "username" => $username,
        ];

        return $this->where($where)->find();
    }

    /**
     * @param $id
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserById($id) {
        $id = intval($id);
        if (!$id) {
            return false;
        }
        return $this->find($id);
    }

    /**
     * 根据主键id更新数据表中的数据
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateById($id, $data) {
        $id = intval($id);
        if(empty($id) || empty($data) || !is_array($data)) {
            return false;
        }

        $where = [
            "id" => $id,
        ];

        return $this->where($where)->save($data);
    }
}