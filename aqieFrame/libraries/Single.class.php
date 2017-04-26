<?php

/**
 * 保证一个类仅有一个实例
 * Class Single
 * 1.私有化构造方法
 * 2.防止克隆
 * 3.定义私有的静态变量，存储唯一的对象，并返回
 * 4.定义静态方法，判断是否需要实例化该唯一对象，并返回
 *
 */
class Single
{
    private function __construct(){}
    private function __clone(){}
    static private $instance = null;            //isset 判断null返回空
    static function GetObject()
    {
        // 控制好对象数量
        if(!isset(self::$instance)){       //没有生产就生产一个，存储并返回
            self::$instance = new self();     //静态属性 存储
        }
        return self::$instance;     //返回

    }
}