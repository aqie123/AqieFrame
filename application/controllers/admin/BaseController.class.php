<?php

/**
 * Class BaseController
 * 后台基础控制器
 */
class BaseController extends Controller
{
    public function __construct()
    {
        $this->checkLogin();
    }


    /**
     * 验证用户是否登录
     * 1.判断session是否存在登录标志符
     * 2.判断cookie是否存在id和密码
     */
    public function checkLogin()
    {
        // 排除一些方法不进行验证
        $curr_controller = strtolower(CONTROLLER);       // 转换成小写
        $curr_action = strtolower('ACTION');
        if($curr_controller == 'login' && ($curr_action == 'login' || $curr_action = 'signin' || $curr_action ='captcha')){
            return;
        }
        if(!isset($_SESSION['admin'])){
            //判断cookie是否记录登录状态(是否存在id和密码，并且一致)
            $adminModel = new AdminModel('admin');
            if(isset($_COOKIE['admin_id']) && isset($_COOKIE['admin_pass']) &&
                $admin_info = $adminModel->CheckCookieInfo($_COOKIE['admin_id'],$_COOKIE['admin_pass'])){
                // 具有登陆状态，设置session中登录标识
                $_SESSION['admin']= $admin_info;

            }else{
                $this->jump('index.php?p=admin&c=login&a=login','您还未登录');
            }

        }

    }

}