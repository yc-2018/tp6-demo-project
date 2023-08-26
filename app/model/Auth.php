<?php
//仰晨study 创建时间2023/8/27 1:08 星期日

namespace app\model;

use think\Model;

class Auth extends Model
{
    //多对多关联
    public function role()
    {
        return $this->belongsToMany(Role::class, Access::class, 'role_id', 'auth_id');
    }

    //name搜索器
    public function searchNameAttr($query, $value)
    {
        return $value ? $query->where('name','like' , '%'.$value.'%') : '';
    }
}