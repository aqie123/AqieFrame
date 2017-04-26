1.分库分表
    难点：1.分表主键选择
          2.分表后跨分区数据的查询统计
2.事务
    sql四种隔离 (由低到高,并发由高到低)
        1.未提交读(read uncommited)
        2.已提交读(read commited)
        3.可重复读(repeatable read )(默认)
            show variables like '%iso%';
            begin;                  // 开启事务
            select id from a where id<7;
            commit;
            set session tx_isolation='read-committed';  //
        4.可串行化(serializable)
3.大事务
    运行时间长，操作数据多
        a.锁定太多数据，造成大量阻塞和锁超时
        b.回滚所需要时间长
        c.执行时间长,容易造成主从延迟
4.影响性能
    1.服务器性能
    2.服务器系统
    3.存储引擎
    4.参数配置
    5.数据库结构和SQL语句
5.
MyISAM:
    1.缓存
        索引：内存缓存
        数据：操作系统缓存
    2.表级锁
    3.支持全文索引
    4.支持数据压缩
InnoDB:
    1.索引，数据：都在内存缓存
    2.行级锁

MyISAM:
    使用场景：
        1.非事务
        2.只读应用
        3.空间类应用
InnoDB:
    使用场景：
    show variables like 'innodb_file_per_table';
    on :独立表空间 ：同时向多个文件刷新数据
    off:系统表空间 ：会产生IO瓶颈
CSV:(engine=csv)数据交换中间表
    不支持索引
    可对数据文件直接编辑
    所有列不能为null

锁：
    共享锁：读锁
    独占锁：写锁
    阻塞：等待另一个事务释放
    死锁：两个或两个以上事务相互占用对方资源
    show engine innodb status;

基准测试：（sysbench）

压力测试：


数据库结构优化：
    1.减少数据冗余
    2.避免插入异常,更新异常,删除异常
    3.节省数据存储空间
    4.提高查询效率
数据库结构设计:(需求设计->逻辑设计->物理设计)
    1.范式
        a.所有字段只具有单一属性
          单一属性列由接班的数据类型构成
          表都是简单二维表
        b.不存在主键依赖
        c.
需求：1.只销售图书
      2.用户登录，商品展示，供应商管理
            用户管理，商品管理，在线销售
      3.用户必须注册才能交易
        用户只能在一个地方登录
        用户信息(用户名,密码,手机号,姓名,注册日期,在线状态,出生日期)
       4.商品展示商品管理
        商品信息(商品名称,分类名称,出版社名称,图书价格,图书描述,作者)
        拆分后：商品信息（商品名称,出版社名称,图书价格,图书描述,作者）（分类名称）
                分类信息（分类名称，分类描述）
                商品分类(对应关系)（商品名称，分类名称）
        5.供应商信息（出版社名称，地址，电话，联系人，银行账户）
        6.在线销售（订单编号，下单用户名，下单日期，订单金额，订单商品分类，订单商品名
                    订单商品单价，订单商品数量，支付金额，物流单号）
        拆分：订单表：（订单编号，下单用户名，下单日期，支付金额，物流单号）（手机号，订单金额）
            订单商品关联表（订单编号，订单商品分类，订单商品名，商品数量）（商品单价）

物理设计：
    1.数字类型>日期或二进制类型>字符类型>
    2.tinyint(一个字节,8位)
    3.日期：timestamp(时间戳)

高可用：

索引优化策略：
    1.索引列上不能使用表达式或函数 our_date<=date_add(current_date, interval 30 day)
    2.索引长度
    3.联合索引
        经常使用到列优先
        选择性高的列优先
        宽度小列优先
    4.覆盖索引  (explain)
        优化缓存减少磁盘io
        减少随机io，变随机io操作为顺序io操作
        避免对innodb主键索引二次查询
    5.索引扫描优化排序
        索引的列顺序和order by子句顺序完全一致
        索引中所有的列方向(升序降序)和order by子句完全一致
        order by 中字段全部在关联表中第一张表中
    6.模拟hash索引优化查询
        只能处理键值的全值匹配查找
        所使用的的hash函数决定索引键的大小

