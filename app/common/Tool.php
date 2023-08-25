<?php
//仰晨study 创建时间2023/8/26 2:19 星期六

namespace app\common;

class Tool
{

    /**
     * 拼接url参数和去除URL重复参数
     * @param $querystring
     * @return string|void
     */
    public static function url($querystring)
    {
        $urlFull = request()->url(true);                //拿到完整的URL地址

        if (!isset(parse_url($urlFull)['query'])) {     //如果url没有参数的话
            return $urlFull . '?';
        }
        $query = parse_url($urlFull)['query'];          //url的参数拿出来

        parse_str($query,$urlArr);              //把参数转为数组urlArr中

        unset($urlArr[$querystring]);                   //删除不要的参数

        $queryAll = http_build_query($urlArr);          //把数组重新拼接为参数

        echo request()->domain() . request()->baseUrl() . '?' . $queryAll . '&';



    }


}