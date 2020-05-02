<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/19
 * Time: 12:12
 */
namespace app\common\model\mysql;
class SpecsValue extends BaseModel {
    protected $autoWriteTimestamp = true;

    public function getNormalBySpecsId($specsId, $field = "*") {
        $where = [
            "specs_id" => $specsId,
            "status" => config("status.mysql.table_normal"),
        ];

        $res = $this->where($where)
            ->field($field)
            ->select();
        return $res;
    }
}