<?php
// 基础模型类
class Model
{
    protected $pdo; //数据库连接对象
    protected $table;   // 表名
    protected $fields = array();    //字段列表
    public function __construct($table,$options=null)
    {
        $host = $GLOBALS['config']['host'];
        $user = $GLOBALS['config']['user'];
        $password = $GLOBALS['config']['password'];
        $dbname = $GLOBALS['config']['dbname'];
        $port = $GLOBALS['config']['port'];
        $options = $GLOBALS['config']['charset'];

        $dsn = "mysql:host={$host};port={$port};dbname={$dbname}";
        $opt= array(PDO::MYSQL_ATTR_INIT_COMMAND=>'set names '.$options);        // 类常量
        $this->pdo = new PDO($dsn,$user,$password,$opt);
        $this->table = $GLOBALS['config']['prefix'] . $table;

        //调用getFields字段方法
        $this->getFields();
    }
    private function __clone(){}
    /**
     * 获取表字段列表
     */
    private function getFields()
    {
        $sql = "DESC " . $this->table;
        // echo $sql;
        $result = $this->pdo->query($sql);
        $data = $result->fetchAll();
        // echo "<pre>";
        // var_dump($data);
        foreach ($data as $v) {
            $this->fields[] = $v["Field"];
            if ($v['Key'] == 'PRI') {
                //如果存在主键的话，则将其保存到变量$pk中
                $pk = $v['Field'];
            }
        }
        //如果存在主键，则将其加入到字段列表fields中
        if (isset($pk)) {
            $this->fields['pk'] = $pk;
        }
//         echo "<pre>";
//         var_dump($this->fields);
        // echo $this->fields['pk'];

    }

    /**
     * 自动插入单条记录
     * @access public
     * @param $list array 关联数组
     * @return mixed 成功返回插入的id，失败则返回false
     */
    public function insert($list)
    {
        $field_list = '';  //字段列表字符串
        $value_list = '';  //值列表字符串
        foreach ($list as $k=>$v) {
            if(in_array($k,$this->fields)){
                $field_list .= "`".$k."`" . ',';
                $value_list .= "'".$v."'" . ',';
            }
        }
        //去除右边的逗号
        $field_list = rtrim($field_list,',');
        $value_list = rtrim($value_list,',');
        //构造sql语句
        $sql = "INSERT INTO `{$this->table}` ({$field_list}) VALUES ($value_list)";
        // var_dump($sql);   // 直到打印出这个才发现上面循环错了
//            die;
        if($this->pdo->query($sql)){
            # 插入成功,返回最后插入的记录id
            return $this->pdo->lastInsertId();
        }else{
            # 插入失败，返回false
            return false;
        }

    }

    /**查询表中所有数据
     * @param string $where
     * @param int $fetchstyle
     * @param string $fields (有查询条件获取所有数据)
     * @return array (二维数组) both
     */
    public function showAll($where='',$fetchstyle=PDO::FETCH_BOTH,$fields="*")
    {
//        $sql = "select * from {$this->table}";
        if(empty($where)){
            $sql = "select {$fields} from {$this->table}";
        }else{
            $sql = "select {$fields} from {$this->table} where $where";
        }
//        var_dump($sql);die;
        $result = $this->pdo->query($sql);
        $data = $result->fetchAll($fetchstyle);     // 关联+索引数组
        return $data;
    }

