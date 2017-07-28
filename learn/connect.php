<?php
// 1.将timestamp,nonce.token字典排序
$timestamp = $_GET['timestamp'];
$nonce = $_GET['nonce'];
$token = 'weixin';
$signature = $_GET['signature'];
$array = array($timestamp,$nonce,$token);
sort($array);
// 2.排序后三个参数拼接使用sha1加密
$tmpstr = implode('',$array);
$tmpstr = sha1($tmpstr);

//3.加密后字符串与signature进行对比，判断请求是否来自微信
if($tmpstr == $signature){
    echo $_GET['echostr'];
    exit;
}