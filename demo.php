<?php
/**
 * php简单测试
 */

/*
 * 最重要就是 删除引用的变量 ，只是引用的变量访问不了，
 * 但是内容并没有销毁
 * 在PHP 中引用的意思是：不同的名字访问同一个变量内容.
 */
$a = 'aqie';
$b = &$a;
echo $b;    // aqie
$b = 'aqie123'; // b相当于a变量别名
echo $a;    // aqie123

// 传址调用
//这里$b传递给函数的其实是$b的变量内容所处的内存地址，
//通过在函数里改变$a的值　就可以改变$b的值了
// 传递引用不能为常量
function call_by_reference(&$a){
    $a = $a+100;
    return $a;
}
$b = 1;
echo "<br>",call_by_reference($b),"<br>"; // 101

// 函数的引用返回
function &referencefunction(){
    static $b = 0;
    $b = $b+1;
    echo $b;
    return $b;
}
$a = referencefunction();  // 1   简单将函数值赋给变量a,a变化不会影响到函数内部变量b
$a = 5; $a = referencefunction(); // 2

// 将return $b中的　$b变量的内存地址与$a变量的内存地址　
//指向了同一个地方 即产生了相当于这样的效果($a=&b;)
// 改变a值也会改变b的值
$a = &referencefunction();  // 3
$a = 5; $a = &referencefunction(); // 6

// 对象的引用
class a{
    public $a = 'aqie';
}
$b = new a;
$c = $b;
echo $b->a; // aqie
echo $c->a; // aqie
$b->a = 'aqie123';
// 建立对象副本可以使用__clone()
echo $c->a; // aqie123

/*
 * 引用的作用
        如果程序比较大,引用同一个对象的变量比较多,并且希望用完该对象后手工清除它,
        个人建议用 "&" 方式,然后用$var=null的方式清除.
        其它时候还是用php5的默认方式吧. 另外, php5中对于大数组的传递,建议用 "&" 方式,
        毕竟节省内存空间使用。

取消引用
    当你 unset 一个引用，只是断开了变量名和变量内容之间的绑定。
    这并不意味着变量内容被销毁了。例如：
 */
$a = 1;
$b = &$a;
unset ($a);
echo $b;  // 1

echo floor((1+4)/2);    // 向下取整

$s = '12345';

$s[$s[1]] = '2';

echo "<br>",$s;
echo strtotime("now");
echo strtotime("now");
echo strrev("name"),'<br>';

$filename = 'f:/aqieframe/public/images/warn.name.png';
/**
 * 获取文件后缀
 * 函数的参数不能是对变量的引用，除非在php.ini中把allow_call_time_pass_reference设为on.
 * @param $file
 * @return mixed
 */
function get_name($file){
    // return strrchr($file, '.');         // .png
    // return substr($file, strrpos($file,'.')); // .png
    $end = explode(".",$file);
    return array_pop($end);
}
print_r(get_name($filename));

function get_name2($file){
    $p = pathinfo($file);
    return $p['extension'];
}
print_r(get_name2($filename));

function get_name3($file){
    return strrev(substr(strrev($file), 0, strpos(strrev($file), '.')));
}
print_r(get_name3($filename));

$ip = gethostbyname('www.csdn.net');
echo ip2long($ip),"<br>";

echo (Boolean)"false";      // 1
$a = '0';
$a = (Boolean)$a;
var_dump($a) ;  // false

echo intval(4.6);

$url = ' http://www.baidu.com/abc/123/index.php?id=1';
//用parse_url 解析url
$arr = parse_url($url);
echo '<pre>';
print_r($arr);
echo '</pre>';
//basename ,返回路径的文件名部分
$file = basename($arr['path']);
echo $file.'
';
//explode,字符串转成数组
$ext = explode(".",$file);
print_r($ext);
echo '
';
echo $ext[1];

echo date("Y-m=d H:i:s");
//sleep(3);
echo date("Y-m=d H:i:s");
include __DIR__."/cat.php";
$root = $_SERVER['DOCUMENT_ROOT'];
echo $root;

