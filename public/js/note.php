<?php
/**
 * 关于留言板
 */
/*

ChatController里getmsgAction
将二维数组json_decode转换为json格式数组

ajaxget     从数据库获取聊天信息
将获取到json格式转换为对象
成功后回调函数,拼接字符串,显示在页面

ajaxpsot里面ajax2     实现向数据库写入数据
