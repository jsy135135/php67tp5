<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
  function myRequest($url=null,$https=false,$method='get',$data=null)
  {
    // 1、curl_init初始化
    $ch = curl_init($url);
    // 2、curl_setopt 设置参数
    // 默认返回,不直接输出
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    // 支持http https
    if($https === true){
      // 支持https
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    // 支持get和post请求方式
    if($method === 'post'){
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    // 3、curl_exec 执行请求
    $content = curl_exec($ch);
    // 4、curl_close 关闭资源
    curl_close($ch);
    return $content;
  }