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

}