<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/5/2
 * Time: 22:16
 */

namespace app\api\controller\mall;

use app\api\controller\AuthBase;
use app\common\business\Cart;
use app\common\lib\Show;

class Init extends AuthBase {
    public function index() {
        if (!$this->request->isPost()) {
            return Show::error();
        }

        $count = (new Cart())->getCount($this->userId);
        $result = [
            "cart_num" => $count,
        ];
        return Show::success($result);

    }
}