<?php

/**
 * Class IndexController
 * 后台首页
 */
class IndexController extends BaseController
{
    // 生成验证码
    public function codeAction()
    {
        // 调用父类方法引入验证码图片
        $this->library('Captcha');      // 传递参数是文件名
        $captcha = new Captcha();
        $captcha->generateCode();
    }
    public function indexAction()
    {
        // echo 'aqie';
        include CUR_VIEW_PATH ."index.html";
    }
    public function topAction()
    {
        include CUR_VIEW_PATH ."top.html";
    }
    public function menuAction()
    {
        include CUR_VIEW_PATH ."menu.html";
    }
    public function dragAction()
    {
        include CUR_VIEW_PATH ."drag.html";
    }
    public function mainAction()
    {
        // 实例化模型类，并传入要查询表单
        $adminModel = new AdminModel('admin');
        $admins = $adminModel->getAdmins();
        echo "<pre>";
        var_dump($admins);
        include CUR_VIEW_PATH ."main.html";
    }
}