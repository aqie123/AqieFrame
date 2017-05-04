1.ORM：对象关系映射(Object Relational Mapping)
    实现面向对象编程语言里不同类型系统的数据之间的转换.

/*+====================================================================
                        区别
======================================================================*/
1.include和require的区别
    require:出现错误后直接终止退出，程序不再执行
            require通常放在PHP程序的最前面
    include:包含一个不存在的文件，会提示警告程序会继续执行
            include一般是放在流程控制的处理部分中PHP程序网页在读到include的文件时
    include有返回值，而require没有
2.self this
    this是指向当前对象的指针(姑且用C里面的指针来看吧),
    self是指向当前类的指针,
    parent是指向父类的指针
3.array+array与array_merge()的区别
    二者之间的区别是：
    1 键名为数字时，array_merge()不会覆盖掉原来的值，但＋合并数组则会把最先出现的值作为最终结果返回，而把后面的数组拥有相同键名的那些值“抛弃”掉（不是覆盖）
    2 键名为字符时，＋仍然把最先出现的值作为最终结果返回，而把后面的数组拥有相同键名的那些值“抛弃”掉，但array_merge()此时会覆盖掉前面相同键名的值
4.
    isset 若变量不存在则返回 FALSE.若变量存在且其值为NULL，也返回 FALSE
    empty 若变量不存在则返回 TRUE
            若变量存在且其值为""、0、"0"、NULL、、FALSE、array()、var $var; 以及没有任何属性的对象，则返回 TURE
            若变量存在且值不为""、0、"0"、NULL、、FALSE、array()、var $var; 以及没有任何属性的对象，则返回 FALSE
5. static
    也可以像self一样，代表当前类，用于访问一个类的静态属性或静态方法
    但static更灵活
    代表调用当前方法类，不是代码所在类
    self只代表本身所在位置类  （存在继承就会出问题）

/*+====================================================================
                          网站性能
======================================================================*/
1.加载页面访问速度
    1，用到服务器资源时在打开，不用时，立即关闭服务器资源。
    2，数据库添加索引
    3，页面可生成静态
    4，图片等大文件单独放在一个服务器
    5，能不查询数据库的尽量不去数据取数据，可以放在缓存中
2.大流量网站
    确认服务器硬件是否能够支持当前的流量
    数据库读写分离，优化数据表
    程序功能规则，禁止外部的盗链
    控制大文件的下载
    使用不同主机分流主要流量



/*+====================================================================
                            网络编程
======================================================================*/
1.常见的HTTP状态码
    200 - 请求成功
    301 - 资源(网页等)被永久转义到其他URL
    404 - 请求的资源(网页等)不存在
    505 - 内部服务器错误
2.页面跳转
    header("Location:网址");//直接跳转
    header("refresh:3;url=http://axgle.za.NET");//三秒后跳转
    echo"<meta http-equiv=refresh content='0;url=网址'>";
3.Tcp协议的三次握手过程
    TCP是主机对主机层的传输控制协议，提供可靠的连接服务，采用三次握手确认建立一个连接：
    第一次握手：建立连接时，客户端发送syn包(syn=j)到服务器，并进入SYN_SEND状态，等待服务器确认；
    第二次握手：服务器收到syn包，必须确认客户的SYN（ack=j+1），同时自己也发送一个SYN包（syn=k），即SYN+ACK包，此时服务器进入SYN_RECV状态；
    第三次握手：客户端收到服务器的SYN＋ACK包，向服务器发送确认包ACK(ack=k+1)，此包发送完毕，客户端和服务器进入ESTABLISHED状态，完成三次握手。
    完成三次握手，客户端与服务器开始传送数据。
/*+====================================================================
                            php安全
======================================================================*/
1.PHP网站的主要攻击方式
    命令注入(Command Injection)
    eval 注入(Eval Injection)
    客户端脚本攻击(Script Insertion)
    跨网站脚本攻击(Cross Site Scripting, XSS)
    SQL 注入攻击(SQL injection)
    跨网站请求伪造攻击(Cross Site Request
    Forgeries, CSRF)
    Session 会话劫持(Session Hijacking)
    Session 固定攻击(Session Fixation)
    HTTP 响应拆分攻击(HTTP Response Splitting)
    文件上传漏洞(File Upload Attack)
    目录穿越漏洞(Directory Traversal)
    远程文件包含攻击(Remote Inclusion)
    动态函数注入攻击(Dynamic Variable
    Evaluation)
    URL 攻击(URL attack)
    表单提交欺骗攻击(Spoofed Form
    Submissions)
    HTTP 请求欺骗攻击(Spoofed HTTP Requests)
