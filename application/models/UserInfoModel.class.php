<?php

/**
 * 前台用户其他信息模型
 * Class userInfoModel
 */
class userInfoModel extends Model{

    /**
     * @param $data
     * @return bool
     */
    public function sqlinsert($data){
        //$interest = implode(',',$data['hobby']);   // 开始值是文字
        $interest = array_sum($data['hobby']);         // 值改为通用数字
        $sql = "insert into aq_user_info (age,edu,hobby,area,user_id) ";
        $sql .= "values('{$data['age']}','{$data['edu']}','{$interest}','{$data['area']}','{$data['user_id']}')";
        // var_dump($sql);die;
        if($this->pdo->query($sql)){
            return $this->pdo->lastInsertId();
        }else{
            return false;
        }
    }

    /**
     * 获取用户全部信息
     */
    public function getuserinfo(){
        $sql = "select u.user_id,u.user_name,u.email,u.user_ip,u.reg_time,i.age,i.edu,i.hobby,i.area from ";
        $sql .= "aq_user as u inner join aq_user_info as i on u.user_id = i.user_id";
        // var_dump($sql);die;
        $result = $this->pdo->query($sql);
        $datas = $result->fetchAll(PDO::FETCH_ASSOC);
        return $datas;
    }

    /**
     * 获取用户详细信息
     */
    public function getdetailinfo($id){
        $sql = "select age,edu,hobby,area from aq_user_info where user_id=$id";
        $result = $this->pdo->query($sql);
        $data = $result->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    /**
     * @param $id (要删除的用户id)
     * @return bool
     * 数据库删除用户信息，两张表
     */
    public function deluser($id){
        $sql = "delete from aq_user_info where user_id=$id";
        if($this->pdo->query($sql)){
            $sql = "delete from aq_user where user_id=$id";
            if($this->pdo->query($sql)){
                return true;
            }
        }
        return false;
    }

    public function updateuser($data){

        $interest = array_sum($data['hobby']);
        $sql = "update aq_user_info set age = '{$data['age']}',edu = '{$data['edu']}',hobby='{$interest}',area='{$data['area']}' ";
        $sql .= "where user_id='{$data['id']}'";

        if($this->pdo->query($sql)){
            return true;
        }else{
            return false;
        }
    }
}