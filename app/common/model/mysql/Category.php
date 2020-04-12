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

}