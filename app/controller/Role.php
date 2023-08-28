<?php
//仰晨study 创建时间2023/8/28 21:04 星期一

namespace app\controller;
use think\facade\Db;
use think\facade\View;

/**使用原生方式开发角色管理模块*/
class Role
{
    public function index()
    {
        //使用原生php模板引擎 再加载         如果不是直接写名字，那么相对路径在public里面开始
        View::engine('php')->fetch('../view/role/index.php',[
            'num'       =>      10,
            'admin'     =>      session('admin'),
            'list'      =>      Db::name('role')->select(),


        ]);




    }

}