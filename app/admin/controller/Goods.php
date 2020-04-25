<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/18
 * Time: 22:41
 */

namespace app\admin\controller;
use app\common\business\Goods as GoodsBis;
class Goods extends AdminBase {
    public function index() {
        return view();
    }

    public function add() {
        return view();
    }

    public function save() {
        // 判断是否为post请求，也可以通过在路由中做配置支持post即可
        if (!$this->request->isPost()) {
            return show(config('status.error'), "参数不合法");
        }
        // todo validate 判断数据类型
        $data = input("param.");

        // 数据处理
        $data['category_path_id'] = $data['category_id'];
        $result = explode(",",$data['category_path_id']);
        $data['category_id'] = end($result);

        try {
            $res = (new GoodsBis())->insertData($data);
        }catch (\Exception $e) {
            return show(config('status.error'), $e->getMessage());
        }
        if (!$res) {
            return show(config('status.error'),"商品新增失败");
        }
        return show(config('status.success'), "商品新增成功");
    }
}