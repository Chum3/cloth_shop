<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/19
 * Time: 11:55
 */
namespace app\common\business;

class BusBase
{

    /**
     * 新增逻辑
     * @param $data
     * @return int|mixed
     */
    public function add($data) {
        $data['status'] = config("status.mysql.table_normal");
        //todo 根据name 查询$name 是否存在
        try {
            $this->model->save($data);
        } catch (\Exception $e) {
            // todo 记录日志
            return 0;
        }
        // 返回主键ID
        return $this->model->id;
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

    public function status($id, string $fieldKey, $fieldValue) {
        // 查询 id这条数据是否存在
        $res = $this->getById($id);
        if (!$res) {
            throw new \think\Exception("不存在该条记录");
        }
        if ($res[$fieldKey] == $fieldValue) {
            throw new \think\Exception("状态修改前和修改后一样,请停止这种无意义的行为OMG！");
        }

        $data = [
            $fieldKey => intval($fieldValue),
        ];

        try {
            $res = $this->model->updateById($id, $data);
        } catch (\Exception $e) {
            // todo 记录日志
            return false;
        }
        return $res;
    }

    public function updateStock($data) {
        // 实际上 这个地方 是有性能瓶颈
        // 10 sku_id stock  1 => 10 2= > 4  2 1  1 =>   9 3
        // 批量更新方式去处理
        foreach ($data as $value) {
            $this->model->decStock($value['id'], $value['num']);
        }
        return true;
    }

}