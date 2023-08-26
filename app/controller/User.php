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
     * 提示模板路径
     * @var string
     */
    private $toast = 'public/toast';

    /**
     * 显示资源列表
     */
    public function index()
    {
        return view('index',[
            'list' => UserModel::withSearch(['gender','username','email','create_time'],[
                'gender'        =>      request()->param('gender'),
                'username'      =>      request()->param('username'),
                'email'         =>      request()->param('email'),
                'create_time'   =>      request()->param('create_time'),
            ])->paginate([
                'list_rows'  =>     5,                  //分页数
                'query'      =>     request()->param()   //保存传递的参数
            ]),
            'orderTime'      =>     request()->param('create_time')=='desc'?'asc':'desc',

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
            return view($this->toast,[
                'infos'         =>       $exception->getError(),
                'url_text'      =>      '返回上一页',
                'url_path'      =>      url('/user/create')
            ]);
        }

        $data['password'] = sha1($data['password']);    //加密密码
        //写入数据库 后 返回id
        $id = UserModel::create($data)->getData('id');

        return $id ? view($this->toast,[
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
     * @return string|\think\response\View
     */
    public function update(Request $request, $id)
    {

        $data = $request->param();
        try {
            validate(UserValidate::class)
                            ->scene('edit')
                            ->batch(true)
                            ->check($data);
        } catch (ValidateException $exception) {
            return view($this->toast,[
                'infos'         =>       $exception->getError(),
                'url_text'      =>      '返回上一页',
                'url_path'      =>      url('/user/'.$id.'/edit')
            ]);
        }


        if (!empty($data['newpasswordnot'])) {
            $data['password'] = sha1($data['newpasswordnot']);
        }

//        dd($data);

     return UserModel::update($data) ? view($this->toast,[
         'infos'         =>       ['恭喜,修改成功'],
         'url_text'      =>      '回到首页',
         'url_path'      =>      url('/')
     ]):'修改失败!';
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id

     */
    public function delete($id)
    {
        //
        return UserModel::destroy($id)?view($this->toast,[
            'infos'         =>       ['恭喜,删除成功'],
            'url_text'      =>      '回到首页',
            'url_path'      =>      url('/')
        ]):'删除失败!';
    }
}
