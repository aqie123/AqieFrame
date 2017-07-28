--接口介绍（2924811900@qq.com）QAZ
准备：
    1.npm install -g localtunnel
    2.lt --subdomain klioen --port 8080 或 lt -s aqie -p 443
AppID : wx9449083b5b7bd70d
AppSecret: 06b563613266cfa822acb495d8bd2515


wxa6fe43f62cca764a
6ed07b334568778e7cada4009bdc94fb
1.事件推送
    a.订阅公众账号
2.加密/校验流程
    a.token.timestamp.nonce进行字典序排序
    b.三个参数字符串拼接成一个字符串进行sha1加密
    c.加密后字符串与signature对比，标识该请求来源于微信