<?php
/**
 * 单例工厂类
 * 可以传来一个模型类的类名
 * 返回给类一个实例(对象),保证其为单例的
 * $user = SingleModelFactory::M('UserModel');
 */
class SingleModelFactory
{
    static $all_model = array();
    static function M($ModelName)
    {
        // 数组中这项如果不是类的实例，就new,是的话就直接返回
        if(!isset(static::$all_model[$ModelName]) ||
            !(static::$all_model[$ModelName] instanceof $ModelName)){
            static::$all_model[$ModelName] =  new $ModelName();
        }
        return static::$all_model[$ModelName];
    }
}