if(1){
    //trigger_error("年龄不符合要求",E_USER_ERROR);
}

$data = [
    [
        'uid' => '11',
        'da' => [
            [
                'title' => '姓名',
                'content' => '张三'
            ],
            [
                'title' => '姓名',
                'content' => '溜溜'
            ]
        ]
    ],
    [
        'uid' => '22',
        'da' => [
            [
                'title' => '姓名',
                'content' => '李四'
            ],
            [
                'title' => '姓名',
                'content' => '王五'
            ]
        ]
    ]
];
$a = "abc";
$abc = 4;
echo $$a;
var_dump($_COOKIE);

$var1 = 1;
$var2 = 2;
function test(){
    $GLOBALS['var2'] = &$GLOBALS['var1'];
}
test();
echo $var2;


$var1 = 1;
$var2 = 2;
function test2(){
    global $var1,$var2;
    $var2 = &$var1;
}
test2();
echo "var2:",$var2;

$var1 = 1;
$var2 = 2;
function test3(){
    global $var1,$var2;
    $var2 = &$var1;
}
test3();
echo "var1:",$var1,"var2:",$var2;


// 通过构造函数传递外部参数到类内部
$url ="www.baidu.com";
class test{
    public $url;        // 只能在类中，声明变量方法和属性直接在外部调用,global可以用在函数中
    function __construct($url = '')
    {
        $this->url = $url;
    }
    function showUrl(){
        echo "<br>".$this->url;
    }
}
$test = new test($url);
$test->showUrl();

$arr = [1,2,5,'name'=>'aqie'];
print_r(each($arr));
print_r(each($arr));
list($v1) = $arr;
list($s1,$s2,$s3) = $arr;
var_dump($s1,$s2,$s3);
//print_r($v1);

while(list($key,$value) = each($arr)){
    echo "<br>$key->$value";
}

$arr = [1,2,5,6];
echo "<hr>";
foreach ($arr as $key=> $value){    // 引用传递(键变量不能使用引用)
    unset($arr[$key]);
//    echo "<br>$key->$value";
}
print_r($arr);

$a = [1,2,5,6];
foreach ($a as $key=> &$value){
//                              // 循环中对数组修改,遍历不受影响
    echo "<br>$key->$value";
    if($key ===1){
        $a[6] = "新数据";
    }
}

echo '1' . (print '2') + 3;
print('2');

class aa{
    const PI = 3.14;
    static $count = 10;
    public $name = 'aqie';
}

class b extends aa{
    public function fo(){
        $count1 = parent::$count;
        echo $count1;
    }
    public function f1(){
        echo $this->name;
    }

}
$b = new b;
$b->fo();
$b->f1();
$a = null;
if(isset($a)){
    echo 222;
}else{
    echo 333;
}
class reload
    {
        public $p = 1;
        function __get($name)
        {
            echo "调用get方法";
            if(isset($this->prop_list[$name])){
                return $this->prop_list[$name];
            }else{
                return "该属性不存在";
            }
        }
        // 用来存储不存在属性
        protected $prop_list = array();
        function __set($name, $value)       // 配合__get()添加属性
        {
            echo "调用set方法";
            $this->prop_list[$name] = $value;
        }

        function __isset($name)
        {
            echo "调用isset方法";
            $v = isset($this->prop_list[$name]);
            return $v;
        }
        function __unset($name)
        {
            unset($this->prop_list[$name]);         // 销毁属性列表某个单元
        }
    }
    $a = new reload;
    echo $a->p2=3;
    var_dump(isset($a->p2));
    //echo $a->bbbb;
    echo $a->u222;

class phpReload{
    function __call($name, $arguments)       //调用不存在方法会自动调用
    {
        if($name === 'f1'){
            $len = count($arguments);
            if($len < 1 || $len >3){
                trigger_error("传参数量错误",E_USER_ERROR);
            }elseif ($len===1){
                return $arguments[0];
            }elseif ($len ===2){
                return $arguments[0]*$arguments[0]+$arguments[1]*$arguments[1];
            }else{
                $v1 = $arguments[0];
                $v2 = $arguments[1];
                $v3 = $arguments[2];
                return $v1*$v1*$v1+$v2*$v2*$v2+$v3*$v3*$v3;
            }
        }
    }
}
$obj = new phpReload();
echo $obj->f1(1);
echo $obj->f1(1,2);
echo $obj->f1(1,2,3);

