<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/3/3
 * Time: 22:28
 */
namespace app\common\model\mysql;

use think\Model;

class AdminUser extends Model {
    /**
     * 根据用户名获取后端表的数据
     * @param $username
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getAdminUserByUsername($username) {
        if(empty($username)) {
            return false;
        }

        $where = [
            "username" => trim($username),
        ];

        return $this->where($where)->find();
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