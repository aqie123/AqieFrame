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


    /**
     * 后台用户登录
     * @param $admin_name
     * @param $password
     * @return array
     * @throws Exception
     *  select from_unixtime(1494753098,'%Y-%m-%d %H:%i:%s');
     * date("Y-m-d",time());
     */
    public function register($admin_name,$password){
        $sql = "insert into aq_admin(admin_name,password,add_time) values(:admin_name,:password,:add_time)";

        $add_time = time();
        //var_dump($add_time);die;
        $password = md5($password);
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':admin_name',$admin_name);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':add_time',$add_time);
        // var_dump($sql);die;
        if(!$stmt->execute()){
            throw new Exception('注册失败',ErrorCode::REGISTER_FAIL);
        }
        return [
            'admin_name'=>$admin_name,
            'add_time' => $add_time
        ];
    }

}
