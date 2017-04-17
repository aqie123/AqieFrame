<?php

/**
 * Class LoginController
 * 后台登录控制器
 */
class LoginController extends Controller                        // 不继承baseController，不然会进入死循环
{
    // 显示登录页面
    public function loginAction()
    {
        include CUR_VIEW_PATH ."login.html";
    }
    // 验证登录
    public function signinAction()
    {
        // 获取用户名密码
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        //对用户名和密码进行转义(防止)
        $username = addslashes($username);
        $password = addslashes($password);
        //获取验证码
        $captcha = trim($_POST['code']);
        //先检查验证码 ，注意将二者大小写转成一致
        if (strtolower($_SESSION['captcha']) != $captcha ) {
            $this->jump('index.php?p=admin&c=login&a=login','验证码输入错误');
        }
        //验证
        //调用模型
        $adminModel = new AdminModel('admin');
        $res = $adminModel->checkAdmin($username,$password);
        //echo "<pre>";                                       // 返回一维数组
        //var_dump($res);
        //die;
        if ($res) {
            //登录成功,保存登录标识符
            $_SESSION['admin'] = $res;
//            var_dump($_SESSION['admin']['admin_name']);die;       // 显示用户名
            //跳转
            $this->jump('index.php?p=admin&c=index&a=index','',0);
        } else {
            //失败
            $this->jump('index.php?p=admin&c=login&a=login','用户名或密码错误');
        }


    }
    // 退出登录
    public function logoutAction()
    {
        //销毁session变量
        unset($_SESSION['admin']);
        //销毁session
        session_destroy();
        $this->jump('index.php?p=admin&c=login&a=login','','0');
    }
    // 生成验证码
    public function captchaAction()
    {
        // 引入验证啊类
        $this->library('Captcha');
        $captcha = new Captcha();
        // 生成验证码
        $captcha->generateCode();
        // 验证码存入session
        $_SESSION['captcha'] = $captcha->getCode();
    }


}