2.

/*+====================================================================
                             数据库(mysql nosql)
 ======================================================================*/
1.数据库优化
    选取最适用的字段属性，尽可能减少定义字段宽度，尽量把字段设置NOTNULL，例如'省份'、'性别'最好适用ENUM
    使用连接(JOIN)来代替子查询
    适用联合(UNION)来代替手动创建的临时表
    事务处理
    锁定表、优化事务处理
    适用外键，优化锁定表
    建立索引
    优化查询语句
2.Memcache 缓存
    1.数据保存在内存当中，采用 hash 表的方式，每条数据由 key 和 value 组成
3.MyISAM和InnoDB的区别
    1.InnoDB存储引擎
        a.行锁设计、支持外键
    2.MyISAM存储引擎
        a.不支持事务，支持表所和全文索引。操作速度快；
4.MySQL外连接、内连接与自连接的区别
    交叉连接: 交叉连接又叫笛卡尔积，它是指不使用任何条件，直接将一个表的所有记录和另一个表中的所有记录一一匹配。

    内连接 则是只有条件的交叉连接，根据某个条件筛选出符合条件的记录，不符合条件的记录不会出现在结果集中，即内连接只连接匹配的行。
    外连接 其结果集中不仅包含符合连接条件的行，而且还会包括左表、右表或两个表中
    的所有数据行，这三种情况依次称之为左外连接，右外连接，和全外连接。

    左外连接，也称左连接，左表为主表，左表中的所有记录都会出现在结果集中，对于那些在右表中并没有匹配的记录，仍然要显示，右边对应的那些字段值以NULL来填充。右外连接，也称右连接，右表为主表，右表中的所有记录都会出现在结果集中。左连接和右连接可以互换，MySQL目前还不支持全外连接。

5.简单描述mysql中，索引，主键，唯一索引，联合索引的区别，对数据库的性能有什么影响（从读写两方面）
    1.索引是一种特殊的文件(InnoDB数据表上的索引是表空间的一个组成部分)，它们包含着对数据表里所有记录的引用指针。
    2.普通索引(由关键字KEY或INDEX定义的索引)的唯一任务是加快对数据的访问速度。
    3.普通索引允许被索引的数据列包含重复的值。如果能确定某个数据列将只包含彼此各不相同的值，
    在为这个数据列创建索引的时候就应该用关键字UNIQUE把它定义为一个唯一索引。也就是说，唯一索引可以保证数据记录的唯一性。
    4.主键，是一种特殊的唯一索引，在一张表中只能定义一个主键索引，主键用于唯一标识一条记录，使用关键字 PRIMARY KEY 来创建。
    索引可以覆盖多个数据列，如像INDEX(columnA, columnB)索引，这就是联合索引。
    5.索引可以极大的提高数据的查询速度，但是会降低插入、删除、更新表的速度，因为在执行这些写操作时，还要操作索引文件。
6.sql性能
    （1）选择最有效率的表名顺序
    （2）WHERE子句中的连接顺序
    （3）SELECT子句中避免使用‘*'
    （4）用Where子句替换HAVING子句
    （5）通过内部函数提高SQL效率
    （6）避免在索引列上使用计算。
    （7）提高GROUP BY 语句的效率, 可以通过将不需要的记录在GROUP BY 之前过滤掉。



/*+====================================================================
                            文件上传，表单提交
======================================================================*/

1.获取一个文件的扩展名
    a. return strrchr($file_name, '.');
    b. return substr($file, strrpos($file,'.'));
    c. $end = explode(".",$file); return array_pop($end);
    d. $p = pathinfo($file); return $p['extension'];
    e. return strrev(substr(strrev($file), 0, strpos(strrev($file), '.')));
2.防止表单重复提交
    $token=md5(uniqid(rand(),true));
    $_SESSION['check']=$token;

/*+====================================================================
                            正则
======================================================================*/
1.验证邮箱格式：
    preg_match('/^[\w\-\.]+@[\w\-]+(\.\w+)+$/',$email);

