<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');

//后台组
Route::group(function () {
    //用户路由模块
    Route::resource('user', 'User');
    //权限模块路由模块
    Route::resource('auth', 'Auth');

})->middleware(function ($request, Closure $next) {
    if (!session('?admin')) {
        return redirect('/login');
    }
    return $next($request);
});


//登录模块路由
Route::group(function () {
    Route::get('login',        'Login/index');
    Route::post('login_check', 'Login/Check');
});
