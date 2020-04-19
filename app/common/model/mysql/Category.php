<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/3/3
 * Time: 22:28
 */
namespace app\common\model\mysql;

use think\Model;

class Category extends Model {

    /**
     * 自动生成写入时间
     * @var bool
     */
    protected $autoWriteTimestamp = true;

    public function getCategoryIdByName($name) {
        if(empty($name)) {
            return false;
        }

        $where = [
            "name" => trim($name),
        ];

        return $this->where($where)->value('id');
    }

    /**
     * @param string $field
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNormalCategorys($field = "*") {
        $where = [
            "status" => config("status.mysql.table_normal"),
        ];

        $order = [
            "listorder" => "desc",
            "id" => "desc"
        ];

        $result = $this->where($where)
            ->field($field)
            ->order($order)
            ->select();
        return $result;
    }

    public function getLists($where, $num = 10) {
        $order = [
            "listorder" => "desc",
            "id" => "desc"
        ];
        $result = $this->where("status", "<>", config("status.mysql.table_delete"))
            ->where($where)
            ->order($order)
            ->paginate($num);
        return $result;
    }

    /**
     * 根据ID 更新库里面的数据
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateById($id, $data) {
        $data['update_time'] = time();
        return $this->where(["id" => $id])->save($data);
    }

    /**
     * @param $condition
     * @return mixed
     */
    public function getChildCountInPids($condition) {
        $where[] = ['pid', 'in', $condition['pid']];
        $where[] = ["status", "<>", config("status.mysql.table_delete")];
        $res = $this->where($where)
            ->field(["pid", "count(*) as count"])
            ->group("pid")
            ->select();
        // echo $this->getLastSql();exit;
        return $res;
    }

    public function getNormalByPid($pid = 0, $field) {
        $where = [
            "pid" => $pid,
            "status" => config("status.mysql.table_normal"),
        ];
        $order = [
            "listorder" => "desc",
            "id" => "desc",
        ];
        $res = $this->where($where)
            ->field($field)
            ->order($order)
            ->select();
        return $res;
    }

}