<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/18
 * Time: 22:41
 */

namespace app\admin\controller;
use app\common\business\Goods as GoodsBis;
use app\common\lib\Status as StatusLib;
class Goods extends AdminBase {
    public function index() {
        $data = [];
        $title = input("param.title", "", "trim");
        $time = input("param.time", "", "trim");
        $searchData['title'] =  input("param.title", "");;
        $searchData['time'] = input("param.time", "");;
        if (!empty($title)) {
            $data['title'] = $title;
        }
        if (!empty($time)) {
            $data['create_time'] = explode(" - ", $time);
        }
        $goods = (new GoodsBis())->getLists($data, 5);
        return view("", [
            "goods" => $goods,
            "searchData" => $searchData,
        ]);
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
        $check = $this->request->checkToken('__token__');
        if (!$check) {
            return show(config('status.error'),"非法请求");
        }
        // 数据处理
        $data['category_path_id'] = $data['category_id'];
        $result = explode(",",$data['category_path_id']);
        $data['category_id'] = end($result);

        $res = (new GoodsBis())->insertData($data);
        if (!$res) {
            return show(config('status.error'),"商品新增失败");
        }
        return show(config('status.success'), "商品新增成功");
    }

    /**
     * 排序
     * @return \think\response\Json
     */
    public function listorder() {
        $id = input("param.id", 0, "intval");
        // todo 用validate验证机制处理相关验证
        $listorder = input("param.listorder",0,"intval");
        if (!$id) {
            return show(config('status.error'), "参数错误");
        }

        try {
            $res = (new GoodsBis())->listorder($id, $listorder);
        } catch (\Exception $e) {
            return show(config('status.error'), $e->getMessage());
        }
        if ($res) {
            return show(config('status.success'), "排序成功");
        } else {
            return show(config('status.error'), "排序失败");
        }
    }

    /**
     * 更新状态
     * @return \think\response\Json
     */
    public function status() {
        $status = input("param.status", 0, "intval");
        $id = input("param.id",0, "intval");
        // todo 使用validate验证机制处理相关认证
        if (!$id || !in_array($status, StatusLib::getTableStatus())) {
            return show(config('status.error'), "参数错误");
        }

        try {
            $res = (new GoodsBis())->status($id, 'status', $status);
        } catch (\Exception $e) {
            return show(config('status.errpr'), $e->getMessage());
        }
        if($res) {
            return show(config('status.success'), "状态更新成功");
        } else {
            return show(config('status.error'), "状态更新失败");
        }
    }

    public function isIndexRecommend() {
        $isIndexRecommend = input("param.isIndexRecommend", 0, "intval");
        $id = input("param.id",0, "intval");
        // todo 使用validate验证机制处理相关认证
        if (!$id || !in_array($isIndexRecommend, StatusLib::getRecommendStatus())) {
            return show(config('status.error'), "参数错误");
        }

        try {
            $res = (new GoodsBis())->status($id,'is_index_recommend', $isIndexRecommend);
        } catch (\Exception $e) {
            return show(config('status.errpr'), $e->getMessage());
        }
        if($res) {
            return show(config('status.success'), "状态更新成功");
        } else {
            return show(config('status.error'), "状态更新失败");
        }
    }
}