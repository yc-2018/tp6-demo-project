<?php
//仰晨study 创建时间2023/8/23 12:45 星期三

namespace app\model;

use think\Model;

class User extends Model
{

    //一对一hobby
    public function hobby()
    {
        return $this->hasOne(Hobby::class, 'user_id', 'id');
    }

    //gender搜索器
    public function searchGenderAttr($query, $value)
    {
        return $value ? $query->where('gender', $value) : '';
    }

    //username搜索器
    public function searchUsernameAttr($query, $value)
    {
        return $value ? $query->where('username','like' , '%'.$value.'%') : '';
    }

    //email搜索器
    public function searchEmailAttr($query, $value)
    {
        return $value ? $query->where('email','like' , '%'.$value.'%') : '';
    }


    //create_time搜索器
    public function searchCreateTimeAttr($query, $value)
    {
        return $value ? $query->order('create_time', $value):'';
    }



    //status获取器
    public function getStatusAttr($value)
    {
        $status = [0 => '待审核', 1 => '通过'];
        return $status[$value];
    }

    //badge获取器（虚拟字段)
    public function getBadgeAttr($value, $data)
    {
        return $data['status'] ? 'success' : 'warning';
    }



}