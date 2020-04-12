<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/11
 * Time: 20:27
 */

namespace app\admin\validate;

use think\Validate;

class Category extends Validate {
    protected $rule = [
        'name' => 'require',
        'pid' => 'require',
    ];

    protected $message = [
        'name' => '分类名必须',
        'pid' => '父类ID必须',
    ];
}