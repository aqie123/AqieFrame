<?php

/**
 * Class AttributeModel
 * 扩展属性模型
 */
class AttributeModel extends Model
{
    public function getAttrs($type_id,$offset,$limit){
        $type_table = $GLOBALS['config']['prefix'] . "goods_type";
        $sql = "select * from {$this->table} as a ";
        $sql .="       inner join $type_table as b ";
        $sql .="         on a.type_id = b.type_id";
        $sql .="        where a.type_id = $type_id";
        $sql .="        limit $offset,$limit";
        $result = $this->pdo->query($sql);
        return $data = $result->fetchAll();
    }

    public function getAttrsForm($type_id){
        // 获取所有属性
        $attrs = $this->showAll("type_id = $type_id");
//        echo "<pre>";var_dump($attrs);die;

        $res = "<table width='100%' id='attrTable'>";
        foreach ($attrs as $attr){
            $res .= "<tr>";
            $res .= "<td class='label'>{$attr['attr_name']}</td>";
            $res .= "<td>";
            $res .= "<input type='hidden' name='attr_id_list[]' value='{$attr['attr_id']}'>";
            switch ($attr['attr_input_type']) {
                case 0: #文本框
                    $res .= "<input name='attr_value_list[]' type='text' size='40'>";
                    break;
                case 1: #下拉列表
                    $res .= "<select name='attr_value_list[]'>";
                    $res .= "<option value=''>请选择...</option>";
                    $opts = explode(PHP_EOL, $attr['attr_value']);
                    foreach ($opts as $opt) {
                        $res .= "<option value='$opt'>$opt</option>";
                    }
                    $res .= "</select>";
                    break;
                case 2: #文本域
                    $res .= "<textarea name='attr_value_list[]'></textarea>";
                    break;
            }
            $res .= "<input type='hidden' name='attr_price_list[]' value='0'>";
            $res .= "</td>";
            $res .= "</tr>";
        }
        $res .= "</table>";
        return $res;
    }

}