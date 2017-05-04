/*+====================================================================
                            session cookie
======================================================================*/
前提：
* HTTP 无状态性 独立的
* --B/S架构基于http协议进行数据交互
* --http请求响应是独立的，每次请求响应周期都是完全独立的


一.
session
1.概念
    在服务器端建立很多会话数据区
    为每个session会话数据分配唯一标识
    将唯一标识，分配给相应浏览器(存储在cookie) (session 基于cookie)
2.有效期
    * 默认关闭浏览器
3.有效域名
    * 仅在当前域名下有效

4.
    session 支持多种类型：整型,浮点型,字符串类型,布尔型,数组类型,对象,null
    (就是采用序列化存储)
    (在session 中存储对象，获取对象，需要找到对象对应的类)
5.session 入库

二.
cookie （setcookie(键，值，有效期(0)，有效路径('/')，有效域(''))）
1.概念
    cookie(允许 服务器端脚本(php) 程序在 浏览器 上存储数据)
     浏览器技术
    由服务器(php)决定存储内容
    浏览器向服务器 请求 时，会携带该服务器存储数据的cookie
    （响应时把cookie信息告知浏览器）
2.获取：获取cookie  var_dump($_COOKIE);
3.有效时间
    浏览器关闭时(会化周期结束),cookie失效
    PHP_INT_MAX 常量值：PHP表示的最大整型（时间戳也是）,表示cookie永久存在
    删除cookie
      --Time()-1 删除cookie（通用的）
      --第二个参数设为空字符串，也是删除(快捷语法)
4.有效路径 （知道就可以）
    * cookie仅在当前目录和后代目录有效
    * cookie 第四个参数路径  / cookie 整站有效

5 有效域(常用)
    *某个域名下设置cookie，仅在当前域名下有效
    * baidu.com 子域名(二级域名) music.baidu.com
    * cookie 支持在一级域名内(所有二级域名间)进行cookie 数据共享
    * setcookie(key,value,0,time()+3600,'/');
    * setcookie(key,value,0,'','.aqie.com');  .aqie.com所有子域名下有效(默认是当前域)
6.安全
    * 第六个参数，默认false, true则是仅在https下有效
7.
    第七个参数(是否允许浏览器脚本使用，默认false 可以使用)
    js获取：alert(document.cookie);
8.其他
    * $_COOKIE 仅仅用于存储浏览器请求时携带的cookie(当前脚本周期setcookie设置的cookie变量，不会出现在$_COOKIE中)
    *
    * cookie应用（1.存储未登录用户购物车商品，2.多长时间免登陆 3.搜索习惯）
    * 长时间存储会话数据，通常用cookie



区别：
1.session可以存储任意类型的数据，但cookie只能存储字符串
2..session存储在服务器端，更安全
3.cookie会使传输数据量大
4.存储位置 session 服务器 更安全 大小无限制 数据类型支持全部类型 session几乎不做持久化
cookie可以长期存储

其他：
1.
    浏览器禁用cookie,sessionid不能存储传输（理论上解决，通过url,post数据向服务器每次传输sessionid）
    * session.use_only_cookies = 1; 改为0就可以通过其他方式传输
    * session.use_trans_sid = 0;   是否通过其他方式传输sessionid 改为1
2.
    * 一般session不做持久化工作，长时间存储使用cookie
    sessionid 持久化 session_set_cookie_params(3600);  //秒
    * session数据区默认以文件形式存储在服务器操作系统临时目录中
3. 控制session属性
    session属性来源 ： cookie中存储的session ID
    * 方案一：
    * cookie存储的sessionid决定session属性
    * 1、session.cookie_lifetime(默认0)  php.ini
    * 2.有效路径整站有效
    * 3.有效域（默认当前域）
    * 4.session.cookie_secure仅安全连接传输(默认false)
    *5.session.cookie_httponly(默认false)，js也能拿到
    *
    * 方案二：(开启前通过函数配置)
    * 1.ini_set('session.cookie_lifetime','3600');
    * ini_set('session.cookie_domain','.aqie.com');
    *
    * 2.session_set_cookie_params(有效期，有效路径，有效域);  (推荐)
    *session_set_cookie_params(3600,'/','.aqie.com');
    * 实际中(重写session 存储机制)：
    * 1.数据库存储
    * 2.数据放到内存中

    从session_start();开始后，创建$_SESSION,从session数据区读取数据。然后反序列化，给$_SESSION赋值
    * 数据从数据区到php.脚本周期内(操作$_SESSION)。脚本周期结束时才会将$_SESSION数据写入数据区