/*+====================================================================
                            mysql
======================================================================*/
1.有没有外键不影响查询，但是可以提高查询速度，同时防止错误数据
2.mysql用户和权限和管理
    a.创建用户
        create user 'aqie'@'localhost' identified by '123456';
    b.删除用户
        drop user 'aqie'@'localhost';
    c.修改密码
        set password = '密码' ;
        set password for 'aqie'@'localhost' = password('123');
    d.授予权限
        grant  权限列表  on  某库．某个对象  to  ‘用户名’@’允许登录的位置’  【identified  by  ‘密码’】；
        grant select on product.* to 'aqie'@'localhost'; (identified  by '密码')
        grant insert on product.* to 'aqie'@'localhost';
        grant create on product.* to 'aqie'@'localhost';
    说明：
        1，权限列表，就是，多个权限的名词，相互之间用逗号分开，比如:  select,  insert,  update
        也可以写：all
        2，某库．某个对象，表示，给指定的某个数据库中的某个“下级单位”赋权；
        下级单位有：表名，视图名，存储过程名；  存储函数名；
        其中，有2个特殊的语法：
        *.*：	代表所有数据库中的所有下级单位；
        某库．*	：代表指定的该库中的所有下级单位；
        3，【identified  by  ‘密码’】是可省略部分，如果不省略，就表示赋权的同时，也去修改它的密码；
        但：如果该用户不存在，此时其实就是创建一个新用户；并此时就必须设置其密码了
    e.剥夺权限
        1.revoke  权限列表  on  某库．某个对象  from  ‘用户名’@’允许登录的位置’

3.事务
•	原子性：一个事务中的所有语句，应该做到：要么全做，要么一个都不做；
•	一致性：让数据保持逻辑上的“合理性”，比如：一个商品出库时，既要让商品库中的该商品数量减1，又要让对应用户的购物车中的该商品加1；
•	隔离性：如果多个事务同时并发执行，但每个事务就像各自独立执行一样。
•	持久性：一个事务执行成功，则对数据来说应该是一个明确的硬盘数据更改（而不仅仅是内存中的变化）。

 set autocommit = 0;
    //事务处理
 start transaction;    // 也可以写成 begin;
 if(没有出错){
  commit;
 }else{
  rollback;
 }

4.mysql编程
    a.流程控制
    if()
    A:begin
        //todo
        //退出A包含语句块
    end A;
    end if 条件语句 then;
    begin
        语句块
    end;

    case @v1
      when 1 then
         begin
         //....
         end;
     else
         begin
         //....
         end;
     end case;

    loop语句

     标识符:loop
     begin
      //....
     //必须有退出循环逻辑机制。
       if()then
          leave 标识符      //退出
       end if;
     end;
     end loop 标识符;

    while语句
     set @v1 = 1;     //赋值语句
     while @v1<10 do
     /...直到条件为假退出
     begin
          insert into tab (id,num) values(null,@v1);
          set @v1 = @v1+1;
     end;
     end while;

     repeat语句                     //类似do while，但是直到条件为真才结束
     set @v1 = 1;
     标识符：repeat
     /....
     begin
          insert into tab (id,num) values(null,@v1);
          set @v1 = @v1+1;
     end;
     until @v1>=10;        // v1=10退出循环
     end repeat 标识符;

     leave 语句
     退出标识符
b.mysql变量

    普通变量
     declare 变量名 类型名 [default 默认值]；// 必须先定义
     set value = 23;
     只能在编程环境中使用：
     1.定义函数内部；
     2.定义存储过程内部；
     3.定义触发器内部

     会话变量带@
     set @v1 =1;
     可以在cmd里直接运行
     select @v1,@v1+3
     select @v2 := 2;     // 直接赋值，并输出结果集
     select 3 into @v3;   // 赋值给v3
     select @v1,@v2;

