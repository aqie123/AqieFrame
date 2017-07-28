1.TCP(传输层) 通信协议
    ip层之上，应用层下
    面向连接，可靠地，基于字节流
    建立链接需要三次握手
2.HTTP(应用层)
    建立在tcp协议上的（应用层）协议，header+body
    比tcp更高级 短链接
    无状态
    a.header
        1.本次访问网址
        2.post/get 请求方式
        3.request 数据格式
        4.response connection
3.webSocket(应用层)
    长链接
    主流即时通讯协议
4.Socket(封装tcp接口，常驻内存):建立长连接基础

5.Telnet(客户端工具)
6.轮询机制 事件机制
7.MeepoPS
8.三次握手
9.访问网站流程
    客户机通过tcp/ip协议建立服务器的TCP协议
    客户端向服务器发送http协议请求
    服务器向客户机发送http协议应答包
    断开链接，客户端渲染html
10.多进程：系统进程 用户进程
           并发执行 性能更高
