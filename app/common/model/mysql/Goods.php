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
     * title查询条件表达式
     * 搜索器仅在调用withSearch方法的时候触发
     * @param $query
     * @param $value
     */
    public function searchTitleAttr($query, $value) {
        $query->where('title', 'like', '%' . $value . '%');
    }

    public function searchCreateTimeAttr($query, $value) {
        $query->whereBetweenTime('create_time', $value[0], $value[1]);
    }

    /**
     * @param $likeKeys
     * @param $data
     * @param int $num
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     */
    public function getLists($likeKeys, $data, $num = 10) {
        $order = ["listorder" => "desc", "id" => "desc"];
        if (!empty($likeKeys)) {
            $res = $this->withSearch($likeKeys, $data);
        } else {
            $res = $this;
        }
        $list = $res->whereIn("status", [0, 1])
            ->order($order)
            ->paginate($num);
        // echo $this->getLastSql();exit;
        return $list;
    }

    public function getNormalGoodByCondition($where, $field = true, $limit = 5) {
        $order = ["listorder" => "desc", "id" => "desc"];

        $where["status"] = config("status.success");

        $result = $this->where($where)
            ->order($order)
            ->field($field)
            ->limit($limit)
            ->select();

        return $result;
    }

    public function getImageAttr($value) {
        return request()->domain().$value;
    }

    public function getNormalGoodsFindInSetCategoryId($categoryId, $field = true, $limit = 10) {
        $order = ["listorder" => "desc", "id" => "desc"];

        $result = $this->whereFindInSet("category_path_id", $categoryId)
                ->where("status", "=", config("status.success"))
                ->order($order)
                ->field($field)
                ->limit(10)
                ->select();
        // echo $this->getLastSql();exit;
        return $result;
    }
}