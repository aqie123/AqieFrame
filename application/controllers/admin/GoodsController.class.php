<?php
// 商品控制器
class GoodsController extends BaseController
{
    public function indexAction()
    {
        // 获取所有商品
        $goodsModel = new GoodsModel('goods');
        $pagesize = 5;
        // 当前页
        $current = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ( $current - 1 ) * $pagesize;
        $total = $goodsModel->totalRecords();
        // 获取总数目
        $goods = $goodsModel->showAllByPage($pagesize,'goods_id',1);
        // 载入分页类
        $this->library("Page");
        $page = new Page($total,$pagesize,$current,"index.php",array("p"=>"admin","c"=>"goods","a"=>"index"));
        $pageinfo = $page->showPage();

        // 分页获取所有商品分类
        $categoryModel = new CategoryModel('category');
        $cats = $categoryModel->showAll();                 // 调用父类model里面方法
        $cats = $categoryModel->tree($cats);
        // 获取所有品牌
        $brandModel = new BrandModel('brand');
        $brands = $brandModel->showAll();
        include CUR_VIEW_PATH . "goods_list.html";
    }

    // 显示添加商品页面
    public function addAction()
    {
        // 1.获取所有商品分类
        $categoryModel = new CategoryModel('category');
        $cates = $categoryModel->showAll();
        $cates = $categoryModel->tree($cates);      // 这里无限分类要拿到tree 函数重新排序的数据
        // 2.获取所有品牌
        $brandModel = new BrandModel('brand');
        $brands = $brandModel->showAll();
//        echo "<pre>";var_dump($brands);
        // 3.获取所有商品类型
        $typeModel = new typeModel('goods_type');
        $types = $typeModel->showAll();

        include CUR_VIEW_PATH . "goods_add.html";
    }

    // 添加商品信息
    public function insert22Action()
    {
        // 1.收集表单数据
        // 2.表单数据验证处理
        // 3.调用模型完成(商品插入)(属性数据)()

    }
    public function insertAction(){
        //1.收集表单数据
        $data['goods_name'] = trim($_POST['goods_name']);
        $data['goods_sn'] = trim($_POST['goods_sn']);
        $data['cat_id'] = $_POST['cat_id'];
        $data['brand_id'] = $_POST['brand_id'];
        $data['type_id'] = $_POST['type_id'];
        $data['shop_price'] = trim($_POST['shop_price']);
        $data['market_price'] = trim($_POST['market_price']);
        $data['promote_start_time'] = strtotime($_POST['promote_start_time']);
        $data['promote_end_time'] = strtotime($_POST['promote_end_time']);
        $data['goods_desc'] = trim($_POST['goods_desc']);
        $data['goods_number'] = trim($_POST['goods_number']);
        $data['is_best'] = isset($_POST['is_best']) ? $_POST['is_best'] : 0;
        $data['is_new'] = isset($_POST['is_new']) ? $_POST['is_new'] : 0;
        $data['is_best'] = isset($_POST['is_best']) ? $_POST['is_best'] : 0;
        $data['is_onsale'] = isset($_POST['is_onsale']) ? $_POST['is_onsale'] : 0;
        $data['add_time'] = time();
        //图片上传,上传类
        // 判断是否有图片上传
        if ($_FILES['goods_img']['tmp_name'] != '') {
            $this->library('Upload');
            $upload = new Upload();
            if ($filename = $upload->up($_FILES['goods_img'])) {
                //成功
                $data['goods_img'] = $filename;
            } else {
                //失败
                $this->jump('index.php?p=admin&c=goods&a=add',$upload->error());
            }
        }

        //2.验证和处理
        if ($data['goods_name'] == '') {
            $this->jump('index.php?p=admin&c=goods&a=add','名称不能为空');
        }
        //3.调用模型完成商品主数据的添加，在添加成功的同时，需要添加属性数据
        $goodsModel = new GoodsModel('goods');
        if ($goods_id = $goodsModel->insert($data)) {
            //成功,需要添加属性数据
            if (isset($_POST['attr_id_list'])) {
                $ids = $_POST['attr_id_list'];
                $values = $_POST['attr_value_list'];
                $prices = $_POST['attr_price_list'];
                //将数据插入到goods_attr表中,循环插入
                $model = new Model('goods_attr');
                foreach ($ids as $k => $v) {
                    $list['goods_id'] = $goods_id;
                    $list['attr_id'] = $v;
                    $list['attr_value'] =  $values[$k];
                    $list['attr_price'] =  $prices[$k];
                    //调用模型完成插入,借用model直接插入
                    $model->insert($list);
                }
            }
            $this->jump('index.php?p=admin&c=goods&a=index','添加成功');
        } else {
            //失败
            $this->jump('index.php?p=admin&c=goods&a=add','添加失败');
        }
    }

    public function editAction()
    {
        include CUR_VIEW_PATH . "goods_edit.html";
    }

    public function updateAction()
    {

    }
    public function deleteAction()
    {

    }

}