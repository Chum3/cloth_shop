<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/11
 * Time: 21:27
 */

namespace app\common\business;
use app\common\model\mysql\Category as CategoryModel;
class Category {
    public $categoryObj = null;
    public function __construct() {
        $this->categoryObj = new CategoryModel();
    }

    public function add($data) {
        $data['status'] = config("status.mysql.table_normal");
        $name = $data['name'];
        // 根据$name 去数据库查询是否存在这条记录
        if ($this->categoryObj->getCategoryIdByName($name)) {
            throw new \think\Exception("该分类已存在,请重新输入分类名");
        };
        try {
            $this->categoryObj->save($data);
        }catch (\Exception $e) {
            throw new \think\Exception("服务器内部异常");
        }
        return $this->categoryObj->getLastInsID();
    }
}