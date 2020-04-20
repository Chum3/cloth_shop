<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/19
 * Time: 11:55
 */
namespace app\common\business;
use app\common\model\mysql\SpecsValue as SpecsValueModel;
class SpecsValue extends BusBase
{
    public $model = NULL;
    public function __construct() {
        $this->model = new SpecsValueModel();
    }

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
     * @param $specsId
     * @return array
     */
    public function getBySpecsId($specsId) {
        try {
            $result = $this->model->getNormalBySpecsId($specsId, "id,name");
        } catch (\Exception $e) {
            return [];
        }
        $result = $result->toArray();
        return$result;
    }
}