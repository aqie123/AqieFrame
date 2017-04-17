/*
define(function(require){
	var c={
		helloc:function(){
			console.dir("hello c");
			var a1 =require('a');
			a1.hello();
		}
	}
	return c;
})
*/
//第二种写法
define(['a'],function(a){
	var c={
		helloc:function(){
			console.dir("hello c");  //显示对象所有属性和方法
			
			a.hello();
		}
	}
	return c;
})