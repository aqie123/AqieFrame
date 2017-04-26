<?php
/**
 * 1.实现给类中不存在属性可以赋值，调用__set(方法)存到数组,调用__get(方法)返回读取到值
 * 2.直接输出不存在属性，会走else : 报属性不存在
 * Class reload
 */
class reload
{
    function __get($name)
    {
        if(isset($this->prop_list[$name])){
            return $this->prop_list[$name];
        }else{
            return "aqie:该属性不存在";
        }
    }
    // 用来存储不存在属性
    protected $prop_list = array();
    function __set($name, $value)       // 配合__get()添加属性
    {
        echo "aqie:您给不存在属性赋值了";
        $this->prop_list[$name] = $value;
    }

    function __isset($name)
    {
        $v = isset($this->prop_list[$name]);
        return $v;
    }
    function __unset($name)
    {
        unset($this->prop_list[$name]);         // 销毁属性列表某个单元
    }
}