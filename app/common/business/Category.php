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
    public $model = null;
    public function __construct() {
        $this->model = new CategoryModel();
    }

    public function add($data) {
        $data['status'] = config("status.mysql.table_normal");
        $name = $data['name'];
        // 根据$name 去数据库查询是否存在这条记录
        if ($this->model->getCategoryIdByName($name)) {
            throw new \think\Exception("该分类已存在,请重新输入分类名");
        };
        try {
            $this->model->save($data);
        }catch (\Exception $e) {
            throw new \think\Exception("服务器内部异常");
        }
        return $this->model->id;
    }
    public function getNormalCategorys() {
        $field = "id, name, pid";
        $categorys = $this->model->getNormalCategorys($field);
        if (!$categorys) {
           return $categorys;
        }
        $categorys = $categorys->toArray();
        return $categorys;
    }

    public function getNormalAllCategorys() {
        $field = "id as category_id, name, pid";
        $categorys = $this->model->getNormalCategorys($field);
        if (!$categorys) {
            return $categorys;
        }
        $categorys = $categorys->toArray();
        return $categorys;
    }

    public function getLists($data, $num) {
        $list = $this->model->getLists($data, $num);
        if (!$list) {
            return [];
        }
        $result = $list->toArray();
        $result['render'] = $list->render();

        // 思路：第一步拿到列表种的id 第二步in mysql 求count 第三步把count填充到列表页中
        $pids = array_column($result['data'],'id');
        if ($pids) {
            $idCountResult = $this->model->getChildCountInPids(['pid' => $pids]);
            $idCountResult = $idCountResult->toArray();

            $idCounts = [];
            //第一种方式
            foreach ($idCountResult as $countResult) {
                $idCounts[$countResult['pid']] = $countResult['count'];
            }
        }
        if ($result['data']) {
            foreach ($result['data'] as $k => $value) {
                // $a >> 0 等同于isset($a) ? $a :0.
                $result['data'][$k]['childCount'] = $idCounts[$value['id']] ?? 0;
            }
        }
        return $result;
    }

    /**
     * 根据id获取某一条记录
     * @param $id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getById($id) {
        $result = $this->model->find($id);
        if (empty($result)) {
            return [];
        }
        $result = $result->toArray();
        return $result;
    }

    /**
     * 排序bis
     * @param $id
     * @param $listorder
     * @return bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function listorder($id, $listorder) {
        // 查询 id这条数据是否存在
        $res = $this->getById($id);
        if (!$res) {
            throw new \think\Exception("不存在该条记录");
        }
        $data = [
            "listorder" => $listorder,
        ];

        try {
            $res = $this->model->updateById($id, $data);
        }catch (\Exception $e) {
            // todo 记录日志
            return false;
        }
        return $res;
    }

    public function status($id, $status) {
        // 查询 id这条数据是否存在
        $res = $this->getById($id);
        if (!$res) {
            throw new \think\Exception("不存在该条记录");
        }
        if ($res['status'] == $status) {
            throw new \think\Exception("状态修改前和修改后一样,请停止这种无意义的行为OMG！");
        }

        $data = [
            "status" => intval($status),
        ];

        try {
            $res = $this->model->updateById($id, $data);
        } catch (\Exception $e) {
            // todo 记录日志
            return false;
        }
        return $res;
    }

    /**
     * @param int $pid
     * @param string $field
     * @return array
     */
    public function getNormalByPid($pid = 0, $field = "id, name, pid") {
        // $field = "id, name, pid";
        try {
            $res = $this->model->getNormalByPid($pid, $field);
        } catch (\Exception $e) {
            // todo 记录日志
            return [];
        }
        $res = $res->toArray();

        return $res;
    }
}