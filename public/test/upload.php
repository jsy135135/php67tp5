<?php

/**
 * @Author: jsy135135
 * @email:732677288@qq.com
 * @Date:   2018-07-22 14:48:19
 * @Last Modified by:   jsy135135
 * @Last Modified time: 2018-07-22 15:30:34
 */
require './randstr.php';
header('Content-Type:text/html;charset=utf8');
// $_post
// $_GET
var_dump($_FILES);die();
// 封装上传函数
function upload_file()
{
  // 1、移动文件到存储上传的目录
  // 1.txt 1.jpg 1.png
  // 获取上传的扩展名称
  $ext_array = explode('.', $_FILES['headimg']['name']);
  $file_ext = $ext_array[1];
  //定义上传目录
  $uploadDir = './img';
  // 判断如果上传目录不存在  就创建此目录
  if(!is_dir($uploadDir)){
    mkdir($uploadDir);
  }
  $newFilePath = $uploadDir.'/'.getRandStr().'.'.$file_ext;
  //移动保持
  $rs = move_uploaded_file($_FILES['headimg']['tmp_name'], $newFilePath);
  // var_dump($rs);
  if(!$rs){
    echo '上传失败!';
  }else{
    echo '上传成功!';
  }
}
// 调用方法
upload_file();