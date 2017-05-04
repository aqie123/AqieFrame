<?php

/**
 * Class AdminModel
 * 后台管理员模型
 * aq_admin
 */
class AdminModel extends Model
{

    // 获取所有管理员  (测试)
    public function getAdmins()
    {
        $sql = "select * from {$this->table}";
        $res = $this->pdo->query($sql);
        $data = $res->fetchAll(PDO::FETCH_ASSOC);       // 返回二维数组
        return $data;
    }
    /**
     * 验证用户名和密码
     * @param $admin
     * @param $pwd
     * @return mixed
     */
    public function checkAdmin($admin,$pwd)
    {
        $pwd = md5($pwd);
        $sql = "SELECT * FROM {$this->table} WHERE admin_name = '$admin' AND password = '$pwd' LIMIT 1";
        //echo $sql; exit;
        $res = $this->pdo->query($sql);
        $data = $res->fetch();                      // 返回一维数组(用来将用户名存进session)
        return $data;
    }


    public function checkCookieInfo($id,$pwd){
        // 加密方式进行比较

        $sql = "select * from {$this->table} where md5(concat(admin_id, 'AQIE'))='$id' ";
        $sql .= "and md5(concat(password,'AQIE'))='$pwd'";
        $res = $this->pdo->query($sql);
        $data = $res->fetch();
        return $data;
    }

}
