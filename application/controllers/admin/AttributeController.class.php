<?php
// 商品属性控制器
class AttributeController extends BaseController
{
    //显示商品属性(指定类型下的所有属性)
    public function indexAction()
    {
        // 获取所有商品类型,并显示
        $typeModel = new TypeModel('goods_type');
        $types = $typeModel->showAll();
        // 获取type_id
        $type_id = empty($_GET['type_id']) ? 1 : $_GET['type_id'];      // 保证至少有一个，不然报错
        //获取当前的页数
        $current = isset($_GET['page']) ?  $_GET['page'] : 1;
        $pagesize = 5;
        $offset = ( $current - 1 ) * $pagesize;
        $attrModel = new AttributeModel('attribute');
        $attrs = $attrModel->getAttrs($type_id,$offset,$pagesize);
//        echo "<pre>"; var_dump($attrs); die;   // 连表查询结果

        // 载入分页类
        $this->library('Page');
        //获取总的记录数
        $where = "type_id = $type_id";
        $total = $attrModel->totalRecords($where);
        $page = new Page($total,$pagesize,$current,'index.php',
            array('p'=>'admin','c'=>'attribute','a'=>'index','type_id'=>$type_id));
        $pageinfo = $page->showPage();
        include CUR_VIEW_PATH . "attribute_list.html";
    }

    // 显示添加属性页面
    public function addAction()
    {
        // 获取所有商品类型
        $typeModel = new typeModel('goods_type');
        $types = $typeModel->showAll();

        include CUR_VIEW_PATH . "attribute_add.html";
    }

    public function insertAction()
    {
        //1.收集表单
        $data['attr_name'] = trim($_POST['attr_name']);
        $data['type_id'] = $_POST['type_id'];
        $data['attr_type'] = $_POST['attr_type'];
        $data['attr_input_type'] = $_POST['attr_input_type'];
        $data['attr_value'] = isset($_POST['attr_value']) ? $_POST['attr_value'] : '' ;
//        echo "<pre>";
//        var_dump($data);die;
        //2.验证处理
        if ($data['attr_name'] == '') {
            $this->jump('index.php?p=admin&c=attribute&a=add','属性名称不能为空');
        }
        $this->helper('input');
        $data = deepspecialchars($data);
        $data = deepslashes($data);
        //3.调用模型插入数据库
        $attrModel = new AttributeModel('attribute');
        if ($attrModel->insert($data)) {
            $this->jump("index.php?p=admin&c=attribute&a=index&type_id={$data['type_id']}",'添加成功',2);
        } else {
            $this->jump('index.php?p=admin&c=attribute&a=add','添加失败');
        }
    }

    public function editAction()
    {
        include CUR_VIEW_PATH . "attribute_edit.html";
    }

    public function updateAction()
    {

    }
    public function deleteAction()
    {

    }

    // 动态获取指定类型下面所有属性
    public function getAttrsAction(){
        //获取type_id
        $type_id = $_GET['type_id'] + 0;
        $attrModel = new AttributeModel('attribute');
//        $attrs = $type_id;            // 测试
        $attrs = $attrModel->getAttrsForm($type_id);
        echo <<<STR
        <script type="text/javascript">
          window.parent.document.getElementById("tbody-goodsAttr").innerHTML 
          = "$attrs";
        </script>
STR;
    }

}