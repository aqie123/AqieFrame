<?php

/**
 * 算法的一个类
 * Class ArithmeticController
 * (快速排序是实至名归的好算法。计数排序在小值范围里表现良好；
 * 其他情况因为低内存而应 付不来。鸡尾酒排序对于随机值是一个坏选择。
 * 冒泡排序及其变形并不适合实际应用。)
 * (使用内置排序函数是一个有趣的练习。
 * 使用解释型的PHP来写排序函数永远也快不过sort() 采用的C变体)
 *
    快速排序
    计数排序
    梳排序
    堆排序
    归并排序
    希尔排序
    选择排序
    插入排序
    地精排序
    联合冒泡排序
    鸡尾酒排序
    冒泡排序
    奇偶排序
    使用标志的冒泡排序
 */
class ArithmeticController extends Controller
{

    /**
     * 向页面传值,数组
     * $this->view[0]['name']  // 第几个传值对应相应下标
     */
    public function indexAction()
    {
        $name = 'aqie';
        $city = ['北京','上海','广州','深圳'];

        $array = [24,31,4,53,10,75,13,6,1,65,22,8,5,2,6];
        $this->assign(['name'=>$name]);
        $this->assign($city);
        //$array = $this->bubbleSort2($array);
        //$array = $this->selectSort($array);
//         $array = $this->selectSort2($array);
        $array = $this->quickSort2($array);
        $this->assign($array);

        $exists = $this->orderFind($array,1);
        $this->assign(['exists'=>$exists]);

        $arrlen = count($array);
        $bool = $this->binaryFind($array,534,0,$arrlen-1);
        $this->assign(['bool'=>$bool]);

        $cars =[1,2,3,[4,5,6]];
        $this->assign($cars); // 5

        $buychicken = $this->buyChicken(100,100);
        $this->assign($buychicken);

        $this->assign(['factory'=>$this->factory(5)]);  // 7
        $this->aqieplay();
    }


