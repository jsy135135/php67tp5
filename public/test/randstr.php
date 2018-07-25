<?php

/**
 * @Author: jsy135135
 * @email:732677288@qq.com
 * @Date:   2018-07-22 15:16:43
 * @Last Modified by:   jsy135135
 * @Last Modified time: 2018-07-22 15:25:09
 */
function getRandStr($length=16)
{
  // 1、输出范围
  $str = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  // echo $str[2],$str[10],$str[36],$str[50];
  // 2、随机一个字符串
  // 循环取多次
  // 0-15
  $strs = '';
  for ($i=0; $i < $length; $i++) {
    // 随机一个数字
    // 通过数字的下标取字符串
    $rand = rand(0,strlen($str)-1);
    $strs .= $str[$rand];
  }
  return $strs;
}