/*+====================================================================
                            编码
======================================================================*/
1.utf-8编码
    数据库中库和表都用utf8编码
    php连接mysql，指定数据库编码为utf8 mysql_query(“set names utf8”);
    php文件指定头部编码为utf-8header(“content-type:text/html;charset=utf-8”);
    网站下所有文件的编码为utf8
    html文件指定编码为utf-8<meta http-equiv="Content-Type"content="text/html;charset=utf-8"/>
2.GB2312格式的字符串装换成UTF-8格式
    iconv('GB2312','UTF-8','悄悄是别离的笙箫');
3.原样输出用户输入的内容
    htmlspecialchars或者htmlentities
4.php文件设置编码
    header("Content-type: text/html; charset=utf-8");




/*+====================================================================
                            文件加载
======================================================================*/
1.相对路径
2.绝对路径
    a,网络绝对路径
    b.本地绝对路径
        include '__DIR__."/cat.php"';
        $root = $_SERVER['DOCUMENT_ROOT'];

/*+====================================================================
                            错误处理
======================================================================*/
1.触发自定义错误
    trigger_error("这是自定义错误",E_USER_ERROR);
2.语法错误
    提示(notice)
        不存在变量常量
    警告(warnig)
        include 不存在文件
    致命(fatal)
        调用未定义函数
   运行时错误

   逻辑错误
3.错误分级
    $arr = array("E_ERROR","E_WARNING","E_PARSE","E_NOTICE","E_CORE_ERROR","E_CORE_WARNING",
    "E_COMPILE_ERROR","E_COMPILE_WARNING",
    "E_USER_ERROR","E_USER_WARNING","E_USER_NOTICE","E_STRICT","E_ALL");
4.是否显示错误
    a.php.ini  display_errors = on/off
    b.ini_set("diaplay_errors",0);
5.显示那些级别错误
    a.error_reporting = E_ALL
6.错误日志
    ini_set("log_errors",1);        // 错误日志记录到 文件中
    ini_set("error_log","myError.txt");
    error_log = "syslog"; // 记录到操作系统事件日志中
7.自定义错误处理器
    set_error_handler("my_error_handler");
    然后实现下面函数
    function my_error_handler($errCode,$errMsg.$errFile,$errLine){

    }
/*+====================================================================
                            变量作用域
======================================================================*/
1.
    局部作用域
    超全局作用域
    $GLOBALS $_SERVER $_REQUEST $_POST $_GET $_FILES $_ENV $_COOKIE $_SESSION
    全局作用域
2.  函数内部访问不了全局变量   (global $a;)函数内部声明一个要使用外部变量的同名变量(局部变量，只是同名)
    函数外部访问不了内部变量   ($GLOBALS['a1'])
        $GLOBALS[‘var’]是外部的全局变量本身
        global $var是外部$var的同名引用或者指针。
        通过构造函数传递外部参数到类内部
    public 只能在类中，声明变量方法和属性直接在外部调用,global可以用在函数中
3.  静态变量：静态变量不会被销毁，赋初值只执行一次
4。四种标量类型：
    boolean （布尔型）
    integer （整型）
    float （浮点型, 也称作 double)
    string （字符串）
    两种复合类型：
    array （数组）
    object （对象）
    最后是两种特殊类型：
    resource　（资源）
    NULL　（NULL）



/*+====================================================================
                                函数
======================================================================*/
1.只有变量能被引用传递
2.可变函数
    函数名是个变量
3.匿名函数
    a.赋值给一个变量
    b.回调函数

/*+====================================================================
                时间格式(ip,time)
======================================================================*/
1.打印出前一天的时间格式是2006-5-10 22:21:21
echo date('Y-m-d H:i:s', strtotime('-1 day'));
2.$nextWeek = time() + (7 * 24 * 60 * 60);
3.echo 'Now:       '. date('Y-m-d') ."\n";
4.  echo 'Next Week: '. date('Y-m-d', $nextWeek) ."\n";
echo 'Next Week: '. date('Y-m-d', strtotime('+1 week')) ."\n";

