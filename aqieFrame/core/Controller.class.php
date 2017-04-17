<?php
// 核心控制器
class Controller
{
    public function __construct() {

    }
    // 跳转方法
    public function jump($url,$message,$wait = 3)
    {
        if($wait ==0){
            header("Location:$url");
        }else{
            include CUR_VIEW_PATH ."message.html";
        }
        exit(); //一定要退出
    }
    // 引入工具类
    public function library($lib)
    {
        include LIB_PATH . "{$lib}.class.php";
    }

    // 引入辅助函数
    public function helper($helper)
    {
        include HELPER_PATH . "{$helper}.php";
    }

    /**
     * 公共方法  ajax 数组信息返回json格式信息
     * $this->message(array('message'=>'请确认表单信息完整性','status'=>0));die;
     * @param $arr
     */
    public function message($arr){
        $arr = json_encode($arr);
        echo $arr;
    }

    /**
     * 向页面传参
     */
    public function assign($array){
        /*
        $argv=func_get_args();
        $v=&$argv[0];
        $len=count($argv);
        for($i=1;$i<$len;$i++){
            $k=$argv[$i];
            $argv[] = array($k=>$v[$k]);
//            echo '变量名:'.$k.', '.$v[$k].'<br>';
        }
        return $argv;
        */
        $this->view=$array;
        return $this->view;
    }

    /**
     *加载模板页面
     */
    protected $view   =  null;
    public function aqieplay(){
        $backtrace = debug_backtrace();
        array_shift($backtrace);
//            echo "<pre>";
        $str =  $backtrace[0]["function"];
        $str = substr($str,0,strlen($str)-6);
//        echo $str;
//        $argv=func_get_args();
        print_r($this->view);
        $arr = $this->view;
//        foreach ($this->view as $k=>$v){
//            $k = $v;
//        }
        include CUR_VIEW_PATH .$str.".html";
    }

    /**
     * 获取用户ip
     * @return array|false|string
     */

    function getIP()
    {
        global $ip;
        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if(getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if(getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
        else $ip = "Unknow";
        return $ip;
    }




}