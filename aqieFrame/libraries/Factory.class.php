<?php

/**
 * 工厂类
 * Class Factory
 */
class Factory
{
    static function GetObject($className){
        $obj = new $className();    // 可变类
        return $obj;
    }
}