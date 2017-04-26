var i=0;
//动态创建img添加到li里面
var arr =[
   {src:"./public/images/waterfall/1.png"},//json写法
   {src:"./public/images/waterfall/2.jpg"},
   {src:"./public/images/waterfall/3.jpg"},
   {src:"./public/images/waterfall/4.jpg"},
   {src:"./public/images/waterfall/5.jpg"},
   {src:"./public/images/waterfall/6.jpg"},
   {src:"./public/images/waterfall/7.jpg"},
   {src:"./public/images/waterfall/8.jpg"},
   {src:"./public/images/waterfall/9.jpg"},
   {src:"./public/images/waterfall/10.jpg"},
   {src:"./public/images/waterfall/11.jpg"},
   {src:"./public/images/waterfall/12.jpg"}
];
//create();
function create(){//自定义函数
	  var oDiv = document.createElement("div");
	  var oImg = new Image();//创建img图片对象
       //1%12=余1
	  oImg.src = arr[i%arr.length].src;//把图片路径赋值给img对象
	  oDiv.appendChild(oImg);//把img对象添加到div里面
	  //把div添加到需要添加的li（它的高度大于可视区域的高度与滚动条高度之和）里面
      //调用获取li列表方法
      getList($(".waterfall ul li")).append(oDiv);

}
function getList(obj){//封装
	//获取
	var length = obj.length;//获取Li的列数
	var h = Infinity;//无限高
	var getLi = '';
	for (var i=0;i<length;i++)
	{
    //第一次li列与无限高作比较
		if (obj.eq(i).height()<h)//循环获取每个li列与无限高作比较，小于就添加
		{
           h=obj.eq(i).height();//把成功的li高度赋值给h
           getLi =obj.eq(i);
		}
	}
	return getLi;
}
//封装一个生产图片方法
var sum = 0;
function onload(){
    i++;
    if(i<12)
    {
      for(i=0;i<12;i++){
        create();
      }
    }else{
       sum = i;
       for (i=0;i<sum+3;i++)
       {
         create();
       }
    }

}
onload();

var scrollH = 0;//保存文档高度
var scrollT = 0;//保存滚动条高度
var _height =$(window).height();//获取可视区域高度
$(window).scroll(function(){//滚动条高度发生变化，就触发
     scrollH = $(document).height();//文档高度
     scrollT = $(window).scrollTop();//滚动条高度
   
     //if((_height + scrollT+250 > scrollH )&&(_height + scrollT<6400)){
     if((_height + scrollT+250 > scrollH )){
           onload();
          // console.log(i);//在审查元素控制台打印
            
     }
});
