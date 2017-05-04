<?php
// 核心启动类
class FrameWork
{
    // 定义run方法
    public static function run()
    {
       // echo "hello";
        self::init();
        self::autoload();
        self::dispatch();
    }
    // 初始化方法
    private static function init()
    {
        // 定义路径常量
        define("DS",DIRECTORY_SEPARATOR); // 目录分割符  '/'(unix) '\'windows
        define("ROOT",getcwd() .DS); // 当前框架根目录
        define("APP_PATH",ROOT . 'application'.DS);          //app所在目录
        define("FRAMEWORK_PATH",ROOT . 'aqieFrame'.DS);      // 框架基础类所在路径
        define("PUBLIC_PATH", ROOT ."public" .DS);          // 公共文件所在目录
        define("CONFIG_PATH",APP_PATH ."config".DS);           // 配置项所在目录
        define("CONTROLLER_PATH",APP_PATH  . "Controllers" . DS); //当前控制器所在目录
        define("MODEL_PATH",APP_PATH  . "Models" . DS);    //当前model所在目录
        define("VIEW_PATH",APP_PATH  . "Views" . DS);      //视图所在目录
        define("CORE_PATH",FRAMEWORK_PATH ."core".DS);
        // 辅助函数 相关功能
        define("HELPER_PATH",FRAMEWORK_PATH ."helpers".DS);
        define("LIB_PATH",FRAMEWORK_PATH ."libraries".DS);
        define("UPLOAD_PATH",PUBLIC_PATH."uploads".DS);          // 上传目录
        // 获取参数 p c a
        define('PLATFORM',isset($_GET['p']) ? $_GET['p'] : "home");
        define('CONTROLLER',isset($_GET['c']) ? ucfirst($_GET['c']) : "Index");
        define('ACTION',isset($_GET['a']) ? $_GET['a'] : "index");
        define("CUR_CONTROLLER_PATH",CONTROLLER_PATH . PLATFORM .DS);
        define("CUR_VIEW_PATH",VIEW_PATH . PLATFORM .DS);       // 当前目录

        $GLOBALS['config'] = include CONFIG_PATH . "config.php";
        // 强制载入核心类
        include CORE_PATH . "Controller.class.php";
        include CORE_PATH . "Model.class.php";

        // 开启session
         session_start();
    }
    // 路由方法
    private static function dispatch()
    {
        // 获取控制器名称
        $controller_name = CONTROLLER . "Controller";
        // 获取方法名
        $action_name = ACTION . "Action";
        // 实例化控制器对象
        $controller = new $controller_name();
        // 调用方法
        $controller->$action_name();
    }
    // 注册为自动加载
    private static function autoload()
    {
//        $arr =array(__CLASS__,'load');
        spl_autoload_register('self::load');

    }
    // 实现控制器和数据库模型加载
    // AqieController AqieModel
    private static function load($classname)
    {
        if(substr($classname,-10) == "Controller"){
            // 载入控制器
            include CUR_CONTROLLER_PATH ."{$classname}.class.php";
        }elseif (substr($classname,-5) == "Model"){
            // 载入数据库模型
            include MODEL_PATH . "{$classname}.class.php";
        }else{
            // 。。。
        }
    }


}