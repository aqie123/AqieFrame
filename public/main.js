require.config({
	paths:{     //相对于main.js
		a:'js/a',
		b:'js/b',
		c:'js/c'
	},
	shim:{
		b:{
			exports:'b'    //输出b模块
		}
	}

})

/*
require(['a'],function(a){
	a.hello();
})
*/

/*
require(['b'],function(b){   //shim可以加也可以不加
	hellob();
	hellob2();
})
*/


require(['a','c'],function(a,c){
	c.helloc();
})
