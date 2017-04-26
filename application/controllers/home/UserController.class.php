<?php
class UserController extends  Controller{
    // 加载前台登录页面
    public function msgloginAction(){
        $this->aqieplay();
    }

    /**
     * ajax前台注册模块
     */
    public function regAction(){
        // 实例化模型
        $userModel = new UserModel('user');
        // 注册表单不能留空
        if(in_array('', $_POST)){
            $this->message(array('message'=>'请确认表单信息完整性','status'=>0));
            die;
        }
        // 载入辅助函数
        $this->helper('input');
        // 批量实体转移
        $data = deepspecialchars($_POST);
        // 批量单引号转译
        $data = deepslashes($data);

        // 用户名不能重复
        $usercount = $userModel->totalRecords("user_name= '{$data['user_name']}'");
        if($usercount){
            $this->message(array('message'=>'用户名已经存在','status'=>0));die;
        }
        // 两次密码一致
        if($data['password'] != $data['confirm']){
            $this->message(array('message'=>'两次密码不一致','status'=>0));
            die;
        }
        $data['password'] = md5($data['password']);
        $data['reg_time'] = time();
        // 获取用户ip
        $data['user_ip'] = ip2long("{$this->getIP()}");

        if($userModel->insert($data)){
            $this->message(array('message'=>'注册成功','status'=>1));
            die;
        }else{
            $this->message(array('message'=>'注册失败','status'=>0));
            die;
        }
    }

    /**
     * ajax验证登录模块
     */
    public function checkloginAction(){
        if(in_array('', $_POST)){
            $this->message(array('message'=>'请确认表单信息完整性','status'=>0));
            die;
        }
        $this->helper('input');     // 载入辅助函数
        $data = deepspecialchars($_POST);   // 批量实体转移
        $data = deepslashes($data);         // 批量单引号转译
        //获取验证码
        $captcha = trim($data['code']);
        //先检查验证码 ，注意将二者大小写转成一致
        if (strtolower($_SESSION['captcha']) != $captcha ) {
            $this->message(array('message'=>'验证码输入错误','status'=>0));
            die;
        }
        // 调用模型
        $userModel = new UserModel('user');
        // 返回一维数组
        $res = $userModel->checkUser($data['username'],$data['password']);
        if ($res) {
            //登录成功,保存登录标识符到session
            $_SESSION['user'] = $res;
            // var_dump($_SESSION['admin']['user_name']);die;       // 显示用户名
            // 登陆成功
            $this->message(array('message'=>"{$_SESSION['user']['user_name']}登录成功",'status'=>1));
            die;
        } else {
            //失败
            $this->message(array('message'=>'用户名或密码错误','status'=>0));
            die;
        }
    }

    /**
     * 前台用户退出登录
     */
    public function logoutAction(){
        //销毁session变量
        unset($_SESSION['user']);
        //销毁session
        session_destroy();
        $this->jump('index.php?p=home&c=user&a=msglogin','','0');
    }

    /**
     * 加载用户列表
     * (加载控制器/方法名 ->方法名要和加载页面名一致)
     */
    public function userlistAction(){
        $token=md5(uniqid(rand(),true));
        $this->assign(['token'=>$token]);
        $userInfoModel = new UserInfoModel('user_info');
        // 获取用户全部信息
        $datas = $userInfoModel->getuserinfo();
        $this->assign(['datas'=>$datas]);
        $this->aqieplay();
    }

    /**
     * 接收用户详细信息表内容
     */
    public function userdetailAction(){
        $userInfoModel = new UserInfoModel('user_info');
        // 注册表单不能留空
        if(in_array('', $_POST)){
            $this->message(array('message'=>'请确认表单信息完整性','status'=>0));
            die;
        }
        $data = $_POST;
        if($userInfoModel->sqlinsert($data)){
            $this->message(array('message'=>'添加admin详细信息成功','status'=>1));
            die;
        }else{
            $this->message(array('message'=>'添加admin详细信息失败','status'=>0));
            die;
        }
    }

    /**
     * 删除用户信息，两张表
     */
    public function deluserAction(){
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $userInfoModel = new UserInfoModel('user_info');
            if($userInfoModel->deluser($id)){
                $this->message(array('message'=>'删除用户信息成功','status'=>1));
                die;
            }else{
                $this->message(array('message'=>'删除用户信息失败','status'=>0));
                die;
            }
        }
    }

    /**
     * 展示修改用户信息表
     * 获取用户详细信息
     */
    public function edituserAction(){
        $id = $_GET['id'];
        $userInfoModel = new UserInfoModel('user_info');
        $data = $userInfoModel->getdetailinfo($id);
        // var_dump($data);die;   // 成功拿到数据
        $this->assign(['data'=>$data]);
        $this->aqieplay();
    }

    /**
     * 数据库更新用户信息
     */
    public function updateuserAction(){
        $data = $_POST;
        $userInfoModel = new UserInfoModel('user_info');
        if($userInfoModel->updateuser($data)){
            $this->message(array('message'=>'修改用户信息成功','status'=>1));
            die;
        }else{
            $this->message(array('message'=>'修改用户信息失败','status'=>0));
            die;
        }

    }
}