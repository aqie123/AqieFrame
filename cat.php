<?php
echo '这是无限分类页面';
$cat = array(
	array('cat_id'=>1,'cat_name'=>'男女服装','parent_id'=>0),
	array('cat_id'=>2,'cat_name'=>'家用电器','parent_id'=>0),
	array('cat_id'=>3,'cat_name'=>'男装','parent_id'=>1),
	array('cat_id'=>4,'cat_name'=>'女装','parent_id'=>1),
	array('cat_id'=>5,'cat_name'=>'衬衫','parent_id'=>3),
	array('cat_id'=>6,'cat_name'=>'牛仔裤','parent_id'=>3),
	array('cat_id'=>7,'cat_name'=>'连衣裙','parent_id'=>4),
);

$res = array(
	array(
		'cat_id'=>1,
		'cat_name'=>'男女服装',
		'parent_id'=>0,
		'child' => array(
			array(
				'cat_id'=>3,
				'cat_name'=>'男装',
				'parent_id'=>1),
				'child' => array(
					array('cat_id'=>5,'cat_name'=>'衬衫','parent_id'=>3),
					array('cat_id'=>6,'cat_name'=>'牛仔裤','parent_id'=>3)
				),
			array(
				'cat_id'=>4,
				'cat_name'=>'女装',
				'parent_id'=>1,
				'child' => array(
					array('cat_id'=>7,'cat_name'=>'连衣裙','parent_id'=>4),
				)
			)
		)
	),
	array(
		'cat_id'=>2,
		'cat_name'=>'家用电器',
		'parent_id'=>0,
		'child' => array()
	),
);