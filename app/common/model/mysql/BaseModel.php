<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/20
 * Time: 23:37
 */
namespace app\common\model\mysql;
use think\Model;

class BaseModel extends Model {
    /**
     * @var bool
     */
    protected $autoWriteTimestamp = true;

    public function updateById($id, $data) {
        $data['update_time'] = time();
        return $this->where(["id" => $id])->save($data);
    }

    public function getNormalInIds($ids) {
        return $this->whereIn("id", $ids)
            ->where("status", "=", config("status.mysql.table_normal"))
            ->select();
    }

    /**
     * @param array $condition
     * @param array $order
     * @return bool|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getByCondition($condition = [], $order = ["id" => "desc"]) {
        if (!$condition || !is_array($condition)) {
            return false;
        }
        $result = $this->where($condition)
            ->order($order)
            ->select();

        ///echo $this->getLastSql();exit;
        return $result;
    }

    public function decStock($id, $num) {
        return $this->where("id", "=", $id)
            ->dec("stock", $num)
            ->update();
    }

    public function getList($where = [], $pageSize = 10, $order = ['create_time' => 'desc']) {
        return $this->where($where)
            ->order($order)
            ->paginate($pageSize);
    }

}