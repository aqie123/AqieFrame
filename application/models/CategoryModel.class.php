<?php

/**
 * Class CategoryModel
 * 商品分类model
 * aq_category
 */
class CategoryModel extends Model
{
    /**
     * 后台获取商品分类
     * 指定一个cat_id,获取其后代所有分类的cat_id
     * @param $cat_id
     * @return array
     */
    public function getSubIds($cat_id){
        $cats = $this->showAll();
        $cats = $this->tree($cats,$cat_id);
        $ids = array();
        foreach ($cats as $cat) {
            $ids[] = $cat['cat_id'];
        }
        //将自己也追加进来
        $ids[] = $cat_id;
        return $ids;
    }

    /**
     * 返回给前台处理后商品分类
     * @return array
     */
    public function frontCats(){
        $cats = $this->showAll("",PDO::FETCH_ASSOC);
        return $this->tree2($cats);
    }

}