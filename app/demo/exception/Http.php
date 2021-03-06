<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/2/29
 * Time: 22:20
 */

namespace app\demo\exception;
use think\exception\Handle;
use think\Response;
use Throwable;

class Http extends Handle {
    public $httpStatus = 500;
    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        if(method_exists($e, "getStatusCode")){
            $httpStatus = $e->getStatusCode();
        } else {
            $httpStatus = $this->httpStatus;
        }
        // 添加自定义异常处理机制
        return show(config("status.error"), $e->getMessage(), [], $httpStatus);
        // 其他错误交给系统处理
        //return parent::render($request, $e);
    }
}