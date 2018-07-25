<?php

/**
 * @Author: jsy135135
 * @email:732677288@qq.com
 * @Date:   2018-07-21 09:56:52
 * @Last Modified by:   jsy135135
 * @Last Modified time: 2018-07-21 11:00:34
 */
$name = $_REQUEST['name'];
// var_dump($name);
$mysqli = new Mysqli('127.0.0.1','root','root','php');
$mysqli->query('set names utf8');
$sql = "insert into name values(null,'$name')";
$rs = $mysqli->query($sql);
// var_dump($rs);
// 以json格式返回
if($rs){
  // 状态值为1成功
  echo json_encode(['status' => 1,'msg' => '添加成功']);
}else{
  // 状态值为0失败
  echo json_encode(['status' => 0,'msg' => '添加失败']);
}