<?php
//仰晨study 创建时间2023/8/28 1:33 星期一

namespace app\controller;

use think\Request;

class Login
{
    public function index()
    {
        return view();
    }

    public function check(Request $request)
    {
        return json($request->param());
    }

}