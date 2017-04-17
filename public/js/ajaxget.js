var maxId = 0;
function ajaxget(url,success){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(xhr.readyState === 4 && xhr.status === 200){
                 // console.log(xhr.responseText);       //   一直在请求数据。没有新数据写入，这里拿到是空
                // 字符串转换成对象
                if(xhr.responseText){
                    // console.log(xhr.responseText);          // 从数据库读取到数据
                    //eval("var data=" + xhr.responseText);       // data 是对象
                    data = JSON.parse(xhr.responseText);
                     // console.log(data);           // 获取服务器响应数据
                    // console.log(data[0]['add_time']);        拿到指定数据
                    success(data);
                    for(var i=0;i<data.length;++i){
                        // 将已经获取到最大id赋给maxId
                        maxId = data[i]['id'];
                    }
                }
            }
        };
        // console.log(maxId);
        xhr.open('get',url+"&maxId="+maxId);
        xhr.send(null);
}