c.mysql函数 (更换语句结束符  delimiter /)

    1.（开启了binlog   set global log_bin_trust_function_creators=TRUE;）
    create function getMaxValue(p1 float,p2 float,p3 float)
    returns float # 返回float类型
    begin
    declare result float;      -- 声明变量，没默认值
    if(p1>=p3 and p1>=p2) then
    begin
        set result = p1;
    end;
    elseif(p3>=p1 and p3>=p2) then
    begin
    set result = p3;
    end;
    else
    begin
    set result = p2;
    end;
    end if;
    return result;
    end;

     select now(), getMaxValue(1.1,3.33,3.3333);
     注意事项：
    1， 在函数内容，可以有各种变量和流程控制的使用；
    2， 在函数内部，也可以有各种增删改语句；
    3， 在函数内部，不可以有select或其他“返回结果集”的查询类语句；

    drop function getMaxValue;       // 删除函数

d.存储过程 （存储过程，其本质还是函数——但其规定：不能有返回值；） database(test_db)

    说明：
    1，in：用于设定该变量是用来“接收实参数据”的，即“传入”；默认不写，就是in
    2，out：用于设定该变量是用来“存储存储过程中的数据”的，即“传出”，即函数中必须对他赋值；
    3，inout：是in和out的结合，具有双向作用；
    4，对于，out和inout设定，对应的实参，就“必须”是一个变量，因为该变量是用于“接收传出数据”；

    create procedure insert_get_Data(p1 int,p2 tinyint,p3 bigint)
    begin
    insert into tab(f1,f2,f3) values(p1,p2,p3);
    select* from tab order by f1 desc limit 0,3;
    end;

    调用(非编程环境调用)
    call insert_get_Data(1,2,3)

    #创存储过程使用in，out，inout(out inout对应实参必须是变量)
    create procedure pro1(in p1 int,out p2 tinyint,inout p3 bigint)
    begin
    set p2= p1*2;
    set p3 = p3+p1*3;           # 3+3
    insert into tab(f1,f2,f3) values(p1,p2,p3);
    end;
    set @s3 = 3;
    call pro1(1,@s2,@s3)
    select @s2,@s3

    删除存储过程  drop procedure pro1
f. 触发器(trigger)
 触发器，也是一段预先定义好的编程代码（跟存储过程和存储函数一样），并有个名字。
但：
它不能调用，而是，在某个表发生某个事件（增，删，改）的时候，会自动“触发”而调用起来

*说明：
1，触发时机，只有2个：  before（在....之前），  after（在....之后）；
2，触发事件，只有3个：insert，  update，  delete
3，即其含义是：在某个表上进行insert(或update,或delete)之前（或之后），会去执行其中写好的代码（语句）；即每个表只有6个情形会可能调用该触发器
4，通常，触发器用于在对某个表进行增删改操作的时候，需要同时去做另外一件事情的情形；
5，在触发器的内部，有2个关键字代表某种特定的含义，可以用于获取有关数据：

形式：
create trigger 触发器名 触发时机 触发事件 on 表名 for each row as
begin
//....
end;

在tab插入数据时，同时将这表中第一字段最大值行写入另一个表中tab_max(永远只存储一行)
create table tab_max like tab;

create trigger tri1 after insert on tab for each row
begin
#删除表中原有数据
delete from tab_max;
#tab中f1最大字段存入变量@maxf1
select max(f1) into @maxf1 from tab;
#取出这行所有数据
select f2 into @v2 from tab where f1 = @maxf1;
select f3 into @v3 from tab where f1 = @maxf1;
#将数据插入到tab_max
insert into tab_max(f1,f2,f3) values(@maxf1,@v2,@v3);
end;

drop trigger tri1;

再建一个触发器，在tab进行insert前，将数据插入到类似结果表中（tab_some）
create trigger copy_data before insert on tab for each row
begin
set @v1 = new.f1;       #获得新行字段f1值
set @v2 = new.f2;       #获得新行字段f2的值
insert into tab_some(id,age) values(@v1,@v2);
end;