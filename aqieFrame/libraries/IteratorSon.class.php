<?php
/**
 *
PHP5开始支持了接口， 并且内置了Iterator接口， 所以如果你定义了一个类，并实现了Iterator接口，
那么你的这个类对象就是ZEND_ITER_OBJECT,否则就是ZEND_ITER_PLAIN_OBJECT.

对于ZEND_ITER_PLAIN_OBJECT的类，foreach会通过HASH_OF获取该对象的默认属性数组，然后对该数组进行foreach.

而对于ZEND_ITER_OBJECT的类对象，则会通过调用对象实现的Iterator接口相关函数来进行foreach。
利用PHP的迭代器可以利用面向对象实现常见的数据结构，例如列表，堆栈，队列与图
 */
class IteratorSon implements Iterator{
    private $_item ;
    public function __construct(&$data) {
        $this->_item = $data;
    }
    public function rewind(){
        reset($this->_item);
    }

    public function current(){
        return current($this->_item);
    }

    public function key(){
        return key($this->_item);
    }

    public function next(){
        return next($this->_item);
    }

    public function valid(){
        return($this->current()!==false);
    }
}