/*+====================================================================
                        数组
======================================================================*/
1.  $v = current($a);      // 当前指针所在值
    $k = key($a);          // 当前指针所在键
    next($a) ;             //先将指针移动到后一个单元，获取值
    prev($a);              //之前单元值
    reset($a);            //指针移动到第一个单元，获得值
    end($a);              //指针移动到单元末尾，获得值
    each($a)             //将数组当前单元 键值放入数组 ，然后指针移到下一个单元
    Array ( [1] => 1 [value] => 1 [0] => 0 [key] => 0 )(后面两个存键，前面两个存值)
    Array ( [1] => 2 [value] => 2 [0] => 1 [key] => 1 )

    list() 一次性取得数组中数字下标的多个单元的值
2. 数组遍历
    a.foreach($arr as $k=>$v){}
        1.默认是值传递
        2.引用传递 foreach ($a as $key=> &$value)   如果中间对数组进行操作,原始数组会=也会变化
    b.for next
    c.while(list($key,$value) = each($c)){}
3.


/*+====================================================================
                            OOP
======================================================================*/
    1.面向对象
    特征：封装：将类设计更健壮，尽可能将类成员私有化，只开放必须属性方法
          继承：代码复用
                一个对象是这个类的实例，也是这个类上级类的实例
          多态：多种表现形式
                a.不同对象调用相同方法,结果不同
                b.相同对象，使用相同方法也可能出现不同结果(方法重载,传参不同)
    五大基本原则：单一职责原则,开放封闭原则,替换原则,依赖原则,接口分离原则
    2.创建对象
        1. $o1 = new C1();  //通过类创建新对象
        2. $o2 = new o1;    //通过对象new新对象
        3.  $s1 = "C1";      //字符串变量
            $o3 = new $s1();  //可变类
         4. $o4 = new self(); // self当前类本身,只能出现在类方法中
    3.class person{}
        $person = new person;
        常量：const PI = 3.14;     调用：person::PI;

        普通属性：public $name;    调用：$person->name;

        普通方法：public function aqie(){} 调用：$person->aqie();
        静态属性：static $count;  调用：person::$count;
        静态方法：static function aqie(){} 调用：$person::aqie();   person::showInfo();     //类调用静态方法

        三个关键字 (必须在方法中使用)
            parent:父类; parent:$PI;  parent::属性或者方法   (静态属性或方法)
            self:当前所在类;           self::静态属性或者方法
            $this:调用当前方法的对象   $this->实例属性或者方法  (可以调用父类普通属性)
        结论：
        （1）、静态属性不需要实例化即可调用。因为静态属性存放的位置是在类里，调用方法为"类名::属性名"；
        （2）、静态方法不需要实例化即可调用。同上
        （3）、静态方法不能调用非静态属性。因为非静态属性需要实例化后，存放在对象里；
        （4）、静态方法可以调用非静态方法，使用 self 关键词。php里，一个方法被self:: 后，它就自动转变为静态方法；
         (5)
            1.子类内部访问父类静态成员属性或方法，使用 parent::method()/self::method()
            注意：$this->staticProperty(父类的静态属性不可以通过$this(子类实例)来访问，
            会有这样报错:PHP Strict Standards: Accessing static property Person::$country as non static in，
            PHP Notice: Undefined property: )
        6.
             1. php类中，静态方法调用当前类的非静态方法必须用self关键字，不能用$this
             2. php类中，公有方法调用私有方法使用$this关键字，只能实例化调用
             3. php类中，公有方法调用私有方法使用self关键字,此共有方法自动转化为静态方法
             4. php类中，静态方法不能调用非静态属性。因为非静态属性需要实例化后，存放在对象里
             5. 实例化变量即可调用公有方法也可以调用静态方法
            2.子类外部
                1.子类名::method()
                2.子类实例->method() (静态方法也可以通过普通对象的方式访问)
                注意：子类实例->staticProperty(父类的静态属性不可以通过子类实例来访问，
                会有这样报错:PHP Strict Standards: Accessing static property Person::$country as non static in，
                PHP Notice: Undefined property: )
          (6).  在类里面的时候，$this->func()和self::func()没什么区别。
                在外部的时候，->必须是实例化后的对象使用； 而::可以是未实例化的类名直接调用。
    4.$person2 = $person;    // 对象 值传递 (里面属性)对于对象值传递和引用传递没有区别
        对象传值 变量$o1存储的只是对象编号  变量->对象编号->对象
      $person3 = &$person; 引用传递指向对象编号   (指向的都是同一个对象)
    5.
        a.覆盖(重写) 将父类继承过来属性方法重新定义。父类私有方法不能被覆盖，但子类不能定义同名,
        b.如果类本身有构造方法，实例化类时候不会调用父类构造方法
        c.如果类本身没有构析方法，可以手动调用。
        d.final class aqie{} 最终类（该类不允许被继承）
          final function aqie($a){} 最终方法(不允许覆盖)
    6.抽象类（不能实例化类）   实例方法+抽象方法(只有方法头，什么都不做)
        abstract class aqie{abstract function  Eat();}
        子类也是抽象类可以不去实现父类的抽象方法
