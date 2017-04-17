function getLength(str){  //获取字符串长度
  return str.replace(/[^\x00-xff]/g,"xx").length;
}

function getmsg(){
  var str = tara.value;
  str = getLength(str);
  return str>20 ? '页面字数超过20' : '页面字数小于等于20';
}

/**
  *获取url传值
  */

function GetQueryString(name)
{
   var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
   var url = window.location.search;
   url = decodeURI(url);
   var r = url.substr(1).match(reg);
   console.dir(r);
   if(r!=null)return  r[2]; return null;
}