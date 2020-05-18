<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/5/3
 * Time: 19:07
 */

namespace app\common\business;

use app\common\model\mysql\Order as OrderModel;
use app\common\model\mysql\OrderGoods as OrderGoodsModel;
use think\facade\Cache;

class Order extends BusBase {
    public $model = NULL;

    public function __construct() {
        $this->model = new OrderModel();
    }

    /**
     * @param $data
     * @return array|bool|int
     * @throws \think\Exception
     */
    public function save($data) {
        // 拿到一个订单号
        $redisConfig = ['host' => config('redis.host'), 'port' => config('redis.port')];
        $IdWorker = \wantp\Snowflake\IdWorker::getIns()->setRedisCountServer($redisConfig);
        $orderId = $IdWorker->id();
        //echo "order1:".$orderId.PHP_EOL;

        $orderId = (string)$orderId;
        // 获取购物车数据， =》 redis
        $carObj = new Cart();
        $result = $carObj->lists($data['user_id'], $data['ids']);
        if (!$result) {
            return false;
        }
        $newResult = array_map(function ($v) use ($orderId) {
            $v['sku_id'] = $v['id'];
            unset($v['id']);
            $v['order_id'] = $orderId;
            return $v;
        }, $result);

        $price = array_sum(array_column($result, "total_price"));
        $orderData = [
            "user_id" => $data['user_id'],
            "order_id" => $orderId,
            "total_price" => $price,
            "address_id" => $data['address_id'],
        ];

        $this->model->startTrans();
        try {
            // 新增 order
            $id = $this->add($orderData);
            if (!$id) {
                return 0;
            }
            // 新增order_goods
            $orderGoodsResult = (new OrderGoodsModel())->saveAll($newResult);
            // goods_sku 更新
            $skuRes = (new GoodsSku())->updateStock($result);


            // goods 更新
            $goodsResult = array_map(function ($v) {
                $v['id'] = $v['goods_id'];
                unset($v['goods_id']);
                return $v;
            }, $result);
            $goodStock = (new Goods())->updateStock($goodsResult);

            // 删除购物车里面的商品
            $carObj->deleteRedis($data['user_id'], $data['ids']);

            $this->model->commit();
            //echo "order2:".$orderId.PHP_EOL;

            // 把当前订单ID 放入延迟队列中， 定期检测订单是否已经支付 （因为订单有效期是20分钟，超过这个时间还没有支付的，
            // 需要把这个订单取消 ， 然后库存+操作），其他场景也可以用到延迟队列：发货提醒等
            // try {
            //     Cache::zAdd(config("redis.order_status_key"), time() + config("redis.order_expire"), $orderId);
            // } catch (\Exception $e) {
            //     // 记录日志， 添加监控 ，异步根据监控内容处理。
            // }
            return ["id" => $orderId];
        } catch (\Exception $e) {
            $this->model->rollback();
            return false;
        }
    }

    /**
     * @param $data
     * @return array|bool|mixed|\think\Collection
     */
    public function detail($data) {
        // user_id 订单ID组合查询
        $condition = [
            "user_id" => $data['user_id'],
            "order_id" => $data['order_id'],
        ];
        try {
            $orders = $this->model->getByCondition($condition);
        } catch (\Exception $e) {
            $orders = [];
        }
        if (!($orders)) {
            return [];
        }
        $orders = $orders->toArray();
        $orders = !empty($orders) ? $orders[0] : [];
        if (empty($orders)) {
            return [];
        }

        $orders['id'] = $orders['order_id'];
        // todo 先写个模拟地址，后续完成
        $orders['consignee_info'] = "江西省 抚州市 东校区 xxx";

        // 根据order_id查询 order_goods表信息数据
        $orderGoods = (new OrderGoods())->getByOrderId($data['order_id']);

        $orders['malls'] = $orderGoods;
        return $orders;
    }

    /**
     * @param $orderId
     * @param $time
     * @return bool
     */
    public function checkOrderStatus() {

        // todo

        $result = Cache::store('redis')->zRangeByScore("order_status", 0, time(), ['limit' => [0, 1]]);

        if (empty($result) || empty($result[0])) {
            return false;
        }

        try {
            $delRedis = Cache::store('redis')->zRem("order_status", $result[0]);
        } catch (\Exception $e) {
            // 记录日志
            $delRedis = "";
        }
        if ($delRedis) {
            echo "订单id:{$result[0]}在规定时间内没有完成支付 我们判定为无效订单删除" . PHP_EOL;
            /**
             * 第一步： 根据订单ID 去数据库order表里面获取当前这条订单数据 看下当前状态是否是待支付:status = 1
             *        如果是那么需要把状态更新为 已取消 status = 7， 否则不需要care
             *
             * 第二步： 如果第一步status修改7之后， 需要再查询order_goods表， 拿到 sku_id num  把sku表数据库存增加num
             *        goods表总库存也需要修改。
             *
             *
             */
        } else {
            return false;
        }

        return true;
    }

    /**
     * @param array $data
     * @param int $pageSize
     * @return array|bool
     */
    public function getList($data = [], $pageSize = 10) {
        if (!is_array($data)) {
            return false;
        }
        try {
            $orderList = $this->model->getList($data, $pageSize);
        } catch (\Exception $e) {
            return false;
        }
        if (!$orderList) {
            return [];
        }
        $orderList = $orderList->toArray();
        if (isset($orderList['data'])) {
            $orderIds = array_column($orderList['data'], 'order_id');
        } else {
            return [];
        }
        try {
            $orderGoodsList = (new OrderGoodsModel)->getOrderGoodsListByOrderIds($orderIds)->toArray();
        } catch (\Exception $e) {
            return false;
        }
        if (empty($orderGoodsList)) {
            return [];
        }
        $orderGoodsMap = [];
        foreach ($orderGoodsList as $orderGood) {
            if (isset($orderGood['order_id'])) {
                $orderGoodsMap[$orderGood['order_id']][] = $orderGood;
            }
        }
        $list = [];
        foreach ($orderList['data'] as $order) {
            $id = $order['order_id'];
            $title = implode(',', array_column($orderGoodsMap[$id], 'title'));
            $unitPrice = implode(',', array_column($orderGoodsMap[$id], 'price'));
            $orderStatusName = config("status.orderStatusName");
            $data = [
                'id' => $id,
                'create_time' => $order['create_time'],
                'mall_title' => $title,
                'count' => count($orderGoodsMap[$id]),
                'unit_price' => $unitPrice,
                'total_price' => $order['total_price'],
                'type' => $order['status'],
                'type_name' => $orderStatusName[$order['status']]
            ];
            $list[] = $data;
        }
        $res = [
            "total_page_num" => isset($orderList['last_page']) ? $orderList['last_page'] : 0,
            "count" => isset($orderList['total']) ? $orderList['total'] : 0,
            "page" => isset($orderList['current_page']) ? $orderList['current_page'] : 0,
            "page_size" => $pageSize,
            "list" => $list,
        ];
        return $res;
    }

    public function payOrder($condition, $data = []) {
        if (!is_array($data) || !$data) {
            return [];
        }
        $order = $this->model->getByCondition($condition)->toArray();
        if (empty($order)) {
            throw new \think\Exception("查不到此订单，请重新提交订单");
        }
        if (!empty($order) && $order[0]['pay_type'] > 0) {
            throw new \think\Exception("你身上的铜臭味太重，请不要重复付款");
        }
        $res = $this->model->update($data, $condition);
        if (!$res) {
            throw new \think\Exception("订单更新失败");
        }
        return $res;
    }
}