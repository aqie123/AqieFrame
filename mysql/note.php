
/*MYSQL(基础)
 原来自动增长列用int数据类型,不用varchar.
 *net start mysql;
 *net stop mysql;
 *
 * set names gbk;       // 在cmd窗口编码
 * 数据库备份和恢复
 * mysqldump -h服务器名 -uroot -proot  数据库名>文件名     // 备份**********
 * mysqldump -uroot -proot imooc_singcms > /tmp/singcms.sql
 *
 * mysql -h服务器名 -uroot -proot  数据库名<文件名         //恢复************
 * mysql -uroot -proot [product]<F:\www\php\aqie\ER\product\product.sql
 * mysql>source d:/dbname.sql
 *
 * 注释(三种)
 * #
 * -- 注释内容
 * 多行注释
 *
 * delimiter //      自定义结束符
 *
 * 本身不区分大小写
 *
 *collate 排序 (所有英文字符比较，都是单个字符比较)
 * 中文排序
 * show charset;        显示所有排序规则
    show collation;
 *
 * 数据类型 (数值型，字符串型，日期时间型)
 * 数值型
 * -整数型   (长度)(unsigned)(zerofill是否填充0到左边,自动表示是unsigned)
    alter table s add num int(10) unsigned zerofill not null;
 * tinyint 1个字节 8位 -127，127.  255  3个数字
 * smallint
 * mediumint
 * int      4个字节
 * bigint
 *
 * -小数型
 * --浮点
 * float  (6-7有效位)
 * Double
 *
 * --定点型
 * decimal(10,3) 总位数10.小数部分3
 * 字符型
 * set          //多选项数据(64)checkbox  1 2 3 4 5
 * enum         // 单选项(65535)radio      1 2 4 8   或者用tinyint
 * text         // (65535)
 * varchar  **  //可变长度字符串(65535)
 * char         //定长,默认是1个(255)
 * binary       //存储二进制
 * blob         // 二进制 适用于图片
 *
 * 时间型
 * year         //年份类型
 * timestamp    //时间戳类型  得到整数数字
 * time
 * date         //日期类型
 * datetime   // 时间日期类型
 *
 * 基本命令
 * status               //查看数据库状态
 * select database();       // 查看当前数据库
 * create database aqie;
 * drop database if exists aqie;
 * show create database aqie;
 * use aqie;
 * create table name(id int);                   // 创建表
 * insert into shop(name,pwd,email) values(aqie,123,2@qq.com);      // 插入数据
 * select * from shop;   \g  \G               //显示表中数据
 * drop table if exists name ;                     //删除表
 * truncate table shop;                 // 清空表中数据
 * show tables;
 * alter table shop rename shop1;       // 修改表名
 * alter table shop1 modify column name varchar(40);        // 修改行
 * desc shop1;
 * alter table shop1 change names username varchar(34);      // 修改行字段名     字段是names改为username
 * alter table join1 change id fid int(20) primary key auto_increment;
 * alter table shop1 add email varchar(30);         // 添加行
 * alter table  shop1 drop email;                   //删除行
 * alter table shop add key/unique key/primary key(user_name);    //添加索引 唯一约束

alter table tb_name add primary key (字段1,字段2,字段3);              // 添加复合主键
* show create table shop1;
 *
 * ##一些常识
 * show variables like 'char%';     //查看数据库编码
 * show create table <表名>;      //查看表编码
 * create database <数据库名> character set utf8;       //创建数据库指定编码
 * alter database <数据库名> character set utf8;        //修改数据库编码
 * alter table <表名> character set utf8;         //修改表编码
 * alter table <表名> add constraint <外键名> foreign key<字段名> REFERENCES <外表表名><字段名>;
 * //添加外键
 * alter table <表名> drop foreign key <外键名>;     //删除外键
 *
 * select unix_timestamp();     //Unix时间戳
 * select now();
 *
 *
 * $result = mysqli_query($link,select/ delete/ update/  insert/ desc/  show tables)
 *
 * mysqli_fetch_assoc();
 * mysqli_fetch_row();      // 很少
 * mysqli_fetch_array($result);
 *
 * */

