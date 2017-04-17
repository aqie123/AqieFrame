<?php
// 商品类型控制器
class TypeController extends BaseController
{
    // 分页显示商品分类列表
    public function indexAction()
    {
        // 显示所有商品类型
        $typeModel = new TypeModel('goods_type');
        // 设置每页显示记录数 (不传默认5),数据可以不传，但是分页显示组件需要传
        $pagesize = 5;
        $types = $typeModel->showAllByPage($pagesize,'type_id',1);      //按照类型id倒序

        // 分页显示
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $total = $typeModel->totalRecords();
        //载入分页类
        $this->library('Page');
        $page = new Page($total,$pagesize,$currentPage,'index.php',
            array('p'=>'admin','c'=>'type','a'=>'index'));
        $pageinfo = $page->showPage();
        include CUR_VIEW_PATH . "goods_type_list.html";
    }

    public function addAction()
    {
        include CUR_VIEW_PATH . "goods_type_add.html";
    }

    public function insertAction()
    {
       // 1.收集表单
        $data['type_name'] = trim($_POST['type_name']);
        //2.验证和处理
        if ($data['type_name'] == '') {
            $this->jump('index.php?p=admin&c=type&a=add','商品类型名称不能为空');
        }
        $this->helper('input');
        $data = deepspecialchars($data);
        $data = deepslashes($data);
        //3.调用模型完成入库并给出提示
        $typeModel = new TypeModel('goods_type');
        if ($typeModel->insert($data)) {
            $this->jump('index.php?p=admin&c=type&a=index','添加成功',0);
        } else {
            $this->jump('index.php?p=admin&c=type&a=add','添加失败');
        }
    }

    public function editAction()
    {
        // 获取 id
        $type_id = $_GET['type_id'] + 0;
        // 获取当前这条记录
        $Model = new TypeModel('goods_type');
        $data = $Model->showOne($type_id);
        include CUR_VIEW_PATH . "goods_type_edit.html";
    }

    public function updateAction()
    {
        // 更新商品类型
        // 1.收集表单
        $data['type_name'] = trim($_POST['type_name']);
        $data['type_id'] = $_POST['type_id'];
        //2.验证和处理
        if ($data['type_name'] == '') {
            $this->jump("index.php?p=admin&c=type&a=edit&type_id={$data['type_id']}",'商品类型名称不能为空');
        }
        $this->helper('input');
        $data = deepspecialchars($data);
        $data = deepslashes($data);
        $typeModel = new TypeModel('goods_type');
        if ($typeModel->update($data)) {
            $this->jump('index.php?p=admin&c=type&a=index','修改商品类型成功',0);
        } else {
            $this->jump('index.php?p=admin&c=type&a=add','修改商品类型失败');
        }

    }
    public function deleteAction()
    {
        //1.获取type_id
        $type_id = $_GET['type_id'] + 0; //转换成整型
        //2.判断
        $Model = new TypeModel('goods_type');
        if ($Model->delete($type_id)) {
            $this->jump('index.php?p=admin&c=type&a=index','删除成功',2);
        } else {
            $this->jump('index.php?p=admin&c=type&a=index','删除失败');
        }
    }

}