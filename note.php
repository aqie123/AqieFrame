
/**
 * PHP 可以做web开发
 *
 * 电子商务
 * --B2C  商家对客户(小米，凡客)
 * --C2C 客户对客户 (淘宝，拍拍)
 * --B2B (阿里巴巴,批发市场)
 * --B2B2C(京东，苏宁，国美)
 * --O2O 线上线下(美团，糯米，大众点评)
 *
 * CMS(内容管理)学校，企业，公司网站，新闻资讯
 * SNS:社交网站
 * 博客，微博
 * 论坛
 * ERP
 * OA
 *
 *
 * 一：项目整体 商品用户交易
 *
 * 二：
 * oop： object oriented programming
 *
 * 三：编码规范
 * 1.一定要有注释
 * 2.统一命名规范
 * （文件名 ：
 *  类文件 ：AqieController.class.php
 *  类名 ：AqieController
 *  方法名 ：aqieAction
 *  属性名 : 小驼峰或者下划线
 *  函数名 ：下划线var_dump imagecreatetruecolor
 *  常量名 : 大写
 * ）
 * 3.严格区分大小写
 * 4.注意缩进，代码对齐
 */
项目安全
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
    a.<script>while(1){alert("hello")};</script>
    b.<script>alert(document.cookie);</script>
    c.</table><div>
    解决办法： htmlspecialchars()  htmlentities()

项目错误
    1.undefined variable 未定义变量
    2.undefined index 未定义数组索引
    写入日志(PHP_EOL == \n\r)
    if($GLOBALS['config']['log']){
        $str = "[" . date("Y-m-d H:i:s) . "]" .$str . PHP_EOL;
        file_put_contents('log.txt',$str,FILE_APPEND);
    }

分页原理：（limit ($urrentPage-1)*$pagesize,$pagesize）

商品属性 点击下拉，筛选
    通过onchange传递type_id发出请求
    通过iframe实现无刷新
        1.添加iframe
        2.给下拉列表增加事件
        3.在attribute控制器编写getAttrAction方法

