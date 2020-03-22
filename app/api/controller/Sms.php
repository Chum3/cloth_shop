<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/3/22
 * Time: 23:19
 */
declare(strict_types=1);
namespace app\api\controller;

use app\BaseController;

class Sms extends BaseController {

    public function code() :object {
        return show(config("status.success"),"OK");
    }
}