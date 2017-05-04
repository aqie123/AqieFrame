<?php

/**
 * Class LoginController
 * 后台登录控制器
 */
class LoginController extends BaseController
{
    // 显示登录页面
    public function loginAction()
    {
        $this->aqieplay();
    }
    // 验证登录
    public function signinAction()
    {
        //var_dump($_POST);die;
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
        //验证 调用模型
        $adminModel = new AdminModel('admin');
        // 返回一维数组 整条登陆信息
        $res = $adminModel->checkAdmin($username,$password);

        if ($res) {
            //登录成功,保存登录标识符,将admin信息保存到session
            $_SESSION['admin'] = $res;
            // 设置记录登录状态 在cookie 中添加这两个值
            if(isset($_POST['remember'])){
                // 在原始数据上，添加混淆字符串再加密(字段：用户id和用户密码)
                setcookie('admin_id',md5($res['admin_id'] . 'AQIE'),time()+3600);
                setcookie('admin_pass',md5($res['password'] . 'AQIE'),time()+3600);
            }
            $this->jump('index.php?p=admin&c=index&a=index','',0);
        } else {
            //失败
            $this->jump('index.php?p=admin&c=login&a=login','用户名或密码错误');
        }

    }

    /**
     * 后台用户退出登录
     */
    public function logoutAction()
    {
        //销毁session变量
        unset($_SESSION['admin']);
        //销毁session
        session_destroy();
        setcookie('admin_id',null,Time()-1);
        setcookie('admin_pass',null,Time()-1);
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