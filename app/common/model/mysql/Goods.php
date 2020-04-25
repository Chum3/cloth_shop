<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/20
 * Time: 23:37
 */
namespace app\common\model\mysql;
use think\Model;

class Goods extends BaseModel {
    /**
     * @param $data
     * @param int $num
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     */
    public function getLists($data, $num = 10) {
        $order = ["listorder" => "desc", "id" => "desc"];
        $list = $this->whereIn("status", [0, 1])
            ->order($order)
            ->paginate($num);
        return $list;
    }
}