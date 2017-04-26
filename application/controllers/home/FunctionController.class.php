<?php


class FunctionController extends QueueController
{
    /**
     * 用于展示本控制器所有函数功能
     * $this->view[0]['name']  // 第几个传值对应相应下标
     */
    public function indexAction(){
        $title = '函数首页';
        $this->assign(['title'=>$title]);

        $this->createFile('F:/AqieFrame/aqieframe/newfile/1/2/3');        // 创建文件

        $filelist = $this->readFile('F:/AqieFrame/aqieframe/');            // 读取文件
        $this->assign($filelist);

        $url = ' http://www.baidu.com/abc/123/index.php?id=1';
        $ext = $this->getextname($url);
        $this->assign(['ext'=>$ext]);

        $this->assign(['prime'=>$this->isPrime(24)]);

        $this->assign(['parameter'=>$this->formalParameter(1,2,3)]);

        $this->assign(['arrmax'=>$this->single_array_max($this->arr)]);  // 5

        $this->assign(['arrrev'=>$this->array_rev($this->arr2)]);

        $this->assign(['maxodd'=>$this->max_odd($this->arr)]); // 7

        echo $this->stringconversion("a_qie");
        $this->aqieplay();
    }

    /**
     * 显示百度页面
     */
    public function getcontentAction(){
        // 开启扩展 extension=php_openssl.dll
        $page =  file_get_contents("https://www.baidu.com");
        $this->assign(['page'=>$page]);
        $this->aqieplay();
    }

    /**
     * 商品无限分类
     * @param $arr
     * @param int $pid
     * @param int $level
     * @return array
     */
    public function tree ($arr,$pid=0,$level=0){
        static $list = array();
        // 如果是顶级分类，则将其存到$list中，并以此节点为根节点，遍历其子节点
        foreach ($arr as $k=>$v){
            if($v['parentid'] = $pid){
                $v['level'] = $level;
                $list[] = $v;
                $this->tree($arr,$v['catid'],$level+1);
            }
        }
        return $list;
    }
    /*===========================================================================
                                    文件操作
    ==========================================================================
    */
    /**
     * 创建多级目录
     * @param $path
     * @param int $mode
     */
    private function createFile($path,$mode = 0777){
        if(is_dir($path)){
           echo "目录已经存在";
        }else{
            if(mkdir($path,$mode,true));
        }
    }

    /**
     * 读取文件夹下所有路径
     * @param $path   (要读取路径)
     * @param int $deep
     * @return array   (二维数组)
     */
    private function readFile($path,$deep=0){
        // 是一个目录并且成功打开
        if(is_dir($path)){
            if($handle = opendir($path)) {
                // 存储所有文件信息
                static $fileList = array();
                while (false !== ($filename = readdir($handle))) {
                    if ($filename == '.' || $filename == '..') continue;
                    $fileInfo['filename'] = $filename;
                    $fileInfo['deep'] = $deep;
                    $fileList[] = $fileInfo;
                    // 判断当前读取的是否是目录
                    if (is_dir($path . '/' . $filename)) {
                        // 是目录递归调用，每次递归深度加一
                        $this->readFile($path . '/' . $filename, $deep + 1);
                    }
                }
                closedir($handle);
                return $fileList;
            }
        }
    }

    /**
     * 多进程同时向一个文件写入
     * @param $file    (操作文件)
     * @param $method  （打开方式）
     */
    private function lockFile($file,$method){
        $handle = fopen($file,$method);
        if(flock($handle,LOCK_EX)){
            // 获得写锁,写数据
            fwrite($handle,"write something");
            // 解除锁定
            flock($handle,LOCK_UN);
        }else{
            echo "file is locking";
        }
        fclose($handle);
    }

    /**
     * 返回一个网址文件后缀
     * @param $url   (需要解析网址)
     * @return array  (文件后缀)
     */
    private  function getextname($url){
        $arr = parse_url($url);
        $file = basename($arr['path']);
        $ext = explode(".",$file);
        return $ext[1];
    }

    /**
     * 判断是否为合法日期(2007-03-13 13:13:13)
     * @param $data
     * @return bool
     */
    function checkDateTime($data){
        if (date('Y-m-d H:i:s',strtotime($data)) == $data) {
            return true;
        } else {
            return false;
        }
    }

    private $state;

    /**
     * 1.任意给出状态，判断灯是否亮 与运算(&)
     * define("D1",1);
     * define("D2",2);
     * define("D3",4);
     * $state = 10;
     * @param $n   (灯的总数量)
     *2. $state = $state | D3;    // 打开灯3
     * 3.关闭任意一个灯泡
     * $state = $state &(~D2);
     */
    function lightbulb($n){
        for($i = 1;$i<$n;++$i){
            $s = "D" .$i;
            if($this->state & constant($s) > 0){
                echo "灯{$i}亮";
            }else{
                echo "灯{$i}灭";
            }
        }
    }

