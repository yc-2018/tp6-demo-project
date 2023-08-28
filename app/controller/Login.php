<?php
//仰晨study 创建时间2023/8/28 1:33 星期一

namespace app\controller;

use think\facade\Validate;
use think\Request;

class Login
{

    /**
     * 提示模板路径
     * @var string
     */
    private $toast = 'public/toast';


    public function index()
    {
        return view();
    }

    public function check(Request $request)
    {
        //错误集合
        $errors = [];

        $data = $request->param();

        //验证规则
        $validate = Validate::rule([
            'name' => 'unique:auth,name^password'   //name字段在auth数据表中唯一,并排除与当前记录相同的name和password组合。
        ]);

        //检查规则
        $result = $validate->check([
            'name' => $data['name'],
            'password' => sha1($data['password'])
        ]);

        //错误提示，方向操作
        //如果如果用户名和密码对比同时存在，那其实是正确的
        if ($result) {
           $errors[] = '用户名或密码错误';
        }

        //验证码助手函数 判断
        if (!captcha_check($data['code'])) {
            $errors[] = '验证码错误';
        }

        if (!empty($errors)) {
            return view($this->toast,[
                'infos'         =>       $errors,
                'url_text'      =>      '返回登录',
                'url_path'      =>      url('/login')
            ]);
        } else {
            session('name', $data['name']);
            return redirect('/');
        }

    }

}