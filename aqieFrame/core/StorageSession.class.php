<?php

/**
 *重写session数据区
 * 一：定义完成读和写的函数
 * 1.告知session机制，读写时使用用户自定义
 *
 */

/**
 * 调用时会将sessionid作为参数传递到函数中，需要形参接收传递id
 * 需要返回，读取到的session数据字符串，即sess_content字段内容
 * 没读到返回空字符串，表示没有session数据
 * @param string $sess_id
 * @return string 当前session数据区内容
 */

function sessionRead($sess_id)
{
    echo "<br>read";
    $mysqli = new mysqli('localhost','root','root',"product");
    $sql = "select sess_content from session where sess_id= '$sess_id'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    if($row){
        return $row['sess_content'];
    }else{
        return "";
    }

}

/**
 *执行写操作时(向数据库)，会将当前sessionID和需要写入内容(序列化好的)传递到函数
 * @param string $sess_id
 * @param string $sess_content(序列化的sessionID)
 * @return bool 写入结果
 */
function sessionWrite($sess_id,$sess_content)
{
    echo "<br>write";
    //利用sess_id判断是否存在，存在replace，不存在插入
    // replace into :如果主键存在，替换，否则插入
    $mysqli = new mysqli('localhost','root','root',"product");
    $sql = "replace into session values('$sess_id','$sess_content',unix_timestamp())";
    return $mysqli->query($sql);
}

/**
 * 销毁session时，session_destory();自动调用
 * 删除数据区，关闭session机制
 * begin->read->delete->end
 * @param  string $sess_id
 * @return bool  删除结果
 */
function sessionDelete($sess_id)
{
    echo "<br>delete";
    $mysqli = new mysqli('localhost','root','root',"product");
    $sql="delete from session where sess_id = '$sess_id'";
    return $mysqli->query($sql);
}

/**
 * 垃圾回收
 * (如果一个session区超过多久(距离最后一次写)没使用(默认1440=24min)，被视为垃圾数据)
 * lastwrite<当前时间-1440 (过期了)
 * 设置几率 session.gc_probability = 1  session.gc_divisor = 1000  （和请求频率相关）
 * @param  ini $maxlifetime 最大有效期(默认会把1440传过来)
 * @return
 */
function sessionGC($maxlifetime)
{
    echo "<br>GC";
    $mysqli = new mysqli('localhost','root','root',"product");
    $sql = "delete from session where last_write <unix_timestamp()-$maxlifetime";
    return $mysqli->query($sql);

}
function sessionBegin()
{
    echo "<br>begin";
    //连接数据库
    $mysqli = new mysqli('localhost','root','root',"product");
    $mysqli->query("set names 'utf8'");
    return true;
}

/**
 * 脚本周期结束执行
 */
function sessionEnd()
{
    echo "<br>end";
    return true;
}

//设置session 存储处理器函数
// begin->read->write->end
// begin->read->delete->end
/**
 * 先设置函数再开启session_start();  // php.ini session.auto_start = 0;
 *session.save_handler = files (默认以文件形式存储session)
 * 建议改为session.save_handler = user
 *
 */
session_set_save_handler(       //此函数调用时下面函数并不会被调用
    'sessionBegin','sessionEnd','sessionRead','sessionWrite','sessionDelete','sessionGC'
);
ini_set('session.save_handler','user');

