<?php
namespace app;

// 应用请求对象类
class Request extends \think\Request
{
    protected $filter = ['trim'];   //去掉空格等
}
