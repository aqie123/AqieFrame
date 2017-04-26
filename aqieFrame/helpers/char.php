<?php
/**
 * 输入数字转换成汉字
 * @param $arrs
 * @return mixed
 * $array=explode(separator,$string);   // 字符串变数组
    $string=implode(glue,$array);       // 数组转换字符串
 */
function numChange($arrs){
    $exts = array(
        0 =>'零',
        1 =>'一',
        2 =>'二',
        3=>'三',
        4=>'四',
        5=>'五',
        6=>'六',
        7=>'七',
        8=>'八',
        9=>'九',
    );
    foreach ($arrs as $key=>$arr){
        $arrs[$key] =$exts[$arr];
    }
    return $arrs;
}