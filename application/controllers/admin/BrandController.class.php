<?php

/**
 * Class BrandsController
 * 商品品牌
 */
class BrandController extends BaseController
{

    public function indexAction()
    {
        // 获取分页后所有品牌数据
        $brandModel = new BrandModel('brand');
        // 每页条数
        $pagesize = 5;
        // 当前页
        $current = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ( $current - 1 ) * $pagesize;
        // 获取总数目
        $total = $brandModel->totalRecords();
        // 得到分页后数据
        $brands = $brandModel->showAllByPage($pagesize,'brand_id',1);
        // 得到分页显示
        $this->library("Page");         // 载入分页类
        $page = new Page($total,$pagesize,$current,"index.php",array("p"=>"admin","c"=>"brand","a"=>"index"));
        $pageinfo = $page->showPage();
        include CUR_VIEW_PATH . "brand_list.html";
    }

    // 显示添加商品品牌页面
    public function addAction()
    {
        include CUR_VIEW_PATH . "brand_add.html";
    }

    // 添加商品品牌入库
    public function insertAction()
    {
        //接受表单提交过来的数据
        $data['brand_name'] = trim($_POST['brand_name']);
        $data['url'] = trim($_POST['url']);
        $data['brand_desc'] = trim($_POST['brand_desc']);
        $data['sort_order'] = trim($_POST['sort_order']);
        $data['is_show'] = trim($_POST['is_show']);
        //对提交过来的数据需要做一些验证、过滤等一些处理
        $this->helper("input");
        $data = deepspecialchars($data);  //实体转译
        $data = deepslashes($data);
        //处理文件上传
        $this->library("Upload"); //载入文件上传类
        $upload = new Upload(); //实例化上传对象

        $this->library("ImageZoom");    // 载入图片缩放类


        if($filename = $upload->up($_FILES['logo'])){       // $_FILES['上传图片name']
//            var_dump($filename);die;
            //成功
            $data['logo'] = $filename;      // 将文件名保存数据库
            if($filename != ""){
                $imagezom = new ImageZoom();
                $data['smalllogo'] = $imagezom->getimageZoom($filename);        // 生成缩略图 返回的是文件路径
                $data['stampogo'] = $imagezom->getimageStamp($filename);        // 生成水印图
            }else{
                $data['smalllogo'] = "";
                $data['stampogo'] = "";
            }
            $brandModel = new BrandModel('brand');
            if($brandModel->insert($data)){ // 数据存入数据库成功
                $this->jump("index.php?p=admin&c=brand&a=index","添加商品品牌成功",2);
            }else {//添加失败
                $this->jump("index.php?p=admin&c=brand&a=add","添加商品品牌失败",2);
            }
        }else{//文件上传失败
            $this->jump("index.php?p=admin&c=brand&a=add",$upload->error(),3);
        }

    }

    // 获取品牌数据到修改页面
    public function editAction()
    {
        //获取该品牌信息
        $brandModel = new BrandModel("brand");
        //条件
        $brand_id = $_GET['brand_id'] + 0; //出于考虑
        //使用模型获取
        $brand = $brandModel->showOne($brand_id);
        include CUR_VIEW_PATH . "brand_edit.html";
    }

    // 数据库完成品牌信息更新
    public function updateAction()
    {
        //获取条件及数据
        $data['brand_id'] = $_POST['brand_id'];
        $data['brand_name'] = trim($_POST['brand_name']);
        $data['brand_desc'] = trim($_POST['brand_desc']);
        $data['sort_order'] = trim($_POST['sort_order']);
        $data['url'] = trim($_POST['url']);
        $data['is_show'] = $_POST['is_show'];

        //判断图片是否有上传
        if($_FILES['logo']['name']){     //有上传，处理文件上传
            $this->library("Upload");    //载入文件上传类
            $upload = new Upload();     //实例化上传对象
            if($filename= $upload->up($_FILES['logo'])){              // 文件上传成功
                $brandModel = new BrandModel('brand');
                $brand = $brandModel->showOne($data['brand_id']);
                $img = UPLOAD_PATH . $brand['logo'];    // 之前图片地址
                $data['logo'] = $filename;      // 然后将文件名保存进数组
                $this->helper("input");             // 载入辅助函数
                $data = deepspecialchars($data);  //实体转译
                $data = deepslashes($data);
                if(unlink($img) && $brandModel->update($data)){ // 数据存入数据库成功,并且图片删除成功
                    $this->jump("index.php?p=admin&c=brand&a=index","更新商品品牌和图片成功",2);
                }else {//添加失败
                    $this->jump("index.php?p=admin&c=brand&a=add","更新商品品牌和图片失败",3);
                }
            }else{      // 文件上传失败
                $this->jump("index.php?p=admin&c=brand&a=add",$upload->error(),3);
            }
        }else{      // 没有图片上传，直接更新数据
            //调用模型完成更新
            $brandModel = new BrandModel("brand");
            if($brandModel->update($data)){
                $this->jump("index.php?p=admin&c=brand&a=index","更新商品品牌成功",2);
            }else{
                $this->jump("index.php?p=admin&c=brand&a=edit&brand_id=".$data['brand_id'],"更新商品品牌失败",2);
            }
        }

    }
    // 删除品牌及图片
    public function deleteAction()
    {
        $brand_id = $_GET['brand_id'] + 0;
        $brandModel = new BrandModel("brand");
        $brand = $brandModel->showOne($brand_id);
        //得到图片的全路径
        $img = UPLOAD_PATH . $brand['logo'];
//        var_dump($img);die;
        if ($brandModel->delete($brand_id) && unlink($img)){
            //成功删除品牌数据同时删除对应的图片
            $this->jump("index.php?p=admin&c=brand&a=index","删除品牌及图片成功",2);
        }else{
            $this->jump("index.php?p=admin&c=brand&a=index","删除失败",3);
        }

    }

}