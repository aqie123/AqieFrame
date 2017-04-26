<?php

/**
 * 前台首页 + 登录控制器
 * Class LoginController
 */
class IndexController extends Controller {
    // 加载首页
    public function indexAction(){
        // 获取所有商品分类
        $categoryModel = new CategoryModel('category');
        $cats = $categoryModel->frontCats();
        $goodsModel = new GoodsModel('goods');
        // 获取最新产品
        $is_news = $goodsModel->showAll('is_best = 1 AND is_new = 1',PDO::FETCH_ASSOC,"goods_id,goods_name,shop_price,goods_img");
        // 获取热销产品
        $is_hots = $goodsModel->showAll('is_best = 1 AND is_hot= 1',PDO::FETCH_ASSOC,"goods_id,goods_name,shop_price,goods_img");
        // 获取享购产品
        $is_bests = $goodsModel->showAll('is_best = 1 AND is_onsale = 1',PDO::FETCH_ASSOC,"goods_id,goods_name,shop_price,goods_img");
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



}