/*+====================================================================
                                设计模式
======================================================================*/
1.设计模式
    单例模式： 保证一个类仅有一个实例，并提供一个访问他的全局访问点例如框架中的数据库连接

$obj = Single::GetObject();   var_dump($obj);

    简单工厂模式： 它具有创建对象的某些方法，可以使用工厂类创建对象，
    而不直接使用 new。例如初始化数据库的时候会用到，比如MySQL，MSSQL
2.工厂模式 (通过该方法获得指定类对象)

$person = Factory::GetObject("Person");

/*+====================================================================
                                魔术方法和类相关函数
======================================================================*/
1.重载
    a.属性重载(取值(__GET())，赋值(__SET())，判断(__isset())，销毁(__unset()))
    b.方法重载
        调用不存在实例方法时，自动调用__call();
        调用不存在静态方法时，自动调用__callstatic();
    c.__tostring() 将对象当做字符串使用自动调用，并可返回转化后的字符串 (常用)
        就可以 echo $obj;
      __invoke() 将对象作为函数使用会自动调用该方法  (不推荐)
    d.与类有关魔术常量
        * __FILE__
        * __DIR__
        * __LINE__
        * __CLASS__        -- 当前所在类类名
        * __METHOD__       --  当前所在类方法名
    e.与类有关系统函数
        * class_exists()       -- 判断类是否定义
        * interface_exits()    --判断接口是否定义
        * get_class()          -- 获得对象所属类
        * get_parent_class()   -- 获得对象所属类的父类
        * get_class_methods()  --获得对象所有方法，结果是数组
        * get_class_vars()     -- 获得对象所有属性名 数组
        * get_declared_classes()   --获得整个系统定义所有类名
        *
        *
        * 与类有关运算符
        * instanceof       --判断变量（对象，数据）是否是某个类实例

/*+====================================================================
                            接口
======================================================================*/
1.接口 (全是抽象方法(没有方法体)+常量)
    降低类与类复杂度，语言是单继承,通过接口对没有多继承类补充
    接口可以实现多继承，但叫实现
    类1有了接口1特征
2.abstract class MP3Player implements Player,USB {}   抽象类实现多借口
3.interface mp3Player extends Player{}                接口继承接口

/*+====================================================================
  自动加载/克隆/对象遍历/对象类型转换/类型约束/序列化
======================================================================*/
1.需要类：
    1.new新对象，2.使用类的静态方法时候3.定义类并以另一个类作为父类
2.
    a. 自定义加载函数： spl_autoload_register("autoload1");
    b.function __autoload($class_name){}
3. 对象遍历只能遍历可访问范围的属性。(静态属性始终遍历不出来)
    foreach ($obj as $key =>$value){}
    b.想遍历类的所有属性，在类内部定义方法
    public function showAllProperties(){
        foreach($this as $key=>$value){
            echo $key=>$value;
        }
    }
4.php内置标准类 class stdClass{}    ：可以存储一些临时简单数据，也可以类型转换时存储数据
5.(其它标量数据转换为对象,得到内置标准类对象,属性名固定:scalar)
    a.数组->对象 键作为属性名 (数字下标数据转换为对象，无法通过对象语法获取)
        $arr = ['name'=>"aqie",'age'=>24];  $obj = (object)$arr;
6.类型约束(某个变量只能接收存储指定数据类型)
    1.可以使用的类型约束
      a.数组 array
      b.对象 使用类的名称，表示 传递过来实参，必须是该类的实例
      c.接口 使用接口名称 ，表示 传递过来实参，必须实现了该接口的实例（对象）
