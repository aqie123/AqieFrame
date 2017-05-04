/*+====================================================================
                            常见函数
======================================================================*/
-----------------------------1.数组------------------------------------------------

    array_multisort():二维数组排序
    strlen() 函数返回字符串的长度
    strtotime()将英文文本日期时间解析为 Unix 时间戳
    array_unshift() 函数用于向数组插入新元素。新数组的值将被插入到数组的开头
    array_push() 函数向第一个参数的数组尾部添加一个或多个元素（入栈），然后返回新数组的长度
    array_shift() 函数删除数组中第一个元素，并返回被删除元素的值。
    array_pop() 函数删除数组中的最后一个元素。
    range(low,high,step) 函数创建一个包含指定范围的元素的数组
    array_flip() 函数用于反转/交换数组中所有的键名以及它们关联的键值。
    array_reverse(array,preserve)
    指针操作函数：current,key,next,prev,end,reset,each
    单元操作函数：array_pop,array_push,array_shift,array_unshift,array_slice,array_splice
    排序函数：sort,asort,ksort,usort,rsort,arsort,krsort,shuffle
    查找函数：in_array,array_key_exists,array_search
    其他函数： count,array_reverse,array_merge,array_sum,array_keys,
                array_values,array_map,array_walk,range

-------------------------2.字符串------------------------------------------------
    字符串去除和填充：
    trim,ltrim,rtrim,
    str_pad(string,length,pad_string,pad_type) 把字符串填充为新的长度
    字符串连接与分割：explode() split() ;implode() join() str_split
    explode(".",$str) 函数把字符串打散为数组
    字符串截取：
    strchr(string,search,before_search)指定字符串中从左面开始的最后一次出现的位置 ( strstr() 函数的别名)
    strrchr(string,char) 函数查找字符串在另一个字符串中最后一次出现的位置，并返回从该位置到字符串结尾的所有字符。
    substr(string,start,length)返回字符串的一部分
    字符串替换：
    str_replace(find,replace,string,count) 以其他字符替换字符串中的一些字符
    substr_replace()
    字符串长度与位置
    strrpos() 函数查找字符串在另一字符串中最后一次出现的位置
    strlen()
    strpos()
    字符转换：
    strtolower() :将字符串转换成小写
    strtoupper():将字符转成大写
    ucfirst():将字符串首字符转换成大写
    strrev()字符串翻转
    lcfirst()
    ucwords()


    特殊字符处理：
    nl2br()
    addslashes()
    htmlspecialchars()
    htmlspecialchars_decode()


    strip_tags()剥去字符串中的 HTML、XML 以及 PHP 的标签
    mb_substr( $str, $start, $length, $encoding ) 中文字符串截取
    mb_strlen( $str, $encoding ) 获取中文长度
    decbin()十进制转换为二进制


    func_get_args()获取实参数据列表，成为数组
    func_get_arg(i)     获取第i个实参从0开始
    func_num_argus();      获取实参个数
-------------------------3.ip-------------------------------------
    gethostbyname('www.csdn.net'); 获取网站ip
    ip2long($ip)
    long2ip()
-------------------------4.时间---------constant()函数返回一个常量的值。-------------------------------
    strtotime("2009-9-2 10:30:45")将字符串转成Unix时间戳
    date("Y-m-d H:i:s",$unix_time)格式化Unix时间戳为正常时间格式
    time()
    microtime()
    mktime()
    date()
    idate()
    strtotome()
    date_add()
    date_diff()
    date_default_timezone_set()
    date_default_timezone_get()

---------------------------5.数学函数---------------------------------------------
max()
min()
round()
ceil()
floor()
abs()
sqrt()
pow()
rand()
---------------------------6.其他---------------------------------------------
unset();        //销毁数组，单个、多个变量