<?php

/**
 * 前台首页 + 登录控制器
 * Class LoginController
 */
class IndexController extends Controller {
    public function testAction(){
        $a = 'aqie';
        $this->assign(["name" =>$a]);
        $this->aqieplay();
    }
    // 加载首页
    public function indexAction(){
        // 获取所有商品分类
        $categoryModel = new CategoryModel('category');
        $cats = $categoryModel->frontCats();
//        echo "<pre>";var_dump($cats);die;
        $goodsModel = new GoodsModel('goods');
        // 获取最新产品
        $is_news = $goodsModel->showAll('is_best = 1 AND is_new = 1',PDO::FETCH_ASSOC,"goods_id,goods_name,shop_price,goods_img");
        // 获取热销产品
        $is_hots = $goodsModel->showAll('is_best = 1 AND is_hot= 1',PDO::FETCH_ASSOC,"goods_id,goods_name,shop_price,goods_img");
        // 获取想购产品
        $is_bests = $goodsModel->showAll('is_best = 1 AND is_onsale = 1',PDO::FETCH_ASSOC,"goods_id,goods_name,shop_price,goods_img");
//        echo "<pre>"; var_dump($is_best);die;
        include CUR_VIEW_PATH ."index.html";
    }
    //加载商品列表
    public function listAction(){
        include CUR_VIEW_PATH ."productlist.html";
    }
    // 加载商品详情页
    public function detailAction(){
        include CUR_VIEW_PATH ."productdetail.html";
    }
    // 加载购物车页面
    public function cartAction(){
        include CUR_VIEW_PATH ."cart.html";
    }
    // 加载订单购买页面
    public function cartlistAction(){
        include CUR_VIEW_PATH ."cartlist.html";
    }
    // 加载用户中心页面
    public function userinfoAction(){
        include CUR_VIEW_PATH ."userinfo.html";
    }
    // 加载收货地址
    public function addressAction(){
        include CUR_VIEW_PATH ."useraddress.html";
    }
    // 加载注册页面
    public function loginAction(){
        include CUR_VIEW_PATH ."userlogin.html";
    }
    // 加载注册页面
    public function registerAction(){
        include CUR_VIEW_PATH ."userregister.html";
    }
    // 加载订单展示页面 1
    public function orderdetailAction(){
        include CUR_VIEW_PATH ."orderdetail.html";
    }
    // 加载订单待付款页面 2
    public function obligationAction(){
        include CUR_VIEW_PATH ."orderobligation.html";
    }
    // 加载订单待发货页面 3
    public function backordersAction(){
        include CUR_VIEW_PATH ."orderbackorders.html";
    }
    // 加载订单待收货页面 4
    public function reciptAction(){
        include CUR_VIEW_PATH ."orderrecipt.html";
    }
    // 加载订单待收货页面
    public function completeAction(){
        include CUR_VIEW_PATH ."ordercomplete.html";
    }


    // 加载前台登录页面
    public function msgloginAction(){
        include CUR_VIEW_PATH ."msglogin.html";
    }


    //ajax注册模块
    public function regAction(){
        // 实例化模型
        $homeModel = new HomeModel('user');
//        print_r($_POST);
//        $data = implode(',',$_POST);
//        print_r($data);
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
        $usercount = $homeModel->totalRecords("user_name= '{$data['user_name']}'");
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
        // $this->message(array('message'=>$data['user_ip'] ,'status'=>0));
        // die;

        if($homeModel->insert($data)){
            /*
            $res =  array('message'=>'注册成功','status'=>1);
            $res = json_encode($res);
            echo $res;
            */
            $this->message(array('message'=>'注册成功','status'=>1));
            die;
        }else{
            $this->message(array('message'=>'注册失败','status'=>0));
            die;
        }
    }




    // ajax验证登录模块
    public function checkloginAction(){
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
        //获取验证码
        $captcha = trim($data['code']);
        //先检查验证码 ，注意将二者大小写转成一致
        if (strtolower($_SESSION['captcha']) != $captcha ) {
            $this->message(array('message'=>'验证码输入错误','status'=>0));
            die;
        }
        // 调用模型
        $homeModel = new HomeModel('user');
        // 返回一维数组
        $res = $homeModel->checkUser($data['username'],$data['password']);
        if ($res) {
            //登录成功,保存登录标识符到session
            $_SESSION['user'] = $res;
//            var_dump($_SESSION['admin']['user_name']);die;       // 显示用户名
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
     * 前台退出登录
     */
    public function logoutAction(){
        //销毁session变量
        unset($_SESSION['user']);
        //销毁session
        session_destroy();
        $this->jump('index.php?p=home&c=index&a=msglogin','','0');
    }
}