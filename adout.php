1.初始化，定义路径常量,getcwd(获取当前工作目录)
2.路由分发
3.自动加载


ucfirst();  首字母改成大写
substr(string,start,length);

一.使用三种加载
aqiefram里面类名是变化的          (使用强制加载)
application里面model和controller名字是固定的         (自动加载)
aqieframe 里面libraries和helper  (通过控制器类加载)


二.数据库设计要点
1.字段类型，数据类型

三.表间关系
将一个多对多转换成连个一对多
保证每张表都只展示一种信息

四.商品表设计
    商品分类(category)
    商品品牌(brand)
    商品管理(goods)
    扩展属性(attribute)
    商品属性(goods_attr)
    商品类型(goods_type)

五.实现流程
    登录控制器(LoginController)  后台基础控制器(BaseController)
1.商品分类管理(CategoryController,CategoryModel) | 品牌管理(BrandController) | 商品类型(TypeController) | 后台登录管理
2.商品属性管理(AttributeController)
3.商品管理(GoodsController)


1.商品分类（表：aq_category）控制器admin/category   是为商品服务的
    a.商品分类添加
        1.显示添加表单addAction (cat_add.html)
        2.插入操作 insertAction ()
    b.商品分类显示
        1.分类显示 indexAction (cat_list.html)
    c.商品分类编辑
        1.显示修改表单 editAction (cat_edit.html)
        2.实现修改 updateAction
    d.商品分类删除
        1.实现删除 deleteAction

    note:无限分类
    给定一个分类，无限制添加后代分类

2.用户登录(session是在框架开启的)(表：aq_admin)
    后台基础控制器 | 登录控制器       (两者并列不然进入死循环)
    a.后台基础控制器
    b.后台登录控制器
        LoginController->login加载页面(login.html)
        LoginController->sinin方法获取数据
        AdminModel->checkAdmin方法验证是否正确

3.商品类型管理（表：aq_goods_type）  是为扩展属性服务的(属性集合)
    商品分类->商品
    类型->扩展属性
    a.商品类型添加
        1. 添加页面 addAction (goods_type_add.html)
        2. 数据库插入 insertAction
    b.商品类型显示
        1.indexAction (goods_type_list.html)
    c.商品类型编辑
        1.显示修改表单 editAction (goods_type_edit.html)
        2.实现修改 updateAction
    d.商品类型删除
        1.实现删除 deleteAction

4.商品属性管理（goods_type->attribute->goods->attr）从商品类型进入属性管理
    商品属性两类：
        通用属性(名称，价格,图片)（表 goods）
        扩展属性(不同商品不同)(表 goods_attr)
        通过（表 attribute）存放扩展属性类型
            type_id:当前属性属于哪个类型
            attr_type: 属性类型(唯一，单选(颜色)，多选(配件))->给前台的
            attr_input_type: 属性输入类型（文本框，下拉列表）->给后台的
            attr_value : 扩展属性的可选值
            sort_order :增加排序规则

5. 商品牌管理
    list->品牌分页
    add-> 图片上传 public/uploads

6.商品管理
    type_id商品类型id
    a.难点：在添加商品->商品属性，选择相应商品属性，显示其对应的所有属性


二 ： 前台 IndexController

    首页  index
        a.展示所有商品分类 (表category)
            1.将平行关系二维数组转换成包含关系多维数组
                在框架model 里面定义tree2方法
                在category模型里面,获取数据
                在home/indexcontroller里面讲分类显示到页面
        b.显示特别推荐商品

    列表页


    详情页

五： 接口



