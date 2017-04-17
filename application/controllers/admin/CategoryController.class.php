<?php

/**
 * Class CategoryController
 * 商品分类控制器
 */
class CategoryController extends BaseController
{
    // 显示分类信息
    public function indexAction()
    {
        // 获取所有分类信息
        $categoryModel = new CategoryModel('category');
        $datas = $categoryModel->showAll();                 // 调用父类model里面方法
        $datas = $categoryModel->tree($datas);
        include CUR_VIEW_PATH . "cat_list.html";
    }
    // 显示添加分类页面
    public function addAction()
    {
        //获取所有分类
        $categoryModel = new CategoryModel('category');     // 实例化对象
        $datas = $categoryModel->showAll();                  // 二维数组
        $datas = $categoryModel->tree($datas);


        include CUR_VIEW_PATH . "cat_add.html";
    }
    //完成商品分类入库
    public function insertAction()
    {
        // 接收表单数据

        $data['cat_name'] = trim($_POST['cat_name']);
        $data['unit'] = trim($_POST['unit']);
        $data['sort_order'] = trim($_POST['sort_order']);
        $data['cat_desc'] = trim($_POST['cat_desc']);
        $data['parent_id'] = $_POST['parent_id'];
        $data['is_show'] = $_POST['is_show'];

        // 载入辅助函数
        $this->helper('input');
        // 批量实体转移
        $data = deepspecialchars($data);
        // 批量单引号转译
        $data = deepslashes($data);
        // 对数据验证
        if ($data['cat_name'] == '' || $data['cat_desc'] == '') {
            $this->jump('index.php?p=admin&c=category&a=add','分类名称和描述不能为空');
        }

        //调用模型入库
        $categoryModel = new CategoryModel('category');
//         $categoryModel->getFields();     // 显示表字段
//        echo $categoryModel->insert($data); // 显示返回的插入数据
        if($categoryModel->insert($data)){
            $this->jump('index.php?p=admin&c=category&a=index','添加分类成功',2);
        } else {
            $this->jump('index.php?p=admin&c=category&a=add','添加分类失败');
        }



    }

    // 修改商品分类
    public function editAction()
    {
        // 获取 id
        $id = $_GET['cat_id'] + 0;
        // 获取当前这条记录
        $categoryModel = new CategoryModel('category');
        $data = $categoryModel->showOne($id);           //获取要修改的数据
        $datas = $categoryModel->showAll();             // 获取下拉框的数据
        $datas = $categoryModel->tree($datas);
        include CUR_VIEW_PATH . "cat_edit.html";
    }

    public function updateAction()
    {
        //1.收集表单数据
        $data['cat_name'] = trim($_POST['cat_name']);
        $data['unit'] = trim($_POST['unit']);
        $data['sort_order'] = trim($_POST['sort_order']);
        $data['cat_desc'] = trim($_POST['cat_desc']);
        $data['parent_id'] = $_POST['parent_id'];
        $data['is_show'] = $_POST['is_show'];
        $data['cat_id'] = $_POST['cat_id'];

        //实体转义(防止XSS攻击)
//        $data['cat_desc'] = htmlspecialchars($data['cat_desc']);
        // 载入辅助函数
        $this->helper('input');
        // 批量实体转移
        $data = deepspecialchars($data);
        $data = deepslashes($data);

        //2.验证及处理
        if ($data['cat_name'] == '') {
            $this->jump('index.php?p=admin&c=category&a=add','分类名称不能为空');
        }
        //不能将当前分类的后代或者自己作为其上级分类
        $categoryModel = new CategoryModel('category');         // 这里实例化对象，把数据表传进来
        $ids = $categoryModel->getSubIds($data['cat_id']);
        if (in_array($data['parent_id'], $ids)) {
            $this->jump("index.php?p=admin&c=category&a=edit&cat_id={$data['cat_id']}",
                '不能将当前分类的后代或者自己作为其上级分类');
        }
        //3.调用模型完成更新并给出提示

        if ($categoryModel->update($data)) {
            $this->jump('index.php?p=admin&c=category&a=index','修改分类成功',2);
        } else {
            $this->jump("index.php?p=admin&c=category&a=edit&cat_id={$data['cat_id']}",'修改分类失败');
        }

    }
    // 删除分类
    public function deleteAction()
    {
        //1.获取cat_id
        $cat_id = $_GET['cat_id'] + 0; //转换成整型
        //2.判断
        $categoryModel = new CategoryModel('category');
        $ids = $categoryModel->getSubIds($cat_id);
        if (count($ids) > 1) {
            $this->jump('index.php?p=admin&c=category&a=index','当前分类有后代分类，不能删除，请先删除后代分类');
        }
        //$res = $categoryModel->delete($cat_id);     // 删除的行数  1
        //3.调用模型完成删除并给出提示
        if ($categoryModel->delete($cat_id)) {
            $this->jump('index.php?p=admin&c=category&a=index','删除成功',2);
        } else {
            $this->jump('index.php?p=admin&c=category&a=index','删除失败');
        }

    }

}