/**
 * Class aqie
 * 1.在静态方法中调用类普通属性   （静态方法不能调用非静态属性）
 * 2.
 */
class aqie{
    static public $myname;
    function __construct($name)
    {
        self::$myname = $name;
    }
    static public function sinfo(){
        echo self::$myname;
    }

}
$obj = new aqie('aqie');
$obj->sinfo();

$arr = ['name'=>"aqie",'age'=>24];  $obj = (object)$arr;
var_dump($obj->name);


class C{} ;      // 类
interface USB{} ;    // 接口
class D implements  USB{}  ; // 类实例了接口USB
function restraint($p, array $p1,C $p2,USB $p3)
{
    echo "<br> 无约束 $p";
    echo "<br> 要求是数组 p1";
    print_r($p1);
    echo "<br> 要求是类C对象 p2：";
    var_dump($p2);
    echo "<br> 要求是实现接口USB的对象 p:3";
    var_dump($p3);
}
$obj1 = new C();
$obj2 = new D();
$arr = array(1,2,3);
/**/

restraint(11,$arr,$obj1,$obj2);
$v = array(1,24,3,"b"); $s = serialize($v); file_put_contents("./serialization.txt",$s);
$s = file_get_contents("./serialization.txt");     // 文本文件读出所有字符
$v = unserialize($s);     //字符串数据反序列化转化为字符串
var_dump($v);

/********对象序列化**********/
class AAAA{};
$obj = new AAAA;
$obj->p1 = 1;
$obj->p2 = 22;

$s1 = serialize($obj);
file_put_contents("./A.class.txt",$s1);

$s2 =  file_get_contents("./A.class.txt");
$obj2 = unserialize($s2);
var_dump($obj2);

/**
 * 给私有属性赋值
 * Class aaa
 */
class aaa{

    private $_b='';
    function __set($property,$value){
        $this->$property = $value;
    }
    function __get($property){
        return $this->$property;
    }
}
$a=new aaa();
$a->b='test';
echo $a->b;

/**
 * 给私有属性赋值2
 * Class ab
 */
class ab
{
    private $_b='';

    public function set_b($b)
    {
        $this->_b=$b;
    }
}

$a=new ab();
$a->set_b('test');



class cc{
    public $p1 = 1;
    protected $p2 = 2;
    private $p3 = 3;
    static $p4 = 4;     // 静态属性不可遍历
    public $p5 = 5;     // 如果没有序列化，打印出来是对象所属类的数据

    function f1(){
        echo "<br>f1方法被调用";
    }
    public function showAllProperties()
    {
        foreach ($this as $key =>$value){       // 只有公共变量才遍历出来
            echo "<br> 属性$key :$value";
        }
    }

    function __sleep()
    {
        // TODO: Implement __sleep() method.
        echo "<br>要进行序列化了";
        // 指定序列化
        return array('p1','p2');
    }

    function __wakeup()
    {
        // TODO: Implement __wakeup() method.
        echo "<br>要进行反序列化了";
    }

}

class Bd{
    public $name;
    public $sex;
    function __construct($name,$sex)
    {
        $this->name = $name;
        $this->sex = $sex;
    }
    function __toString()
    {
        // TODO: Implement __toString() method.
        $str = "姓名:".$this->name;
        $str .= ",性别:".$this->sex;
        return $str;
    }

    function __invoke()
    {
        // TODO: Implement __invoke() method.
        echo "<br>我是对象B";
    }

    function MagicMethods()
    {
        echo "<br> __DIR__:".__DIR__;
        echo "<br> __FILE__:".__FILE__;
        echo "<br> __LINE_:".__LINE__;
        echo "<br> __METHOD__:".__METHOD__;
        echo "<br> __CLASS__:".__CLASS__;
        echo "<br> __LINE__:".__LINE__;
    }
}

