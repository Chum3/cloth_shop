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
}