7.
    1.
        a.序列化: 将变量代表的内存数据，转换成字符串永久保存在硬盘上
            $v = array(1,24,3,"b"); $s = serialize($v); file_put_contents("./serialization.txt",$s);
        b.反序列化:就是硬盘数据恢复到内存
            $s = file_get_contents("./serialization.txt");     // 文本文件读出所有字符
            $v = unserialize($s);     //字符串数据反序列化转化为字符串
    2.对象序列化
        a.对象的序列化  (只有属性可以保存)会自动调用魔术方法__sleep(){return array('p1')}
        // 只对p1序列化 $obj->p1=22;重新赋值后，序列化值也会改变；未序列化的属性等于类原有值
        b.反序列化自动调用__wakeup();  此时依赖对象所属类
/*+====================================================================
                                    pdo
======================================================================*/
1.常用语句
    * $pdo->lastInsertId();        //最后添加ID值
    * $pdo->beginTransaction();
    * $pdo->commit();              //提交事务
    * $pdo->rollBack();             //回滚事务
    * $pdo->inTransaction();       //判断当前行是否在事务(true/false)
    * $pdo->setAttribute(属性名,属性值);     //设置对象属性名
    *
    * 错误信息
    * $pdo->errorCode();
    * $pdo->errorInfo();

    *$res = $pdo->query("select * from");      // 结果集
    * $res ->rowCount();                       //获得结果集行数
    * $res -> columnCount();                   //获得结果集列数
    * $res ->fetch([返回类型]);                //从结果集取出一行数据 （一维数组）
    *
    * PDO::FETCH_ASSOC  (关联数组)
    * PDO::FETCH_NUM   (索引数组)
    * PDO::FETCH_BOTH  (默认值两者皆有)
    * PDO::FETCH_OBJ   (对象)
    *
    * $res ->fetchAll([返回类型]);             // 一次性获取结果集中所有数据（二维数组）
    * $res ->fetchColumn([$i]);                // 获取结果集下一行数据中第i个数据值，一个数据
    * $res->fetchObject();                     //结果集返回对象
    *$res->errorCode();                       //pdo结果集的错误代号
    * $res->errorInfo();                       //pdo结果集的错误信息
    * $res->closeCursor();                     //关闭结果集
2.预处理
    // 形式一
    $sql = "select * from user_list where user_id=? and user_name=?";
    $res = $pdo->prepare($sql);
    $res->bindValue(1,16);           // 占位符按自然顺序，从1开始
    $res->bindValue(2,'aqie');
    $res->execute();
    $arr = $res->fetch(PDO::FETCH_ASSOC);

    //形式二
    $sql = "select * from user_list where user_id= :v1 and user_name= :v2";
    $res = $pdo->prepare($sql);
    $res->bindValue(":v1",16);           // 占位符按自然顺序，从1开始
    $res->bindValue(":v2",'aqie');
    $res->execute();

/*+====================================================================
                                项目安全
======================================================================*/
1.恶意攻击
    请求：
    get:url dos攻击 (硬件和网络防范，防火墙)
    post:(穷举,恶意破解)使用验证码
2.SQL注入
    post:
    a. xxx' or '1 (SELECT * FROM aq_admin WHERE admin_name = 'aqie' AND password = 'xxx' or '1' LIMIT 1)
    万能密码：最简单解决办法md5加密
    b. xxx'or 1# (SELECT * FROM shop.aq_admin WHERE admin_name = 'xxx'or 1# AND password = 'xxx' LIMIT 1;)
    万能用户名: addslashes 转译
    get:
    delete from aq_category where cat_id = 2 or 1;
    转换成整型：
    强制转换：(int) 和intval()
    隐式转换：让其参与运算 +0
3.XSS攻击
    cross site script(跨站脚本攻击)
    解决办法： htmlspecialchars()  htmlentities()

/*+====================================================================
                            基本知识
======================================================================*/
1.break : 完全终止，continue ; 停止当前循环
2.if():   endif;    if():   else: endif;
    switch(): case endSwitch;
    while(): endwhile;
    for()： endfor;
3.数据类型展示(八种数据类型)
4. 1Byte = 8bits
    字节是存储空间(最小的存储单位),位是计算单位

/*+====================================================================
                        命名空间
======================================================================*/


/*+====================================================================
                    常用链接
======================================================================*/
1.lnmp   https://lnmp.org/download.html