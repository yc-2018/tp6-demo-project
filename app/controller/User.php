<?php
declare (strict_types = 1);
namespace app\controller;
use think\exception\ValidateException;
use think\Request;
use app\model\User as UserModel;
use app\validate\User as UserValidate;
class User
{
    /**
     * 显示资源列表
     */
    public function index()
    {
        return view('index',[
            'list' => UserModel::withSearch(['gender','username','email'],[
                'gender'        =>      request()->param('gender'),
                'username'      =>      request()->param('username'),
                'email'         =>      request()->param('email'),
            ])->paginate([
                'list_rows'  =>  5,                  //分页数
                'query'     =>  request()->param()   //保存传递的参数
            ]),
        ]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
        return view();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return string|\think\Response
     */
    public function save(Request $request)
    {
//        dd($request->param());

        $data = $request->param();
        try {
            validate(UserValidate::class)->batch(true)->check($data);
        } catch (ValidateException $exception) {
            return view('/public/toast',[
                'infos'         =>       $exception->getError(),
                'url_text'      =>      '返回上一页',
                'url_path'      =>      url('/user/create')
            ]);
        }

        $data['password'] = sha1($data['password']);    //加密密码
        //写入数据库 后 返回id
        $id = UserModel::create($data)->getData('id');

        return $id ? view('/public/toast',[
            'infos'         =>       ['恭喜,注册成功'],
            'url_text'      =>      '回到首页',
            'url_path'      =>      url('/')
        ]):'注册失败!';

    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
        return view('edit',[
            'obj' => UserModel::find($id),
        ]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return string
     */
    public function update(Request $request, $id)
    {
        //TODO: 还没有在view/user/index.html写好
        return '修改' . $id;
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id

     */
    public function delete($id)
    {
        //
        return UserModel::destroy($id)?view('/public/toast',[
            'infos'         =>       ['恭喜,删除成功'],
            'url_text'      =>      '回到首页',
            'url_path'      =>      url('/')
        ]):'删除失败!';
    }
}