/* mysql 索引
*普通索引 ：key(email)
 * 唯一索引 ： unique key(email)
 * 主键索引 primary key(id)
 * 全文索引 fulltext
 * 外键索引： foreign key +字段名+ references 外键表(对应其它表中字段)

*
 *
 * 约束
        主键约束 primary key
         唯一约束unique key
          外键约束foreign key
 * 检查约束
 *
 * 表选项列表
 * charset =utf8
 * engine = Innodb
 * auto_increment = 2
 * comment = '说明文字'
 *
 *
 * 视图
 * 给一个select语句一个名字，以后调用
 * 创建视图
 *create view v1 as select id,name,pwd email  from shop where id >7 and id<90 or age>10;
 * create view v2 as select age from student where  age<30;
 *删除视图
 * drop view v1;
 *
 *
 * 数据库设计范式
 *1.原子性(不可再分)
 * 2.唯一性(消除部分依赖) --给表设计主键(主键决定其他字段，其他字段依赖主键)
 * 主键有多个,产生部分依赖
 * 经验(每张表设计自增长主键)
 * 3.独立性(消除依赖传递)  即一张表只记录一种数据
 *使每个字段独立依赖主键字段，消除部分非主键的内部依赖，这种内部依赖构成传递依赖
 *
 *
 *
 * 数据库操作语言(auto_increment,timestamp可以不用插入)
 * 一：插入数据
 * 1.insert into shop values(1,'aa')(2,'bb');   //可以插入多行
 * 2.replace 插入主键或者唯一键有重复，变成修改
 * replace into shop values(1,'bb');
 *
 * 3.将select 查询数据结果，都插入到数据库
 * insert into shop select * from shop2;
 *
 * 4.insert into shop set 1=a,b=2,  //类似update  只能插入一条
 *
 * 5.load data(载入结构整齐纯文本数据)
 *load data infile "完整文件地址" into table shop;
 * load data infile "F:/www/php/aqie/datasource/student.txt" into table student;
 *
 * 二：删除数据
 * delete from shop wnere条件  order by排序  limit限定
 * delete from shop where id = '$id';
 *
 * 三：修改数据
 * update shop set 字段= value

    update cms_position set create_time=UNIX_TIMESTAMP(now());
 *
 *
 * 四：查询数据 database(product)
 * 1.基本查询(concat字符串连接)
 * select 3,4+5,concat('hello','world'),now();
 * select count(*) as count from product;       //数据总量
 * select avg(price) as avg from product where pinpai = '联想';
 select avg(market_price) as 所有商品平均价格 from aq_goods;
 *
 * 2.all(默认) 和 distinct 是否消除重复行，前者不消除
 * select distinct * from shop;
 *
 * 3.where
 *  =等于 <>不等于
 * 逻辑 and or not
 *select * from shop where id>=2 and id<=5;
 *
 * 4.空值和布尔值判断  is
 * xx is null;      //空值，没有值
 * xx is not null;
 * xx is true;
 * xx is false; // 0 ,0.0, "", null
 * select * from shop where on is true;
 *
 *5.between 和in运算符
 *select * from shop where id between 2 and 5;
 *
 * select * from shop where id in (1,3,5,7);
 *
 * 6.like 模糊查找
 * %    // 任何个数任何字符
 * _        // 一个任意字符
 * select * from product where pro_name like '%联想%';
 * select * from product where pinpai = '联想';         // 这两个相等
 * 转译 xx like '%\%%';       // 含有百分号
 * xx like '%/_%'
 *
 * 7.group by 分组  (数据库shop)
 * select * from product group by pinpai;        //这个数据没意义   分完组眼中只有组
   select brand_id,count(*)from aq_goods group by brand_id \G      每种品牌商品数量
 * select pinpai, count(*) as 数量 from product group by pinpai;      //每种品牌商品数量

 * select brand_id,count(*) as 数量,max(market_price)as 最高价,
    avg(market_price)as 平均价,sum(market_price)as 总价 from aq_goods group by brand_id;
 *
 * select chandi,count(*) as 数量 from product group by chandi;       // 查询每个产地有多少数量产品**
 *select chandi ,count(*) as 数量 from product group by pro_type;     // 按照产品种类查出商品数量
 *
 * 8.having
 * 和where相同，不过是对分组后数据筛选

select brand_id,count(*) as 数量,max(market_price)as 最高价,
avg(market_price)as 平均价,sum(market_price)as 总价 from aq_goods group by brand_id
having 平均价>300;
 *
 * 找出品牌数量大于2的
select brand_id as 品牌ID,count(*) as 数量 from aq_goods group by 品牌ID  having 数量>=2;
 *
 * select pinpai ,max(price) as 最高价, min(price) as 最低价,
 * avg(price) as 平均价, sum(price) as 总价 from product group by pinpai
 * having count(*)>2
 *
 * 9.order by
 * select * from product order by protype_id,price desc;    //按照产品id,价格倒序
 *
 * 10 limit
 * select * from product where price >3000 limit 2,2;       //从第二行开始取两行
 *select * from product order by price desc limit 0,1;      //找出价格最高
 *
 *
 *
 * 总结 from -> where->group by-> as->having->order by-> limit
 *
 *五：联表查询(连接查询效率更高)
 *
 * 连接查询： 将两个及以上表，连接起来，当做一个数据源 (三种写法一样)
 * 1.1 select * from join1,join2;        #没有条件连接 (交叉连接)(左边每一行和右边每一行对接)
 * 1.2 select * from join1 join join2;
 * 1.3select * from join1 cross join join2;
 *
 * 2.内连接
 * select * from product inner join product_type on 连接条件;
 *select * from product inner join product_type on product.protype_id = product_type.protype_id;
 * select * from product as p inner join product_type as t on p.protype_id = t.protype_id;
 * 正确写法
 * select p.*,t.protype_name from product as p inner join product_type as t on p.protype_id = t.protype_id;
 *
 * 3.左外连接 left(outer)join
 * 将两个表内连接,加上左边不符合内连接限制条件的结果
 * select * from product as p left join product_type as t on p.protype_id = t.protype_id;
 *
 * 4.右外连接 right(outer)join
 * 将两个表内连接,加上右边不符合内连接限制条件的结果
 *
 * 5.全外连接 left(outer)join
 * 不支持
 *
 *
 * 练习 product表
 * select p.protype_id,protype_name,count(*) as 数量 from product as p inner join product_type as t on p.protype_id = t.protype_id group by p.protype_id;
 * 更规范
 * select p.protype_id,protype_name,count(*) as 数量 from product as p inner join product_type as t on p.protype_id = t.protype_id group by p.protype_id ,protype_name;
 *
 * 练习 student faculty(学生，院系)
 * 进入cmd首先 set names gbk;
 *1.查出计算机系所有学生信息
 * select student.* from student inner join faculty on student.fid = faculty.fid
 * where fname = '计算机系';        -- student. 只查询学生信息
 *
 *
 * 六;子查询（一个位置出现查询语句）
 *
 * 子查询为主查询服务，子查询后才进行主查询
 * select pro_id ,price*0.9,5 as 送 from product;   //全场九折并送5块
 * select pro_id,price from product where price > 5000;     //价格高于5000
 * select pro_id,avg(price) as 平均价 from product;            //这个乱写的
 *
    子查询概念
 * select pro_id,price from product where price > (select 5000);        \\子查询
 * select pro_id,price from product where price >
 * (select avg(price) from product); (标量子)               // 全部高于平均价商品
 *
 * 子查询分类：(按结果)
 * 1.表子查询       返回多行多列，可当做表使用,通常放在from后面
 * select * from (select 1) as t;       //必须加别名
 *
 * 2.行子查询       一行多列，当做行使用(少见)
 * 行比较语法：where roe(字段1，字段2)= (select 行子查询)
 *
 * 3.列子查询       多行一列，当做多值使用
 *
 * 4.标量子查询      一行一列，当做单个值使用
 * (单个数据值可以用标量子代替)
 *
 *
 * 子查询（按位置）
 * 1.结果数据
 * select pro_id,price,(select 5) as 折扣 from product;
 *
 * 2.条件数据
 * 3.来源数据
 *
 * 常见子查询
 * 1.比较运算符中子查询
 * 操作数 比较运算符 （标量子查询）
 * 操作数 ：比较运算符两个数据之一，通常是一个字段名
 *   select * from product where price=(select max(price) from product);                              //找出最高价商品(几个同价)
 *
 * 2.使用 in的子查询
 * 操作数 in (列子查询)
 * //找出产品类别名中带电字的
 * select protype_id from product_type where protype_name like '%电%';
 * // 先找出product_type中带电的protype_id.将结果作为 in的数据项
 * select * from product where protype_id in (
    select protype_id from product_type where protype_name like '%电%'
  );
 *
 * //查询产品类名为家用电器商品 (inner join)
 *select * from product as p inner join product_type as t on p.protype_id = t.protype_id where
 * protype_name = "家用电器";
 *
 * 3.使用any(some)子查询 （标量子查询）
 *某个操作数对于该列子查询任意一值满足比较运算符，就算满足条件
 *  // 取出product表中比student表中sid大的数据   (只要比后面表任意一个数据大就满足了)
 *select * from product where pro_id > any (select sid from student);
 *
 * 4.all的子查询
 * 必须必所有的sid都大才满足
 * select * from product where pro_id > all (select sid from student);
 *
 * 查询所有非最高价的商品()
// * select * from product where price< (select max(price) from product);
 *最高价商品最少会小于所有价格中的一个
 * select * from product where price < any (select price from product);
 *
 * 查询最高价商品(大于等于所有价格)
 * select * from product where price >=all (select price from product);
 *
 * 5.exists查询(隐式查询和主查询建立关系)必须和主查询一起
 * 该子查询有数据就是ture,
 * 要么全部取出要么都不取出
 * select * from product where exists (select * from product where pinpai = '联想');
 *
 * //查询商品类别中带电的
 * // (protype_id = product.protype_id 当前表id等于主查询表中id)等式是隐藏查询条件  内外建立联系
 * select  * from product where exists (
      select * from product_type where protype_name like'%电%'
      and protype_id = product.protype_id
);
 *
 *
 * 6.联合查询 union
 *两个select查询字段数必须一致(字段类型具有一致性)
 * //默认(distinct)消除重复行
 * //只能对联合后数据排序
 * select * from join1
 * union
 * select * from join2 order by id1 desc;       //只能用第一个的id
 *
 * 实现全外连接           // 加上all就会有重复
 * select * from product left join  product_type on product_type.protype_id = product.protype_id
   union all
   select * from product right join  product_type on product_type.protype_id = product.protype_id;
 *
 *
 *
 *
 * 练习
 *1.查询计算机系所有学生信息 (as以后就用后面的查询)
 * select s.* from student as s inner join faculty as f on fname = '计算机系' where  s.fid = f.fid;
 * select * from student where fid =(
    select fid from faculty where fname = '计算机系'
   )
 *2.查询韩顺平所在院系
 * select * from faculty where fid =(
    select fid from student where sname = '韩顺平'
   )
 * // 查什么写什么
 *select sname,sex,shome,s.fid,fname,ftel  from student as s inner join faculty as f on sname = '韩顺平' where  s.fid = f.fid;
 * 3.查出计算机院系的学生信息
 * select sname,sex,shome,s.fid,fname,ftel  from student as s inner join faculty as f on s.fid = f.fid
    where fname = '计算机系';       // on 和where 很有意思
 *4.查出在行政楼院系名称
 *select fname ,fassress from faculty where fassress like '%行政楼%';
 *
 * 5.查出男女生各多少人(分组)
 * select sex,count(*) as 人数 from student group by sex;
 *
 * 6.查询人数最多院系信息
 *select * from student as s  inner join faculty as f on s.fid = f.fid where
 * select * from faculty where fid = (                          -- 找院系id
     --以院系id分组，找出院系id,条件为数量最大那个
     select fid from student group by fid having count(*)=(
        -- 找出院系id分组结果中，数量最大数值
        select count(*) from student group by fid order by count(*) desc limit 0,1
     )
   );
 *
 * 7.查出人数最多院系男生女生各多少人
 * select sex, count(*) as 人数 from student where fid = (
    select fid from student group by fid having count(*)=(
        -- 找出院系id分组结果中，数量最大数值
        select count(*) from student group by fid order by count(*) desc limit 0,1
    )
   )
    group by sex;
 *
 * 8.跟罗弟华同籍贯得人
 *select * from student where shome = (
    select shome from student where sname = '罗弟华'
  );
 *排除该人
 * select * from student where shome = (
    select shome from student where sname = '罗弟华'
  ) and sname <> '罗弟华';
 *
 * 9.查出所有有河北人就读院系信息
 *select * from faculty where fid in (                  -- 这里不是等于 in
    select fid from student where shome = '河北'        -- 列子查询
  );
 *
 * 10.查出跟河北女生同院系的学生信息
 * select * from student where fid = (
      select fid from student where shome = '河北' and sex = '女'
   );
 *排除河北女生
 * select * from student where fid = (
      select fid from student where shome = '河北' and sex = '女'
   ) and not (shome = '河北' and sex = '女');
*/
/*
                             总结 from -> where->group by-> as->having->order by-> limit
 1.查询耐克下面所有产品信息
select g.* from aq_goods as g where brand_id =
   (select brand_id from aq_brand where brand_name="耐克");
select g.* from aq_goods as g inner join aq_brand as b on brand_name like "无%" where g.brand_id=b.brand_id;
2.查询admin所在地区
select i.area,u.user_name from aq_user_info as i where i.user_id=
   (select u.user_id from aq_user as u where user_name="admin");
 select i.area,u.user_name from aq_user_info as i inner join aq_user as u on user_name='admin' where u.user_id=i.user_id;
3.查出每个品牌产品数量
   select b.brand_name,count(g.goods_name) from aq_goods as g inner join aq_brand as b where g.brand_id=b.brand_id group by b.brand_name ;
 4.将品牌根据描述分组 (查看每个分类下有多少品牌)
    select count(brand_name),brand_desc from aq_brand group by brand_desc;
 5.查看男装品牌数量
  select count(brand_name),brand_desc from aq_brand group by brand_desc having brand_desc="男装";
 6.查询商品最多的品牌

select brand_name from aq_brand where brand_id=(          # 品牌表查找品牌id
   # 以品牌id分组商品表分组，找出品牌id,条件是数量最大的那个值
  select brand_id from aq_goods group by brand_id having count(*)=(
   # 找出品牌id分组中，数量最大的那个值
    select count(*) from aq_goods group by brand_id  order by count(*) desc limit 0,1
   )
);
查询商品最多的品牌 及其商品数量
select b.brand_name,count(g.goods_name) from aq_goods as g inner join aq_brand as b where g.brand_id=b.brand_id group by b.brand_name  order by count(g.goods_name) desc limit 0,1;


  select count(brand_name) from aq_brand;
 查询商品最多的品牌及其对应商品数量
*/

