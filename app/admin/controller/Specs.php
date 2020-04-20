<?php
/**
 * Created by Edmund.
 * Motto: 加油，凤凰苑 (๑❛ᴗ❛๑)
 * Date: 2020/4/18
 * Time: 23:30
 */

namespace app\admin\controller;
class Specs extends AdminBase {
    public function dialog() {
        return view("",[
            "specs" => json_encode(config("specs"))
        ]);
    }
}