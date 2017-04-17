<?php
/**
 * 前台模型
 */
class HomeModel extends Model{
    /**
     * 获取到登录用户名
     * @param $admin
     * @param $pwd
     * @return mixed
     */
    public function checkUser($admin,$pwd)
    {
        $pwd = md5($pwd);
        $sql = "SELECT * FROM {$this->table} WHERE user_name = '$admin' AND password = '$pwd' LIMIT 1";
//        echo $sql; exit;
        $res = $this->pdo->query($sql);
        $data = $res->fetch();                      // 返回一维数组(用来将用户名存进session)
        return $data;
    }

    /**
     * 验证用户名是否重复
     * 这个modle里面自带  totalRecords($where='')
     * @param $username
     */
    public function checkUsername($username){

    }
}