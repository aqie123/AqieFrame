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
     * @param $array
     * @return null
     */
    public function assign($array){
        $this->view[]=$array;
        return $this->view;
    }
    /**
     *加载模板页面
     */
    protected $view   =  null;
    public function aqieplay(){
        $backtrace = debug_backtrace();
        // 获取控制器类名
        $ctr = $backtrace[0]['file'];
        $ctr = substr($ctr,0,strlen($ctr)-20);
        $ctr = strrchr($ctr,"\\");
        $ctr = str_replace("\\","",$ctr);

        // 获取方法名
        $str =  $backtrace[1]["function"];
        $str = substr($str,0,strlen($str)-6);
        $path = CUR_VIEW_PATH .$ctr.DS.$str;
        // var_dump($path);die;  // F:\AqieFrame\application\Views\home\Arithmetic\index
        include $path.".html";
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