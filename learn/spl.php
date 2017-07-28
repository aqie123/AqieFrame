<?php
//双向链表
echo "<pre>";
// push 添加顶部 ，unshift 添加到底部
$obj = new SplDoublyLinkedList();
$obj->push(1);
$obj->push(3);
$obj->push("aqie");
$obj->unshift(5);
print_r($obj);
$obj->rewind(); // 把当前节点指针执行bottom(第一个)所在节点
echo'current'.$obj->current()."\n";  // 获取当前指针指向节点

$obj->next();
echo 'next node:'.$obj->current();  // 下一个节点
$obj->next();$obj->next();$obj->next();
if($obj->valid()){ // 当前节点是有效节点
    echo "valid list\n";
}else{
    echo "invalid list\n";
    echo "pop value：".$obj->pop();
    print_r($obj);
}

// 堆栈 (先进后出)
/*
push (压入堆栈) pop(退出)
*/
$stack = new SplStack();
$stack->push("a");
$stack->push("b");
$stack->push("c");
print_r($stack);
echo $stack->bottom();
$stack->offsetSet(0,'d'); // 对下标 0赋值 0对应的是top
print_r($stack);
$stack->rewind();  // 重置
echo 'current:'.$stack->current();
$stack->next();   // 这里是往上走
echo 'current:'.$stack->current();

// 便利堆栈
$stack->rewind();
while($stack->valid()){
    echo $stack->key()."=>".$stack->current()."\n";
    $stack->next();
}
// 删除堆栈
$popObj = $stack->pop();  // 删除的最上面的元素
echo "PopObj:".$popObj."\n";
print_r($stack);

//队列 (先进先出) enqueue（进入队列）dequeue(推出对列)
$obj = new SplQueue();
$obj->enqueue('a');
$obj->enqueue('b');
$obj->enqueue('c');
print_r($obj);
echo "队列bottom:".$obj->bottom();
echo "队列top:".$obj->top();
$obj->offsetSet(0,'A'); // 从底部来时
print_r($obj);
$obj->rewind();  //指针指向bottom
echo "current:".$obj->current();
while($obj->valid()){
    echo $obj->key()."=>".$obj->current()."\n";
    $obj->next();
}
echo "dequeue obj:".$obj->dequeue()."\n"; // 删除的是bottom
print_r($obj);

//迭代器 Iterator接口定义事务
// 也可以排序  seek跳过元素

$fruits = array(
    "apple" => 'apple value',
    'orange' => 'orange value',
    'banana' => 'banana value',
    'grape' => 'grape value'
);
foreach($fruits as $key => $value) {
    echo $key . " : ".$value."\n";
}
//  ArrayIterator用于遍历数组 (foreach  循环实现机理)
$obj = new ArrayObject($fruits);
$items = $obj->getIterator(); // 生成数组的迭代器
foreach ($items as $key => $value) {
    echo $key . " : ".$value."\n";
}

// 必须执行rewind
$items->rewind();
while($items->valid()){
    echo $items->key() . ":" .$items->current()."\n";
    $items->next();
}

// 跳过某些元素打印
echo '<hr>';
$items->rewind();
if($items->valid()){       // 增强程序健壮性
    $items->seek(1);
    while($items->valid()){
        echo $items->key() . ":" .$items->current()."\n";
        $items->next();
    }
}

// 排序
$items->ksort();  // 根据key排序 asort根据value排序
foreach($items as $key => $v){
    echo $key . ":" .$v."\n";
}

// AppendIterator 能陆续遍历几个迭代器 按顺序访问几个不同迭代器
$arr_a = new ArrayIterator(array('a','b','c'));
$arr_b = new ArrayIterator(array('d','e','f'));
$arr_c = new ArrayIterator(array('g','h','i'));
$items = new AppendIterator();
$items->append($arr_a);
$items->append($arr_b);
$items->append($arr_c);
foreach ($items as $key => $value){
    echo $value."\n";
}

// MultipleIterator 把多个Iterator 里面数据组合成一个整体来访问
$id = new ArrayIterator(array('01','02','03'));
$name = new ArrayIterator(array('张三','李四','王五'));
$items = new MultipleIterator(MultipleIterator::MIT_KEYS_ASSOC);
$items->attachIterator($id,"ID");
$items->attachIterator($name,"name");
foreach ($items as $key => $value){
    print_r($value);
}

 // FilesystemIterator 遍历文件系统
date_default_timezone_set('PRC');
 $it = new FilesystemIterator('.');
 foreach ($it as $file_info){
     printf("%s\t%s\t%8s\t%s\n",
         date("Y-m-d H:i:s",$file_info->getMtime()),
        $file_info->isDir() ? "目录" : "",
            number_format($file_info->getSize()),
            $file_info->getFileName()
     );
 }

// spl函数使用  四个接口
//   Countable 继承该接口类直接通过count获得元素个数

$arr = array(
    array('name' => 'John','id' => '5'),
    array('name' => 'Tom','id' => '6'),
);
echo count($arr)."\n";
echo count($arr[1])."\n";
class CountMe implements Countable {
    protected $_myCount = 3;
    public function count(){
        return $this->_myCount;
    }
}
$obj = new CountMe();
echo count($obj);

//   OuterIterator    对迭代器进行处理再返回
class OuterImpl extends IteratorIterator{
    public function current(){
        return parent::current()."_tail";
    }
    public function key(){
        return "Pre_".parent::key();
    }
}
$arr = ['value1','value2','value3'];
$outerObj = new OuterImpl(new ArrayIterator($arr));
foreach ($outerObj as $key => $value){
    echo $key ."=>" .$value."\n";
}

//   RecursiveIterator   多层结构迭代器进行迭代 比如遍历树(文件夹)
// hasChildren() getChildRen()

//  SeekableIterator    通过seek 方法定位到集合里面某个特定元素
/*
spl_autoload_extensions('.class.php,.php');
set_include_path(get_include_path().PATH_SEPARATOR."../libs/");
spl_autoload_register();  // 自动加载类文件
new Test();
*/

// 另一种加载  或者自定义加载函数myload  然后注册 spl_autoload_register('myload');
/*
function __autoload($class_name){
    echo "加载的类文件".$class_name."\n";
    require_once ("../libs/".$class_name.'.php');
}
new Test();
*/

// 自定义加载函数
function myload($classname){
    echo "加载的类文件".$classname."\n";
    set_include_path("../libs/");
    spl_autoload($classname);  // 不用require载入文件类时,必需载入类名
}
spl_autoload_register('myload');
new Test();

//迭代器先关函数
//iterator_apply() 为迭代器中每个元素调用用户自定义函数
//iterator_count() 计算迭代器中元素个数
//iterator_to_array() 迭代器中的元素拷贝到数组
//class_implements() 返回指定类实现的所有接口
//class_parents() 返回指定类的父类

// 文件处理类库
//SplFileInfo 用于获得稳健基本信息 (修改时间，大小,目录)
$file = new SplFileInfo("spl.php");
echo date("Y-m-d H:i:s",$file->getCTime())."\n";
echo date("Y-m-d H:i:s",$file->getMTime())."\n";
echo $file->getsize()."\n";
// 读取文件内容
$fileObj = $file->openFile("r");
while($fileObj->valid()){
    echo $fileObj->fgets();
}
$fileObj = null; // 用于关闭打开文件
$file = null;  //
