<?php
// 基础模型类
class Model2
{
    protected $pdo; //数据库连接对象
    protected $fields = array();    //字段列表
    // 定义属性，存储连接数据库基本信息
    private $host;
    private $user;
    private $password;
    private $dbname;
    private $port;
    private $options;
    private $dsn;
    private $opt;
    // 2.用于存储唯一的单例对象：
    private static  $_instance = null;
    // 1.私有化构造函数
    private function __construct()
    {
        $this->host = $GLOBALS['config']['host'];
        $this->user = $GLOBALS['config']['user'];
        $this->password = $GLOBALS['config']['password'];
        $this->dbname = $GLOBALS['config']['dbname'];
        $this->port = $GLOBALS['config']['port'];
        $this->options = $GLOBALS['config']['charset'];

        $this->dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname}";
        $this->opt= array(PDO::MYSQL_ATTR_INIT_COMMAND=>'set names '.$this->options);        // 类常量
        $this->pdo = new PDO($this->dsn,$this->user,$this->password,$this->opt);
    }
    // 3.私有化这个克隆的魔术方法
    private function __clone(){}
    // 4.创建静态方法
    static function Single()
    {
        // 控制好对象数量
        //if(!isset(self::$_instance)){       // 没有生产就生产一个，存储并返回
        if(!(self::$_instance instanceof  self)){       // 如果不是自己实例
            self::$_instance = new self();
        }
        return self::$_instance;     // 返回单例对象
    }

}