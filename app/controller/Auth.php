<?php
declare (strict_types = 1);
namespace app\controller;
use app\model\Auth as AuthModel;
use app\model\Role as RoleModel;
use think\Request;
use think\Response;

class Auth
{
    /**
     * 提示模板路径
     * @var string
     */
    private $toast = 'public/toast';


    /**
     * 显示资源列表
     *
     * @return Response
     */
    public function index()
    {
        $list = AuthModel::with(['role'])
                ->withSearch(['name'],['name'=> request()->param('name')])
                ->paginate([
                            'list_rows'  =>     5,                    //分页数
                            'query'      =>     request()->param()   //保存传递的参数
                ]);

        //把关联表权限拿出来拼接
        foreach ($list as $key => $obj) {
            foreach ($obj->role as $r) {
                $obj->roles .= $r->type . ' | ';
            }
            $obj->roles = trim(substr(trim($obj->roles), 0, -1));   //把最后的| 去掉
        }


//        return json($list);

        return view('index',[
            'list' =>   $list

        ]);


    }

    /**
     * 显示创建资源表单页.
     *
     * @return Response
     */
    public function create()
    {
        return view('create',[
            'list' => RoleModel::select(),

        ]);
    }

    /**
     * 保存新建的资源
     *
     * @param Request $request
     * @return string|Response
     */
    public function save(Request $request)
    {
//        return json($request->param());
        $data = $request->param();

        //TODO:验证暂时先不搞：管理员名>2..pwd>6..

        //加密密码
        $data['password'] = sha1($data['password']);
        //写入数据库 后 返回id
        $id = AuthModel::create($data)->getData('id');

        //关联保存
        AuthModel::find($id)->role()->saveAll($data['role']);

        return $id ? view($this->toast,[
            'infos'         =>       ['恭喜,添加成功'],
            'url_text'      =>      '回到管理页',
            'url_path'      =>      url('/auth')
        ]):'添加失败!';
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
        //
    }
}
