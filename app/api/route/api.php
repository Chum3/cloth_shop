<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/3/22
 * Time: 23:14
 */

use think\facade\Route;

Route::rule("smscode","sms/code","POST");
Route::resource('user','User');