/*三表联查
* database (product->stu,kecheng,stu_kecheng)
* 1.所有选修mysql同学
* select name from stu where id in(
select stu_id from stu_kecheng where kecheng_id =(
select id from kecheng where kecheng_name = 'Mysql'
)
);
*select name from stu
inner join stu_kecheng as sk on sk.stu_id = stu.id
inner join kecheng as kc on kc.id = sk.kecheng_id
where kecheng_name = 'mysql';


* 2.查询张三选修课程
select kecheng_name from stu
inner join stu_kecheng as sk on sk.stu_id = stu.id
inner join kecheng as kc on kc.id = sk.kecheng_id
where name = '张三';
*
* select kecheng_name from kecheng where id in(    # 课程id和张三是多对一
select kecheng_id from stu_kecheng where stu_id = (
select id from stu where name = '张三'
)
);
*
*3.查询只选修一门课程学生学号和姓名
*select id,name from stu where id in(      #分组
select stu_id from stu_kecheng group by stu_id having count(*)=1
);

*4.查询选修了至少三门课程学生信息
select * from stu where id in(      #分组
select stu_id from stu_kecheng group by stu_id having count(*)>=3
);
*
* 5.查询选修了所有课程学生
select * from stu where id in(      #分组
select stu_id from stu_kecheng group by stu_id having count(*)=(
select count(*) from kecheng
)
);
*
* 6.查询选修了课程的总人数
* #以学生stu_id为条件分组，找出所有学生id
* select stu_id from stu_kecheng group by stu_id;
*select count(*) from (select stu_id from stu_kecheng group by stu_id)as t;        #这里必须加as(分组)
* 7.查询每个学生选修了几门课.
*
* 8.查询所学课程至少有一门和张三所学课程相同的学生信息
* select * from stu  where id in(                          #查询学生信息
select stu_id from stu_kecheng where kecheng_id in(  ##课程id至少有一门和张三一样（1,2）
select kecheng_id from stu_kecheng where stu_id = (
select id as stu_id from stu where name = '张三'
)
)
);
*
* 9查询两门及以上不及格同学课程平均分
* 找出所有不及格分数信息
*select stu_id from stu_kecheng where score <60;
* 对不及格结果数据进行分组，并取得大于等于2的组
*
*          #以学生id分组有两门不及格
*  select stu_id,avg(score) as 平均分 from stu_kecheng where stu_id in (
select stu_id from stu_kecheng where score <60
group by stu_id having count(*)>=2
)
group by stu_id;
* */