<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/19
 * Time: 18:25
 */

namespace app\admin\controller;
class Image extends AdminBase {
    public function upload() {
        // todo 1、判断图片类型 png gif jpg  2、文件大小限制
        if(!$this->request->isPost()) {
            return show(config("status.error"), "请求不合法");
        }
        $file = $this->request->file("file");
        // $filename = \think\facade\Filesystem::putFile('upload', $file);

        $filename = \think\facade\Filesystem::disk('public')->putFile("image",$file);

        if (!$filename) {
            return show(config("status.error"), "上传图片失败");
        }

        $imageUrl =  [
            "image" => "/upload/" . $filename
        ];

        return show(config("status.success"), "上传图片成功", $imageUrl);
    }

    public function layUpload() {
        if(!$this->request->isPost()) {
            return show(config("status.error"), "请求不合法");
        }

        $file = $this->request->file("file");
        $filename = \think\facade\Filesystem::disk('public')->putFile("image",$file);
        if (!$filename) {
            return json(["code" => 1, "data" => []], 200);
        }

        // todo 封装该格式，类似show方法
        $result = [
            "code" => 0,
            "data" => [
                "src" => "/upload/" . $filename,
            ],
        ];
        return json($result, 200);
    }
}