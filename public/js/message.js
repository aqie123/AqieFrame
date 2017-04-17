/**
 * 即时显示聊天内容
 * 利用ajax每隔两秒就去服务器获取一次聊天信息
 * 防止重复获取数据(已经获得的聊天信息最大id回传给服务器)
 */

// 执行ajax函数   从数据库读取信息
ajaxget('index.php?p=home&c=chat&a=getmsg',success);
function success(data) {
    var s = "";
    // data[i]['receiver']?data[i]['receiver']:'所有人'
    for(var i=0;i<data.length;++i){
        // 字符串拼接
        s+='<div class="message clearfix">' +
            '<div class="wrap-text"><h5 class="clearfix">'+(data[i]['sender']?data[i]['sender']:'游客')+
            '&nbsp;对&nbsp;'+(data[i]['receiver']?data[i]['receiver']:'所有人') + "&nbsp;说&nbsp;"+
            '</h5><div>' + data[i]['msg']+ '</div></div>' +
            '<div class="wrap-ri"><div class="clearfix"><span>' + data[i]['add_time']+
            '</span></div></div>' +
            '<div style="clear:both;"></div></div>';
        // 将已经获取到最大id赋给maxId

        // console.log(maxId);
    }
    document.getElementsByClassName('chat01_content')[0].innerHTML += s;
    // 滚动条始终在最下边
    $('#showdiv' ).scrollTop( $('.chat01_content')[0].scrollHeight );
}


setInterval("ajaxget('index.php?p=home&c=chat&a=getmsg',success)",2500);//每间隔2s就执行一次

var btn = document.getElementsByClassName('ajaxbtn')[0];
var chatform = document.getElementsByTagName('form')[0];

/**
 * 向数据库写入信息，成功话误操作
 * 失败话,弹出错误信息
 */
function sendmsg(){
    ajax2(chatform,'?p=home&c=chat&a=savemsg',function (data) {

    },function(data){
        alert(data.message);
    });
    $('textarea').val("");

}