    /**
     * 根据分页条件查询表中所有数据
     * @param int $pagesize     (分页页数)
     * @param string $orderby （按什么排序）
     * @param int $order  (1为倒序，0为正序)
     * @param string $where (查询条件)id=1
     * @return array   （二维数组）
     */
    public function showAllByPage($pagesize=5,$orderby='',$order=0,$where = ''){
        // 获得当前页
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1)*$pagesize;
        if(empty($where) && $order==0 && !empty($orderby) ){   // 提供排序条件,正序排列
            $sql = "select * from {$this->table} order by $orderby limit $offset,$pagesize";
        }elseif(empty($where) && $order==1 && !empty($orderby) ) {  // 提供排序条件和排序顺序(常用)
            $sql = "select * from {$this->table}  order by $orderby desc limit $offset, $pagesize ";
        }elseif(!empty($where) &&$order==1 && !empty($orderby) ){  // 四个参数都提供了，按查询条件倒序
            $sql = "select * from {$this->table}  where $where order by $orderby  desc limit $offset, $pagesize";
        }else{          // 什么都不填话，正序排列,每页五条数据
            $sql = "select * from {$this->table}  limit $offset, $pagesize ";
        }
//        var_dump($sql);die;
        $result = $this->pdo->query($sql);
        $data = $result->fetchAll();
        return $data;
    }

    /**
     * 根据传入主键查询一条数据
     * @param $pk
     * @return mixed 返回一维数组(both)
     */
    public function showOne($pk)
    {
        $sql = "select * from `{$this->table}` where `{$this->fields['pk']}`=$pk";
        $result = $this->pdo->query($sql);
        $data = $result->fetch();
        return $data;

    }

    /**
     * 获取总的记录数
     * @param string $where 查询条件，如"id=1"
     * @return mixed
     */
    public function totalRecords($where='')
    {
        if(empty($where)){
            $sql = "select * from {$this->table}";
        }else{
            $sql = "select * from {$this->table} where $where";
        }
//        echo $sql;die;
        $result = $this->pdo->query($sql);
        $data = $result->rowCount();
        return $data;                   // 这个需要验证  验证就是个数
    }

    /**
     * 更新单条数据
     * @param $list
     * @return bool|int
     */
    public function update($list)
    {
        $uplist = ''; //更新列表字符串
        $where = 0;   //更新条件,默认为0
        foreach ($list as $k => $v) {
            if (in_array($k, $this->fields)) {
                if ($k == $this->fields['pk']) {
                    # 是主键列，构造条件
                    $where = "`$k`=$v";
                } else {
                    # 非主键列，构造更新列表
                    $uplist .= "`$k`='$v'".",";
                }
            }
        }
        //去除uplist右边的
        $uplist = rtrim($uplist,',');
        //构造sql语句
        $sql = "UPDATE `{$this->table}` SET {$uplist} WHERE {$where}";
        $result = $this->pdo->query($sql);
        if($result){
            # 修改成功判断受影响记录数
            if($rows = $result->rowCount()){
                # 返回受影响的记录数
                return $rows;
            }else{
                # 没有更新操作
                return false;
            }
        }else{
            # 更新失败
            return false;
        }

    }

    // 不好实现(判断用户是否登陆成功)
    public function check(){

    }

    /**
     * 根据主键删除单条数据
     * @param $pk
     * @return bool|int
     */
    public function delete($pk)
    {
        $where = 0; //条件字符串
        //判断$pk是数组还是单值，然后构造相应的条件
        if (is_array($pk)) {
            # 数组
            $where = "`{$this->fields['pk']}` in (".implode(',', $pk).")";
        } else {
            # 单值
            $where = "`{$this->fields['pk']}`=$pk";
        }
        //构造sql语句
        $sql = "DELETE FROM `{$this->table}` WHERE $where";
        $result = $this->pdo->query($sql);              //结果集
        if($result){
            # 删除成功判断受影响记录数
            if($rows = $result->rowCount()){
                # 返回受影响的记录数
                return $rows;
            }else{
                # 没有被删除的数据
                return false;
            }
        }else{
            # 删除失败
            return false;
        }

    }

    /**
     * 后台商品无限分类
     * @param $arr
     * @param int $pid
     * @param int $level
     * @return array
     */
    public function tree($arr,$pid = 0,$level = 0)
    {
        static $res = array();
        foreach($arr as $v){
            if($v['parent_id'] == $pid){          // 父类id
                // 找到就先保存
                $v['level'] = $level;
                $res[] = $v;
                $before = str_repeat('--',$level);
                $before .= "递归调用之前(找到了pid=$pid 的后代分类[{$v['cat_name']}],并将其作为当前节点,查找子分类,本轮遍历挂起)".PHP_EOL;       // [$v['name']]
                // 改变条件，递归寻找当前分类的后代分类
                file_put_contents('./treelogbefore.txt',$before,FILE_APPEND);
                $this->tree($arr,$v['cat_id'],$level+1);            // 本身id
                $after = "当前[{$v['cat_name']}]下面没有子节点，返回到[{$v['cat_name']}]进行后续遍历".PHP_EOL;        // 递归调用之后()
                file_put_contents('./treelogafter.txt',$after,FILE_APPEND);
            }
        }
        return $res;
    }


    /**
     * 前台的商品分类
     * 将平行二维数组，转换成包含关系的多维数组
     * (遍历过程,改变了其结构)
     * @param $arr
     * @param int $pid
     * @return array
     */
    public function tree2($arr,$pid = 0){
        $res = array();
        foreach($arr as $v){
            if($v['parent_id'] == $pid){
                // 找到了,继续查找后代节点
                $temp = $this->tree2($arr,$v['cat_id']);
                // 将找到结果作为当前数组的一个元素来保存,下标是child
                $v['child'] = $temp;            // 这里定义的child
                $res[] = $v;
            }
        }
        return $res;

    }

}