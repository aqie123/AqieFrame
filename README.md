# aqieFrame
- core : 框架核心类文件
- databases:数据库驱动目录
- helpers: 辅助函数目录
- libraries: 类库目i录，工具类模型


 ## 统一命名规范
 - （文件名 ：
 -  类文件 ：AqieController.class.php
 -  控制器 ：AqieController
 -  模型   ：AqieModel
 -  方法名 ：aqieAction
 -  属性名 : 小驼峰或者下划线
 -  函数名 ：下划线var_dump imagecreatetruecolor
 -  常量名 : 大写

[项目地址]()
1. home/arithmetic 控制器包含一般算法和常见算法题
     * 冒泡排序，快速排序，选择排序，顺序查找，二分查找
2. home/function   控制器继承了部分常用函数
3. function.php   包含了常见php函数用法
4. 用法


## 集成了
- 验证码类(Captcha)
- 图片的缩放和加水印类(ImageZoom)
- 图片上传类.单文件/多文件(Upload)
- 分页类(Page)
- Model 类对简单增删改查进行基本封装
- Model2 类实现数据库单例模式

### public/js
- 包含原生ajax(post/get)
- plugs : 瀑布流