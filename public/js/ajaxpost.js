/**
 * 简易封装ajax函数
 * @param form    form获取表单
 * @param url     请求地址
 * @param success 成功回调函数
 * @param fail    失败回调函数
 */
function ajax(form,url,success,fail){
    form.onsubmit = function(evt){
        //1.收集用户输入表单信息
        var formData = new FormData(form);
        //2.信息提交给服务器端
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(xhr.readyState === 4 && xhr.status === 200){
                       // alert(xhr.responseText);             //正常
                       console.log(xhr.responseText);       // 正常
                // 字符串转换成对象
                data = JSON.parse(xhr.responseText);
                //eval("var data=" + xhr.responseText);
                // console.log(data);
                // alert(data.message);
                if(data.status){		// 值为1，表示成功
                    success(data);
                }else{
                    fail(data);
                }
            }
        };
        xhr.open('post',url);
        xhr.send(formData);
        // 阻止浏览器默认表单提交
        evt.preventDefault();
    }
}


function ajax2(form,url,success,fail){
        //1.收集用户输入表单信息
        var formData = new FormData(form);
        // console.log(formData);
        //2.信息提交给服务器端
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(xhr.readyState === 4 && xhr.status === 200){
                // console.log(xhr.responseText);       // 正常
                // 字符串转换成对象
                // xhr.responseText['message'])    这个是字符串大哥
                data = JSON.parse(xhr.responseText);
                //eval("var data=" + xhr.responseText);
                console.log(data);
                // alert(data.message);
                if(data.status){		// 值为1，表示成功
                    success(data);
                }else{
                    fail(data);
                }

            }
        };
        xhr.open('post',url);
        xhr.send(formData);
}