    /**
     * 多维数组转换为一维数组
     * @param $arr
     * @return array|bool
     */
    protected function arr_foreach ($arr)
    {
        static $tmp=array();
        if (!is_array ($arr))
        {
            return false;
        }
        foreach ($arr as $val )
        {
            if (is_array ($val))
            {
                $this->arr_foreach ($val);
            }
            else
            {
                $tmp[]=$val;
            }
        }
        return $tmp;
    }

    /**
     * 判断是否是素数
     * @param $num
     * @return bool (true 是素数)
     */
    protected function isPrime($num){
        $c = 0;
        for($i = 1;$i<=$num;++$i){
            if($num % $i ==0){
                $c++;
            }
        }
        return  $c == 2 ? true : false;
    }

    /***
     * set_error_handler("my_error_handler");
     * @param $errCode (错误代码号)
     * @param $errMsg   (错误信息)
     * @param $errFile  (出错文件)
     * @param $errLine  (错误行号)
     * 该函数出错会自动调用
     */
    protected function my_error_handler($errCode,$errMsg,$errFile,$errLine){
        $str = "";
        $str .=  "<br>错误代码号".$errCode;
        $str .=  "<br>错误信息".$errMsg;
        $str .=  "<br>出错文件".$errFile;
        $str .=  "<br>错误行号".$errLine;
        $str .=  "<br>错误时间".date("Y-m-d H:i:s");

        echo $str;  // 写入到文件中
    }

    /**
     * 没有形参可以接受任意实参
     * 并返回一个数组
     */
    protected function formalParameter(){
        $arr = func_get_args();
        return $arr;
    }

    /*************************************************************
     * 数组相关
     */
    private $arr = [2.4,1,5,1,55,90,24,111];
    private $arr2 = array(
        array(1,11,111),
        array(2,22,222,2222),
        array(3,33,333,3333,33333)
    );

    /**
     * 一维数组平均值
     * @param $arr
     * @return float|int   (平均自)
     */
    protected function single_array_average($arr){
        $arrlen = count($arr);
        $sum = 0;               // 总和
        $count = 0;                 // 总数
        for($i=0;$i<$arrlen;++$i){
            $sum += $arr[$i];    // 累加思想
            ++$count;                // 计数思想
        }
        return $sum/$count;
    }

    /**
     * 一维数组最大值
     * @param $arr
     * @return mixed
     */
    protected function single_array_max($arr){
        $max = $arr[0];
        $arrlen = count($arr);
        $pos = 0;
        for($i = 0;$i < $arrlen;++$i){
            if($max<$arr[$i]){
                $max = $arr[$i];
                $pos = $i;
            }
        }
        return array($pos,$max);

    }

    /**
     * 实现数组反转
     * @param $arr
     * @return array
     */
    function array_rev($arr){
        $temp = [];
        for($i=count($arr)-1;$i>=0;$i--){
            if(is_array($arr[$i])){   //这里判断是否为数组
                $temp1 = $this->array_rev($arr[$i]);  //若为数组则开始调用自身
                $temp[] = $temp1;
                continue;
            }
            $temp[] = $arr[$i];
        }
        return $temp;
    }

    /**
     * 交换两个数的值
     * @param $a
     * @param $b
     */
    protected function change_value($a,$b){
        $tmp = $a;
        $a = $b;
        $b = $tmp;
    }

    /**
     * 获取一维数组最大奇数
     * @param $arr
     * @return mixed
     */
    protected function max_odd($arr){
        $arrlen = count($arr);
        $odd = [];
        for($i=0;$i<$arrlen;++$i){
            if($arr[$i]%2 != 0){
                // 如果存在奇数放到一个数组中
                $odd[] = $arr[$i];
            }
        }
        // 存在奇数
        if(count($odd)){
            return $this->single_array_max($odd)[1];
        }
    }
    /**
     * 二维数组求平均值
     * @param $arr
     * @return float|int
     */
    protected function double_array_average($arr){
        $arrlen = count($arr);
        $sum = 0;
        $count = 0;
        for($i = 0;$i < $arrlen;++$i){
            $temp = $arr[$i];       // 二维数组转换为一维数组
            $arrlen2 = count($temp);
            for($j = 0;$j < $arrlen2;++$j){
                $sum += $temp[$j];
                ++$count;
            }

        }
        return $sum/$count;
    }

    /**
     * "make_by_id" 转换成 "MakeById"
     * @param $string
     * @return string
     */
    protected function stringconversion($string){
        $arr = explode("_",$string);
        array_walk($arr,function(&$v){
            $v = ucwords($v);
        });
        $res = implode("",$arr);
        return $res;
    }

}