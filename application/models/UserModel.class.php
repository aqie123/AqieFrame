<?php

/**
 * 用户所在模型
 * Class UserModel
 */
class UserModel extends Model{
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
}