    /**
     * 冒泡排序，
     * (对需要排序的数组从后往前（逆序）进行多遍的扫描，
     * 当发现相邻的两个数值的次序与排序要求的规则不一致时，
     * 就将这两个数值进行交换。这样比较小（大）的数值就将逐渐从后面向前面移动。)
     * 数组长度n,
     * 比较n-1轮
     * 每一轮比较次数n-1
     * @param $arr
     * @return $arr
     */
    protected function bubbleSort(&$arr)
    {
        $arrlen = count($arr);
        for($i=0;$i<$arrlen-1;++$i){
            // 每一轮比较次数  ($j=$arrlen-1;$j>$i;--$j)
            $flag = false;
            for($j=0;$j<$arrlen-$i-1;++$j){
                // 比后一项大就交换(小->大)   arr[$j]<$arr[$j+1] (大->小)
                if($arr[$j]>$arr[$j+1]){
                    // 数值交换
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j+1];
                    $arr[$j+1] = $temp;
                    $flag = true;//发生了交换，故将交换标志置为真
                }
            }
            if(!$flag){   //本趟排序未发生交换，提前终止算法
                return $arr;
            }
        }
        return $arr;
    }

    /**
     * 冒泡排序优化
     * @param $arr
     * @return mixed
     */
    protected function bubbleSort2(&$arr) {
        $arrlen = count($arr);
        while ($arrlen > 0) {
            $p = $arrlen;
            $arrlen = 0;
            for ($j = 1; $j < $p; $j++) {
                if ($arr[$j - 1] > $arr[$j]) {
                    $temp = $arr[$j - 1];
                    $arr[$j - 1] = $arr[$j];
                    $arr[$j] = $temp;
                    $arrlen = $j;
                }
            }
        }
        return $arr;
    }

    /**
     * 快速排序
     * (在数组中挑出一个元素（多为第一个）作为标尺，扫描一遍数组将比标尺小的元素排在标尺之前，
     * 将所有比标尺大的元素排在标尺之后，通过递归将各子序列分别划分为更小的序列直到所有的序列顺序一致。)
     * 分成两部分，然后再分别快速排序
     * @param $arr
     * @return mixed
     */
    protected function quickSort(&$arr){
        $len = count($arr);
        if($len <= 0){
            return $arr;
        }
        $key = $arr[0];
        $left_arr = array();
        $right_arr = array();
        // 以第一个元素把数组分成两部分
        for($i=0;$i<$len-1;++$i){
            if($arr[$i] <= $key){
                $left_arr[] = $arr[$i];
            }else{
                $right_arr[] = $arr[$i];
            }
        }
        $left_arr = $this->quickSort($left_arr);
        $right_arr = $this->quickSort($right_arr);
        $arr = array_merge($left_arr, array($key), $right_arr);

        return $arr;
    }

    /**
     * 快速排序第二种写法
     * @param $a
     * @param int $l
     * @param int $r
     */
    protected function quickSort2(&$a, $l = 0, $r = 0) {
        if($r == 0) $r = count($a)-1;
        $i = $l;
        $j = $r;
        $x = $a[($l + $r) / 2];
        do {
            while ($a[$i] < $x) $i++;
            while ($a[$j] > $x) $j--;
            if ($i <= $j) {
                if ($a[$i] > $a[$j])
                    list($a[$i], $a[$j]) = array($a[$j], $a[$i]);
                $i++;
                $j--;
            }
        } while ($i <= $j);
        $function = __FUNCTION__;
        if ($i < $r) $this->$function($a, $i, $r);
        if ($j > $l) $this->$function($a, $l, $j);
        return $a;
    }

    /**
     * 选择排序
     * 求一个数组最大值下标，将最大值下标和最后一个单元交换
     * 循环n轮,每轮循环n次
     * @param $arr
     * @return mixed
     */
    protected function selectSort(&$arr){
        $arrlen = count($arr);
        for($i = 0;$i<$arrlen;++$i){
            $pos = 0;// 最大值下标
            $max = $arr[0]; //第一项作为最大值
            for($j = 0;$j < $arrlen - $i;++$j){
                if($arr[$j] > $max){
                    $max = $arr[$j];
                    $pos = $j;
                }
            }
            $tmp = $arr[$pos]; // 最大值和最后一个单元交换
            $arr[$pos] = $arr[$arrlen-$i-1];  // 每轮最后一个数
            $arr[$arrlen-$i-1] = $tmp;
        }
        return $arr;
    }

    /**
     * 选择排序另一种写法
     * @param $a
     * @return mixed
     */
    protected function selectSort2(&$a) {
        $n = count($a);
        for ($i = 0; $i < ($n - 1); $i++) {
            $key = $i;
            for ($j = ($i + 1); $j < $n; $j++) {
                if ($a[$j] < $a[$key]) $key = $j;
            }
            if ($key != $i) {
                list($a[$key], $a[$i]) = array($a[$i], $a[$key]);
            }
        }
        return $a;
    }

    /**
     * 顺序查找
     * @param $arr
     * @param $val     （要查找值）
     * @return bool|int|string  返回数组下标
     */
    protected function orderFind($arr,$val){
        foreach($arr as $key=>$v){
            if($v === $val){
                return $key;
            }
        }
        return false;
    }

    /**
     * 二分查找 (已经排好序的索引数组)
     * (假设数据是按升序排序的，对于给定值x，从序列的中间位置开始比较，
     * 如果当前位置值等于x，则查找成功；若x小于当前位置值，
     * 则在数列的前半段中查找；若x大于当前位置值则在数列的后半段中继续查找，直到找到为止。（数据量大的时候使用）)
     * @param $arr
     * @param $val
     * @param $begin
     * @param $end
     * @return bool
     */
    protected function binaryFind($arr,$val,$begin,$end){
        if($begin>$end){
            return false;
        }
        // 定位中间位置
        $mid = intval(($begin+$end)/2); // 舍去取整
        // 获取中间值
        $mid_value = $arr[$mid];
        if($mid_value === $val){
            return true;
        }else if($mid_value > $val){  // 左边找
            return $this->binaryFind($arr,$val,$begin,$mid-1);
        }else{  // 右边找
            return $this->binaryFind($arr,$val,$mid+1,$end);
        }
    }

    /*
     * 约瑟夫环
     * 一群猴子排成一圈，按1，2，...，n依次编号。
     * 然后从第1只开始数，数到第m只,把它踢出圈，从它后面再开始数，再数到第m只，
     * 在把它踢出去...，如此不停的进行下去，直到最后只剩下一只猴子为止，那只猴子就叫做大王。
     * 要求编程模拟此过程，输入m、n,输出最后那个大王的编号
     */
    protected function josephus($n,$m){
        $monkey = range(1,$n);
        $i = 0;
        while (count($monkey) >1) {
            $i += 1;
            $head = array_shift($monkey);//一个个出列最前面的猴子
            if ($i % $m !=0) {
                #如果不是m的倍数，则把猴子返回尾部，否则就抛掉，也就是出列
                array_push($monkey,$head);
            }

            // 剩下的最后一个就是大王了
            return $monkey[0];
        }
    }

    protected function josephus2($n,$m){
        $r = 0;
        for ($i=2; $i <= $m ; $i++) {
            $r = ($r + $m) % $i;
        }

        return $r+1;
    }

    /**
     * 54张牌公平洗牌算法
     * @param $card_num
     * @return array
     */
    protected function wash_card($card_num){
        $cards = $tmp = array();
        for($i = 0;$i < $card_num;$i++){
            $tmp[$i] = $i;
        }

        for($i = 0;$i < $card_num;$i++){
            $index = rand(0,$card_num-$i-1);
            $cards[$i] = $tmp[$index];
            unset($tmp[$index]);
            $tmp = array_values($tmp);
        }
        return $cards;
    }

    /**
     * @param $num (总数)
     * @param $price(总价)
     * 百鸡百钱(穷举思想)
     *公鸡5元,母鸡三元，小鸡一元3只
     * @return  array (公鸡，母鸡，小鸡)
     */
    protected function buyChicken($num,$price){
        $chicken = [];
        $count=0;
        for($a = 0;$a<=$num/5;++$a){             // 考虑公鸡价格
            for($b = 0;$b<=($num-5*$a)/3;++$b){  // 考虑母鸡价格,以及公鸡花的钱
                $c = $price - $a -$b;
                if($c % 3 != 0){            // 小鸡树必须是整数
                    continue;
                }
                $totalprice = $a*5+$b*3+$c/3;
                if($totalprice ==100){
                    $chicken[] = array($a,$b,$c);
                }
                ++$count;
            }
            $chicken['次数'] = $count;
        }
        return $chicken;
    }

    /**
     * 串联字符串
     * @return string
     * series("-","hello","aqie");
     */
    protected function series(){
        $arr = func_get_args();     //获取所有实参
        $count = count($arr);
        $s1 = $arr[0];
        $str = "";
        for($i=1;$i<$count;$i++){
            if($i == $count-1){         //最后一项
                $str .=$arr[$i];
            }else{
                $str .= $arr[$i].$s1;
            }

        }
        return $str;
    }
    /*********************递归小例子************************************
     * ******************************************************
     */

    /**
     * 计算阶乘(递归)
     * @param $n
     * @return int
     */
    protected function factory($n){
        if($n === 1){
            return 1;
        }
        return $n*$this->factory($n-1);
    }

    /**
     * 斐波那契数列(递归)   1 1 2 3 5 8 13
     * @param $n
     * @return int
     */
    protected function Fibonacci($n){
        if($n == 1 || $n==2){
            return 1;
        }
        $res = $this->Fibonacci($n-1)+$this->Fibonacci($n-2);
        return $res;
    }

    /**
     * 判断是否是闰年
     * @param $year
     * @return bool
     */
    protected function isLeap($year){
        return  $year %4 ==0 && $year % 100 !=0 || $year %400 ==0;
    }

    /**
     * 猴子每天吃一半再多吃一个，第十天只有一个桃子，求总数(递归)
     * @param $n  （第几天）
     * @return int (对应桃子数)
     */
    protected function peachNum($n){
        if($n==10){
            return 1;
        }else{
            $res = ($this->peachNum($n+1)+1)*2;
            return $res;
        }
    }

    /*********************递推小例子************************************
     * ******************************************************
     */
    /**
     * 斐波那契数列（递推）
     * @param $n
     */
    protected function Fibonacci2($n)
    {
        $first = $second =1;
        $res = 1;
        for ($i = 3; $i <= $n; ++$i) {
            $res = $first +$second;
            $first = $second;
            $second= $res;
        }
        echo "<br>".$res;

    }

    /**
     * (递推)
     * n是n-2三倍 前两个是1,2 3 6 9 18 27 36
     * @param $n
     * @return int
     */
    protected function f00($n){
        $res = 0;
        $a1 = 1;
        $a2 = 2;
        if($n==1){
            $res = 1;
        }else if($n ==2){
            $res = 2;
        }
        for($i = 3;$i<=$n;++$i){
            $res = $a1*3;
            $a1 = $a2;
            $a2 = $res;
        }
        return $res;
    }

    /**
     * 猴子吃桃
     * @param $n
     * @return int
     */
    protected function peachNum2($n){
        $res = 1;
        if($n==10){
            $res =1;
        }
        $a1 = 1;            //第十天桃子数
        for($i = 9;$i>=$n;--$i){
            $res = ($a1+1)*2;
            $a1 = $res;
        }
        return $res;
    }

    /**
     * 递推 1-2+3-4+5
     * @param $n
     * @return int
     */
    protected function totalNum($n){
        $res = 0;
        for($i = 1;$i<=$n;++$i){
            $res += ($i%2 == 0)? (-1)*$i : $i;
        }
        return $res;
    }




}